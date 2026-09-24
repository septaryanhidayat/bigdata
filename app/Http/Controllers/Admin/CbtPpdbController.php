<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CbtExam;
use App\Models\CbtQuestion;
use App\Models\PpdbRegistration;
use App\Models\School;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\SppBill;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class CbtPpdbController extends Controller
{
    public function cbtIndex(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $examsQuery = CbtExam::with(['school', 'questions']);

        if ($schoolId) {
            $examsQuery->where('school_id', $schoolId);
        }

        $exams = $examsQuery->latest()->get();

        return view('admin.cbt.index', compact('exams', 'schoolId'));
    }

    public function storeCbtExam(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'total_questions' => 'nullable|integer|min:0',
        ]);

        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $targetSchoolId = $schoolId ?: ($request->school_id ?? School::first()?->id ?? 1);

        $exam = CbtExam::create([
            'school_id' => $targetSchoolId,
            'title' => $request->title,
            'subject_name' => $request->subject_name,
            'duration_minutes' => $request->duration_minutes,
            'total_questions' => $request->total_questions ?? 0,
            'start_time' => now(),
            'end_time' => now()->addDays(7),
            'status' => 'ACTIVE',
        ]);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BUAT PAKET CBT',
                'model_type' => 'CbtExam',
                'model_id' => $exam->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Paket Ujian CBT Baru berhasil dibuat!');
    }

    public function destroyExam($id)
    {
        $exam = CbtExam::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $exam->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus paket ujian ini.');
        }

        $exam->delete();
        return redirect()->back()->with('success', '✓ Paket Ujian CBT berhasil dihapus.');
    }

    public function ppdbIndex(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();
        $isGlobalAdmin = $user && ($user->isSuperAdmin() || $user->isYayasan() || $user->isHumas());

        $schools = School::orderBy('id')->get();

        $query = PpdbRegistration::with('school');

        // Scope to unit if unit admin
        if ($schoolId && !$isGlobalAdmin) {
            $query->where('school_id', $schoolId);
        } elseif ($request->filled('school_id') && $request->school_id !== 'all') {
            $query->where('school_id', $request->school_id);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%")
                  ->orWhere('previous_school', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Payment filter
        if ($request->filled('fee_paid') && $request->fee_paid !== 'all') {
            $query->where('fee_paid', (bool)$request->fee_paid);
        }

        // Calculate statistics
        $statsBaseQuery = clone $query;
        $totalCount = (clone $statsBaseQuery)->count();
        $pendingCount = (clone $statsBaseQuery)->where('status', 'PENDING')->count();
        $passedCount = (clone $statsBaseQuery)->where('status', 'PASSED')->count();
        $rejectedCount = (clone $statsBaseQuery)->where('status', 'REJECTED')->count();
        $totalRevenue = (clone $statsBaseQuery)->where('fee_paid', true)->sum('registration_fee');

        $registrations = $query->latest()->get();

        return view('admin.ppdb.index', compact(
            'registrations',
            'schools',
            'schoolId',
            'isGlobalAdmin',
            'totalCount',
            'pendingCount',
            'passedCount',
            'rejectedCount',
            'totalRevenue'
        ));
    }

    public function storePpdbAdmin(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'full_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
            'target_level' => 'nullable|string|max:50',
            'previous_school' => 'nullable|string|max:255',
            'registration_fee' => 'required|numeric|min:0',
            'fee_paid' => 'nullable',
            'status' => 'required|in:PENDING,DOCUMENT_VERIFIED,PASSED,REJECTED',
            'nik' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'gender' => 'nullable|in:M,F,L,P',
            'address' => 'nullable|string',
        ]);

        $school = School::findOrFail($request->school_id);
        $user = auth()->user();
        $userSchoolId = $user?->getEffectiveSchoolId();
        if ($userSchoolId && !$user->isSuperAdmin() && !$user->isYayasan() && $school->id != $userSchoolId) {
            return redirect()->back()->with('error', '⛔ Akses ditolak: Anda hanya dapat menambahkan calon siswa ke unit sekolah Anda sendiri.');
        }

        $code = strtoupper($school->code ?? 'ROBBANI');
        $regNumber = 'SPMB-2026-' . $code . '-' . rand(10000, 99999);

        $details = [
            'nama_lengkap' => $request->full_name,
            'nama_ayah' => $request->parent_name,
            'no_hp_ayah' => $request->phone_number,
            'sekolah_asal' => $request->previous_school,
            'nik_siswa' => $request->nik,
            'nisn' => $request->nisn,
            'jenis_kelamin' => in_array($request->gender, ['M', 'L']) ? 'Laki-laki' : 'Perempuan',
            'alamat' => $request->address ?? 'Alamat Siswa',
            'registration_fee' => (float)$request->registration_fee,
            'is_offline_walkin' => true,
            'created_by_user' => $user?->name ?? 'Admin TU',
            'submitted_at' => now()->toDateTimeString(),
        ];

        $reg = PpdbRegistration::create([
            'school_id' => $school->id,
            'registration_number' => $regNumber,
            'full_name' => $request->full_name,
            'parent_name' => $request->parent_name,
            'phone_number' => $request->phone_number,
            'target_level' => $request->target_level ?: $code,
            'previous_school' => $request->previous_school ?? '-',
            'status' => $request->status,
            'registration_fee' => (float)$request->registration_fee,
            'fee_paid' => (bool)$request->input('fee_paid', false),
            'details_json' => $details,
        ]);

        if ($reg->status === 'PASSED') {
            $this->provisionSmartEduStudent($reg);
        }

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'TAMBAH PENDAFTAR SPMB MANUAL (OFFLINE)',
                'model_type' => 'PpdbRegistration',
                'model_id' => $reg->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', "✓ Pendaftaran offline calon siswa {$reg->full_name} berhasil ditambahkan dengan nomor: {$regNumber}!");
    }

    public function detailPpdb($id)
    {
        $reg = PpdbRegistration::with('school')->findOrFail($id);
        $user = auth()->user();
        $userSchoolId = $user?->getEffectiveSchoolId();
        if ($userSchoolId && !$user->isSuperAdmin() && !$user->isYayasan() && $reg->school_id != $userSchoolId) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $details = $reg->details_json ?? [];
        $uploadedDocs = $details['uploaded_docs'] ?? [];

        // Check if student is integrated in master data
        $existingStudent = Student::where('nis', '2026' . str_pad($reg->id, 4, '0', STR_PAD_LEFT))
            ->orWhere('nisn', $details['nisn'] ?? '___')
            ->first();

        return response()->json([
            'id' => $reg->id,
            'registration_number' => $reg->registration_number,
            'full_name' => $reg->full_name,
            'school_name' => $reg->school?->name ?? $reg->target_level,
            'target_level' => $reg->target_level,
            'parent_name' => $reg->parent_name,
            'phone_number' => $reg->phone_number,
            'previous_school' => $reg->previous_school,
            'status' => $reg->status,
            'registration_fee' => $reg->registration_fee,
            'fee_paid' => $reg->fee_paid,
            'created_at' => $reg->created_at ? $reg->created_at->translatedFormat('d F Y H:i') : '-',
            'pdf_url' => route('admin.ppdb-admin.download-pdf', $reg->id),
            'details' => $details,
            'uploaded_docs' => $uploadedDocs,
            'is_integrated' => $existingStudent !== null,
            'student_nis' => $existingStudent?->nis,
        ]);
    }

    public function updatePpdbAdmin(Request $request, $id)
    {
        $reg = PpdbRegistration::findOrFail($id);
        $user = auth()->user();
        $userSchoolId = $user?->getEffectiveSchoolId();
        if ($userSchoolId && !$user->isSuperAdmin() && !$user->isYayasan() && $reg->school_id != $userSchoolId) {
            return redirect()->back()->with('error', '⛔ Akses ditolak: Calon siswa ini bukan dari unit sekolah Anda.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
            'previous_school' => 'nullable|string|max:255',
            'registration_fee' => 'required|numeric|min:0',
            'fee_paid' => 'nullable',
            'status' => 'required|in:PENDING,DOCUMENT_VERIFIED,PASSED,REJECTED',
        ]);

        $oldStatus = $reg->status;
        $newStatus = $request->status;

        $details = $reg->details_json ?? [];
        $details['nama_lengkap'] = $request->full_name;
        $details['nama_ayah'] = $request->parent_name;
        $details['no_hp_ayah'] = $request->phone_number;
        $details['sekolah_asal'] = $request->previous_school;
        if ($request->filled('nisn')) {
            $details['nisn'] = $request->nisn;
        }
        if ($request->filled('address')) {
            $details['alamat'] = $request->address;
        }

        $reg->update([
            'full_name' => $request->full_name,
            'parent_name' => $request->parent_name,
            'phone_number' => $request->phone_number,
            'previous_school' => $request->previous_school ?? $reg->previous_school,
            'registration_fee' => (float)$request->registration_fee,
            'fee_paid' => (bool)$request->input('fee_paid', false),
            'status' => $newStatus,
            'details_json' => $details,
        ]);

        // If status changed to PASSED, auto-provision
        if ($newStatus === 'PASSED' && $oldStatus !== 'PASSED') {
            $this->provisionSmartEduStudent($reg);
        }

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => "UPDATE DATA PPDB ID #{$reg->id} (STATUS: {$newStatus})",
                'model_type' => 'PpdbRegistration',
                'model_id' => $reg->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', "✓ Data calon siswa {$reg->full_name} berhasil diperbarui!");
    }

    public function updatePpdbStatus(Request $request, $id)
    {
        $reg = PpdbRegistration::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $reg->school_id && $reg->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Calon siswa ini bukan dari unit sekolah Anda.');
        }

        $newStatus = in_array($request->status, ['PENDING', 'DOCUMENT_VERIFIED', 'PASSED', 'REJECTED'])
            ? $request->status
            : 'PASSED';

        $reg->update(['status' => $newStatus]);

        if ($newStatus === 'PASSED') {
            $this->provisionSmartEduStudent($reg);
        }

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'PPDB SET STATUS (' . $newStatus . ')',
                'model_type' => 'PpdbRegistration',
                'model_id' => $reg->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Status Kelulusan Pendaftar PPDB berhasil diperbarui!');
    }

    public function destroyPpdb($id)
    {
        $reg = PpdbRegistration::findOrFail($id);
        $user = auth()->user();
        $userSchoolId = $user?->getEffectiveSchoolId();
        if ($userSchoolId && !$user->isSuperAdmin() && !$user->isYayasan() && $reg->school_id != $userSchoolId) {
            return redirect()->back()->with('error', '⛔ Akses ditolak: Anda tidak berwenang menghapus pendaftar unit lain.');
        }

        $studentName = $reg->full_name;
        $regNumber = $reg->registration_number;
        $reg->delete();

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => "HAPUS PENDAFTAR PPDB ({$regNumber} - {$studentName})",
                'model_type' => 'PpdbRegistration',
                'model_id' => $id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', "✓ Data pendaftaran {$studentName} ({$regNumber}) berhasil dihapus.");
    }

    public function exportPpdb(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();
        $isGlobalAdmin = $user && ($user->isSuperAdmin() || $user->isYayasan() || $user->isHumas());

        $query = PpdbRegistration::with('school');

        if ($schoolId && !$isGlobalAdmin) {
            $query->where('school_id', $schoolId);
        } elseif ($request->filled('school_id') && $request->school_id !== 'all') {
            $query->where('school_id', $request->school_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $records = $query->latest()->get();

        $filename = 'SPMB_Robbani_' . date('Ymd_His') . '.csv';

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Microsoft Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'No. Registrasi',
                'Nama Calon Siswa',
                'Unit Sekolah',
                'Nama Orang Tua',
                'No. WhatsApp',
                'Sekolah Asal',
                'Biaya Formulir',
                'Status Bayar',
                'Status Kelulusan',
                'Tanggal Pendaftaran'
            ]);

            foreach ($records as $r) {
                fputcsv($file, [
                    $r->registration_number,
                    $r->full_name,
                    $r->school?->name ?? $r->target_level,
                    $r->parent_name,
                    $r->phone_number,
                    $r->previous_school,
                    $r->registration_fee,
                    $r->fee_paid ? 'LUNAS' : 'BELUM LUNAS',
                    $r->status,
                    $r->created_at ? $r->created_at->format('Y-m-d H:i') : '-',
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Auto provision Student, Guardian, Classroom, and SPP bill in SmartEdu
     */
    protected function provisionSmartEduStudent(PpdbRegistration $reg)
    {
        $targetSchoolId = $reg->school_id ?? School::first()?->id ?? 1;
        $classroomId = Classroom::where('school_id', $targetSchoolId)->first()?->id;

        $guardian = null;
        if ($reg->parent_name) {
            try {
                $guardian = Guardian::firstOrCreate(
                    ['phone' => $reg->phone_number],
                    [
                        'full_name' => $reg->parent_name,
                        'type' => 'FATHER',
                        'occupation' => 'Wali Calon Siswa',
                    ]
                );
            } catch (\Throwable $e) {}
        }

        $details = $reg->details_json ?? [];
        $nisn = $details['nisn'] ?? ('006' . str_pad($reg->id, 7, '0', STR_PAD_LEFT));

        $student = Student::firstOrCreate(
            ['nis' => '2026' . str_pad($reg->id, 4, '0', STR_PAD_LEFT)],
            [
                'school_id' => $targetSchoolId,
                'classroom_id' => $classroomId,
                'guardian_id' => $guardian?->id,
                'nisn' => $nisn,
                'full_name' => $reg->full_name,
                'gender' => isset($details['jenis_kelamin']) && str_starts_with(strtolower($details['jenis_kelamin']), 'p') ? 'F' : 'M',
                'rfid_tag' => null,
                'savings_balance' => 0,
                'canteen_balance' => 0,
                'status' => 'ACTIVE',
            ]
        );

        // Auto create initial SPP bill in Finance Module
        try {
            $academicYear = AcademicYear::where('is_active', true)->first() ?? AcademicYear::first();
            SppBill::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'month_period' => date('F Y'),
                ],
                [
                    'school_id' => $targetSchoolId,
                    'academic_year_id' => $academicYear ? $academicYear->id : 1,
                    'amount' => 350000,
                    'discount_amount' => 0,
                    'paid_amount' => 0,
                    'status' => 'UNPAID',
                    'due_date' => now()->endOfMonth()->toDateString(),
                ]
            );
        } catch (\Throwable $e) {}
    }

    public function downloadSpmbPdf($id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $registration->school_id && $registration->school_id != $schoolId) {
            abort(403, 'Akses ditolak: Pendaftaran ini milik unit sekolah lain.');
        }

        $settings = [];
        return view('school.spmb_pdf', compact('registration', 'settings'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'cbt_exam_id' => 'required|exists:cbt_exams,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'nullable|string',
            'option_d' => 'nullable|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',
            'score_weight' => 'nullable|numeric|min:0',
        ]);

        $exam = CbtExam::findOrFail($request->cbt_exam_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $exam->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Ujian ini bukan dari unit sekolah Anda.');
        }

        $question = CbtQuestion::create([
            'cbt_exam_id' => $exam->id,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_answer' => strtoupper($request->correct_answer),
            'score_weight' => $request->score_weight ?? 1.00,
        ]);

        // Sync total questions count with actual database count
        $exam->update([
            'total_questions' => $exam->questions()->count()
        ]);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'INPUT SOAL CBT',
                'model_type' => 'CbtQuestion',
                'model_id' => $question->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', "✓ Butir soal baru berhasil disimpan ke Bank Soal paket: {$exam->title}!");
    }
}
