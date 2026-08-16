<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficialLetter;
use App\Models\LetterDisposition;
use App\Models\LetterTemplate;
use App\Models\DigitalSignature;
use App\Models\LetterAuditTrail;
use App\Models\Employee;
use App\Models\School;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    /**
     * Dashboard Overview Persuratan & E-Office TTE
     */
    public function index(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');

        $lettersQuery = OfficialLetter::with(['school', 'digitalSignature', 'dispositions']);
        if ($schoolId !== 'all') {
            $lettersQuery->where('school_id', $schoolId);
        }

        $totalIncoming = (clone $lettersQuery)->where('type', 'INCOMING')->count();
        $totalOutgoing = (clone $lettersQuery)->where('type', 'OUTGOING')->count();
        $pendingTte = (clone $lettersQuery)->where('type', 'OUTGOING')->where('status', 'WAITING_SIGNATURE')->count();
        $activeDispositions = LetterDisposition::whereIn('status', ['PENDING', 'IN_PROGRESS'])->count();

        $recentLetters = (clone $lettersQuery)->latest()->take(10)->get();
        $recentDispositions = LetterDisposition::with(['letter', 'fromEmployee', 'toEmployee'])->latest()->take(6)->get();

        $schools = School::all();

        return view('admin.letters.index', compact(
            'totalIncoming', 'totalOutgoing', 'pendingTte', 'activeDispositions',
            'recentLetters', 'recentDispositions', 'schools', 'schoolId'
        ));
    }

    /**
     * Modul Surat Masuk (Inbox)
     */
    public function incoming(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $query = OfficialLetter::where('type', 'INCOMING')->with(['school', 'dispositions.toEmployee']);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('reference_number', 'like', "%{$s}%")
                  ->orWhere('agenda_number', 'like', "%{$s}%")
                  ->orWhere('sender', 'like', "%{$s}%");
            });
        }

        if ($request->filled('security_level')) {
            $query->where('security_level', $request->security_level);
        }

        $letters = $query->latest()->paginate(15);
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();
        $employees = $schoolId ? Employee::where('school_id', $schoolId)->where('is_active', true)->get() : Employee::where('is_active', true)->get();

        return view('admin.letters.incoming', compact('letters', 'schools', 'employees', 'schoolId'));
    }

    public function storeIncoming(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : ($request->school_id ?: null);

        $request->validate([
            'school_id' => 'nullable|exists:schools,id',
            'reference_number' => 'required|string',
            'title' => 'required|string',
            'sender' => 'required|string',
            'letter_date' => 'required|date',
            'received_date' => 'required|date',
            'security_level' => 'required|in:BIASA,SEGERA,KILAT,RAHASIA',
            'letter_category' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $agendaCount = OfficialLetter::where('type', 'INCOMING')->whereYear('created_at', date('Y'))->count() + 1;
        $agendaNumber = 'AGD-' . date('Y') . '-' . str_pad($agendaCount, 4, '0', STR_PAD_LEFT);

        $fileUrl = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'incoming_' . time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/letters'), $filename);
            $fileUrl = '/uploads/letters/' . $filename;
        }

        $letter = OfficialLetter::create([
            'school_id' => $schoolId,
            'type' => 'INCOMING',
            'letter_category' => $request->letter_category,
            'reference_number' => $request->reference_number,
            'agenda_number' => $agendaNumber,
            'title' => $request->title,
            'sender' => $request->sender,
            'recipient' => $request->recipient ?? 'Kepala Sekolah / Yayasan Robbani',
            'letter_date' => $request->letter_date,
            'received_date' => $request->received_date,
            'content' => $request->content,
            'file_url' => $fileUrl,
            'security_level' => $request->security_level,
            'status' => 'DISPATCHED',
            'created_by' => auth()->id(),
        ]);

        LetterAuditTrail::create([
            'letter_id' => $letter->id,
            'user_id' => auth()->id(),
            'action' => 'SURAT_MASUK_REGISTERED',
            'description' => "Mencatat surat masuk dari {$letter->sender} dengan No. Agenda {$agendaNumber}",
            'ip_address' => $request->ip(),
        ]);

        if ($request->filled('disposition_to')) {
            LetterDisposition::create([
                'letter_id' => $letter->id,
                'from_employee_id' => auth()->user()?->employee?->id ?? Employee::first()?->id ?? 1,
                'to_employee_id' => $request->disposition_to,
                'instruction' => $request->disposition_instruction,
                'notes' => $request->disposition_notes,
                'due_date' => $request->disposition_due_date ?? now()->addDays(3)->toDateString(),
                'status' => 'PENDING',
            ]);
        }

        return redirect()->back()->with('success', "✓ Surat Masuk Berhasil Dicatat dengan No. Agenda: {$agendaNumber}");
    }

    /**
     * Modul Surat Keluar (Outbox & Draft Engine)
     */
    public function outgoing(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $query = OfficialLetter::where('type', 'OUTGOING')->with(['school', 'digitalSignature.signer']);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('reference_number', 'like', "%{$s}%")
                  ->orWhere('recipient', 'like', "%{$s}%");
            });
        }

        $letters = $query->latest()->paginate(15);
        $templates = LetterTemplate::where('is_active', true)->get();
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();
        $employees = $schoolId ? Employee::where('school_id', $schoolId)->where('is_active', true)->get() : Employee::where('is_active', true)->get();

        return view('admin.letters.outgoing', compact('letters', 'templates', 'schools', 'employees', 'schoolId'));
    }

    public function storeOutgoing(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : ($request->school_id ?: null);

        $request->validate([
            'title' => 'required|string',
            'recipient' => 'required|string',
            'letter_category' => 'required|string',
            'letter_date' => 'required|date',
            'content' => 'required|string',
            'security_level' => 'required|in:BIASA,SEGERA,KILAT,RAHASIA',
        ]);

        $school = $schoolId ? School::find($schoolId) : null;
        $schoolCode = $school ? $school->code : 'YAYASAN-ROBBANI';
        $romanMonths = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
        $currentMonthRoman = $romanMonths[(int)date('n')];
        $currentYear = date('Y');

        $outCount = OfficialLetter::where('type', 'OUTGOING')->whereYear('created_at', $currentYear)->count() + 1;
        $categoryCodeMap = [
            'SURAT_EDARAN' => 'SE',
            'SURAT_TUGAS' => 'ST',
            'NOTA_DINAS' => 'ND',
            'SURAT_KETERANGAN' => 'SKet',
            'UNDANGAN' => 'UND',
            'SURAT_PANGGILAN' => 'SPG',
            'SURAT_KEPUTUSAN' => 'SK',
            'LAINNYA' => 'DIS',
        ];
        $catCode = $categoryCodeMap[$request->letter_category] ?? 'SRT';

        $generatedNumber = str_pad($outCount, 3, '0', STR_PAD_LEFT) . "/{$schoolCode}/{$catCode}/{$currentMonthRoman}/{$currentYear}";

        $status = $request->input('action_type') === 'SUBMIT_TTE' ? 'WAITING_SIGNATURE' : 'DRAFT';

        $letter = OfficialLetter::create([
            'school_id' => $schoolId,
            'type' => 'OUTGOING',
            'letter_category' => $request->letter_category,
            'reference_number' => $generatedNumber,
            'title' => $request->title,
            'sender' => $school ? $school->name : 'Yayasan Generasi Robbani',
            'recipient' => $request->recipient,
            'letter_date' => $request->letter_date,
            'content' => $request->content,
            'security_level' => $request->security_level,
            'status' => $status,
            'created_by' => auth()->id(),
        ]);

        LetterAuditTrail::create([
            'letter_id' => $letter->id,
            'user_id' => auth()->id(),
            'action' => $status === 'WAITING_SIGNATURE' ? 'SUBMITTED_FOR_TTE' : 'DRAFT_CREATED',
            'description' => "Membuat draf surat keluar No. {$generatedNumber} ({$letter->title})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "✓ Surat Keluar Berhasil Diterbitkan! Nomor Surat: {$generatedNumber}");
    }

    /**
     * Update Draft Surat Keluar
     */
    public function updateOutgoing(Request $request, $id)
    {
        $letter = OfficialLetter::findOrFail($id);

        if ($letter->status === 'SIGNED') {
            return redirect()->back()->with('error', 'Surat yang telah ditandatangani secara TTE tidak dapat diedit demi integritas hukum digital!');
        }

        $request->validate([
            'title' => 'required|string',
            'recipient' => 'required|string',
            'letter_date' => 'required|date',
            'content' => 'required|string',
            'security_level' => 'required|in:BIASA,SEGERA,KILAT,RAHASIA',
        ]);

        $status = $request->input('action_type') === 'SUBMIT_TTE' ? 'WAITING_SIGNATURE' : ($request->input('action_type') === 'SAVE_DRAFT' ? 'DRAFT' : $letter->status);

        $letter->update([
            'school_id' => $request->school_id ?: $letter->school_id,
            'title' => $request->title,
            'recipient' => $request->recipient,
            'letter_date' => $request->letter_date,
            'content' => $request->content,
            'security_level' => $request->security_level,
            'status' => $status,
        ]);

        LetterAuditTrail::create([
            'letter_id' => $letter->id,
            'user_id' => auth()->id(),
            'action' => 'DRAFT_UPDATED',
            'description' => "Memperbarui isi draf surat No. {$letter->reference_number} ({$letter->title})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "✓ Perubahan Surat No. {$letter->reference_number} Berhasil Disimpan!");
    }

    /**
     * Hapus Surat
     */
    public function destroy($id)
    {
        $letter = OfficialLetter::findOrFail($id);
        if ($letter->status === 'SIGNED') {
            return redirect()->back()->with('error', 'Surat yang sudah ber-TTE resmi tidak dapat dihapus!');
        }
        $letter->delete();
        return redirect()->back()->with('success', '✓ Dokumen Surat Berhasil Dihapus!');
    }

    /**
     * Modul Sistem Disposisi Pimpinan
     */
    public function dispositions(Request $request)
    {
        $query = LetterDisposition::with(['letter.school', 'fromEmployee', 'toEmployee']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dispositions = $query->latest()->paginate(15);
        $incomingLetters = OfficialLetter::where('type', 'INCOMING')->latest()->take(20)->get();
        $employees = Employee::where('is_active', true)->get();

        return view('admin.letters.dispositions', compact('dispositions', 'incomingLetters', 'employees'));
    }

    public function storeDisposition(Request $request)
    {
        $request->validate([
            'letter_id' => 'required|exists:official_letters,id',
            'to_employee_id' => 'required|exists:employees,id',
            'instruction' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        $disp = LetterDisposition::create([
            'letter_id' => $request->letter_id,
            'from_employee_id' => auth()->user()?->employee?->id ?? Employee::first()?->id ?? 1,
            'to_employee_id' => $request->to_employee_id,
            'instruction' => $request->instruction,
            'notes' => $request->notes,
            'due_date' => $request->due_date ?? now()->addDays(3)->toDateString(),
            'status' => 'PENDING',
        ]);

        LetterAuditTrail::create([
            'letter_id' => $request->letter_id,
            'user_id' => auth()->id(),
            'action' => 'DISPOSITION_ISSUED',
            'description' => "Disposisi diterbitkan untuk {$disp->toEmployee->full_name} dengan instruksi: {$disp->instruction}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "✓ Lembar Disposisi Berhasil Diterbitkan untuk {$disp->toEmployee->full_name}!");
    }

    public function updateDispositionStatus(Request $request, $id)
    {
        $disp = LetterDisposition::findOrFail($id);
        $status = $request->input('status', 'COMPLETED');
        $replyNotes = $request->input('reply_notes');

        $disp->update([
            'status' => $status,
            'reply_notes' => $replyNotes,
            'completed_at' => $status === 'COMPLETED' ? now() : null,
        ]);

        LetterAuditTrail::create([
            'letter_id' => $disp->letter_id,
            'user_id' => auth()->id(),
            'action' => 'DISPOSITION_' . $status,
            'description' => "Status disposisi diperbarui menjadi {$status}. Catatan: {$replyNotes}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "✓ Progres Disposisi Berhasil Diperbarui!");
    }

    /**
     * Modul Antrian TTE (Tanda Tangan Elektronik Internal)
     */
    public function tteQueue(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');
        $query = OfficialLetter::where('type', 'OUTGOING')->whereIn('status', ['WAITING_SIGNATURE', 'DRAFT'])->with(['school', 'digitalSignature']);

        if ($schoolId !== 'all') {
            $query->where('school_id', $schoolId);
        }

        $pendingLetters = $query->latest()->get();
        $signers = Employee::with('school')
            ->whereIn('role_type', ['HEADMASTER', 'TEACHER', 'STAFF'])
            ->orderByRaw("CASE WHEN school_id IS NULL THEN 1 WHEN role_type = 'HEADMASTER' THEN 2 ELSE 3 END")
            ->get();

        return view('admin.letters.tte_queue', compact('pendingLetters', 'signers', 'schoolId'));
    }

    /**
     * Eksekusi TTE Ber-Passphrase Internal
     */
    public function signLetter(Request $request, $id)
    {
        $request->validate([
            'passphrase' => 'required|string',
            'signer_employee_id' => 'required|exists:employees,id',
        ]);

        $letter = OfficialLetter::findOrFail($id);
        $signer = Employee::findOrFail($request->signer_employee_id);

        if (strlen($request->passphrase) < 4) {
            return redirect()->back()->with('error', 'Passphrase Pengesahan TTE minimal 4 karakter!');
        }

        // Generate SHA-256 Digest of the letter
        $hashData = $letter->reference_number . '|' . $letter->title . '|' . $letter->content . '|' . $signer->nip . '|' . now()->toIso8601String();
        $signatureHash = hash('sha256', $hashData);
        $verifyToken = Str::random(32);

        $certSerial = 'TTE-ROBBANI-' . strtoupper(Str::random(8)) . '-' . date('Y');

        DigitalSignature::updateOrCreate(
            ['letter_id' => $letter->id],
            [
                'signer_employee_id' => $signer->id,
                'certificate_issuer' => 'Sistem TTE Digital Internal SIT Robbani (SmartEdu Secure QR)',
                'certificate_serial' => $certSerial,
                'signature_hash' => $signatureHash,
                'verify_token' => $verifyToken,
                'signed_at' => now(),
                'ip_address' => $request->ip(),
                'passphrase_validated' => true,
                'status' => 'VALID',
            ]
        );

        $letter->update(['status' => 'SIGNED']);

        LetterAuditTrail::create([
            'letter_id' => $letter->id,
            'user_id' => auth()->id(),
            'action' => 'SIGNED_TTE_INTERNAL',
            'description' => "Dokumen ditandatangani secara elektronik (TTE Internal) oleh {$signer->full_name} (Serial: {$certSerial})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', "✓ TTE Elektronik Berhasil Disahkan! Dokumen No: {$letter->reference_number} telah dibubuhi QR Code resmi.");
    }

    /**
     * Bulk Signing (Tanda Tangan Massal)
     */
    public function bulkSign(Request $request)
    {
        $request->validate([
            'letter_ids' => 'required|array|min:1',
            'passphrase' => 'required|string',
            'signer_employee_id' => 'required|exists:employees,id',
        ]);

        $signer = Employee::findOrFail($request->signer_employee_id);
        $signedCount = 0;

        foreach ($request->letter_ids as $lid) {
            $letter = OfficialLetter::find($lid);
            if ($letter) {
                $hashData = $letter->reference_number . '|' . $letter->title . '|' . $letter->content . '|' . $signer->nip . '|' . now()->toIso8601String();
                $signatureHash = hash('sha256', $hashData);
                $verifyToken = Str::random(32);
                $certSerial = 'TTE-ROBBANI-BULK-' . strtoupper(Str::random(8)) . '-' . date('Y');

                DigitalSignature::updateOrCreate(
                    ['letter_id' => $letter->id],
                    [
                        'signer_employee_id' => $signer->id,
                        'certificate_issuer' => 'Sistem TTE Digital Internal SIT Robbani (SmartEdu Secure QR)',
                        'certificate_serial' => $certSerial,
                        'signature_hash' => $signatureHash,
                        'verify_token' => $verifyToken,
                        'signed_at' => now(),
                        'ip_address' => $request->ip(),
                        'passphrase_validated' => true,
                        'status' => 'VALID',
                    ]
                );

                $letter->update(['status' => 'SIGNED']);
                $signedCount++;
            }
        }

        return redirect()->back()->with('success', "✓ Berhasil menandatangani secara massal ({$signedCount} Dokumen Surat Keluar)!");
    }

    /**
     * Master Format Template Surat
     */
    public function templates()
    {
        $templates = LetterTemplate::latest()->get();
        return view('admin.letters.templates', compact('templates'));
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'content_template' => 'required|string',
        ]);

        $code = 'TPL-' . strtoupper(Str::random(5));

        LetterTemplate::create([
            'code' => $code,
            'name' => $request->name,
            'category' => $request->category,
            'format_number_pattern' => '{NO}/SIT-ROBBANI/{CAT}/{ROMAN_MONTH}/{YEAR}',
            'content_template' => $request->content_template,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', "✓ Template Dokumen Baru Berhasil Disimpan!");
    }

    /**
     * E-Filing & Pengarsipan Digital Virtual
     */
    public function archive(Request $request)
    {
        $query = OfficialLetter::with(['school', 'digitalSignature']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('year')) {
            $query->whereYear('letter_date', $request->year);
        }

        if ($request->filled('category')) {
            $query->where('letter_category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('reference_number', 'like', "%{$s}%")
                  ->orWhere('sender', 'like', "%{$s}%")
                  ->orWhere('recipient', 'like', "%{$s}%");
            });
        }

        $letters = $query->latest()->paginate(20);
        $schools = School::all();

        return view('admin.letters.archive', compact('letters', 'schools'));
    }

    /**
     * Cetak Preview PDF Surat Dinas Ber-TTE
     */
    public function previewPdf($id)
    {
        $letter = OfficialLetter::with(['school', 'digitalSignature.signer', 'creator'])->findOrFail($id);
        return view('admin.letters.official_pdf', compact('letter'));
    }

    /**
     * Tracking Timeline Alur Surat
     */
    public function tracking($id)
    {
        $letter = OfficialLetter::with(['school', 'digitalSignature.signer', 'dispositions.toEmployee', 'auditTrails.user'])->findOrFail($id);
        return response()->json([
            'letter' => $letter,
            'audit_trails' => $letter->auditTrails,
            'dispositions' => $letter->dispositions,
        ]);
    }
}
