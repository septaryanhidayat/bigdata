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
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $schoolObj = $schoolId ? School::find($schoolId) : null;
        $schoolCode = $schoolObj?->code ?? null;

        $ppdbQuery = PpdbRegistration::with('school');

        if ($schoolId) {
            $ppdbQuery->where('school_id', $schoolId);
            if ($schoolCode) {
                $ppdbQuery->where(function($q) use ($schoolCode) {
                    $q->where('target_level', $schoolCode)
                      ->orWhere('target_level', 'like', "%{$schoolCode}%");
                });
            }
        }

        $registrations = $ppdbQuery->latest()->get();

        return view('admin.ppdb.index', compact('registrations', 'schoolId'));
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
            // Auto create student in Master Data with zero starting balances
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

            $student = Student::firstOrCreate(
                ['nis' => '2026' . str_pad($reg->id, 4, '0', STR_PAD_LEFT)],
                [
                    'school_id' => $targetSchoolId,
                    'classroom_id' => $classroomId,
                    'guardian_id' => $guardian?->id,
                    'nisn' => '006' . str_pad($reg->id, 7, '0', STR_PAD_LEFT),
                    'full_name' => $reg->full_name,
                    'gender' => 'M',
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
