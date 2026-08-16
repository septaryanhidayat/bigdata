<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\KbmJournal;
use App\Models\Grade;
use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    /**
     * Modul 2.1: Jadwal Pelajaran Mingguan & Jurnal KBM
     */
    public function schedules()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $schedulesQuery = Schedule::with(['school', 'classroom', 'subject', 'teacher']);
        $classroomsQuery = Classroom::query();
        $teachersQuery = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR']);

        if ($schoolId) {
            $schedulesQuery->where('school_id', $schoolId);
            $classroomsQuery->where('school_id', $schoolId);
            $teachersQuery->where('school_id', $schoolId);
        }

        $schedules = $schedulesQuery->get();
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();
        $classrooms = $classroomsQuery->get();
        $subjects = $schoolId ? Subject::where('school_id', $schoolId)->get() : Subject::all();
        $teachers = $teachersQuery->get();
        if ($teachers->isEmpty()) {
            $teachers = $schoolId ? Employee::where('school_id', $schoolId)->get() : Employee::all();
        }

        return view('admin.academic.schedules', compact('schedules', 'schools', 'classrooms', 'subjects', 'teachers', 'schoolId'));
    }

    public function storeSchedule(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : $request->school_id;

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:employees,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $validated['school_id'] = $schoolId;
        $sch = Schedule::create($validated);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'JADWAL KBM',
                'model_type' => 'Schedule',
                'model_id' => $sch->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Jadwal Pelajaran Berhasil Ditambahkan!');
    }

    /**
     * Jurnal KBM Guru
     */
    public function journals()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $journalsQuery = KbmJournal::with(['schedule.classroom', 'schedule.subject', 'teacher']);
        $schedulesQuery = Schedule::with(['classroom', 'subject']);
        $teachersQuery = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR']);

        if ($schoolId) {
            $journalsQuery->whereHas('schedule', fn($q) => $q->where('school_id', $schoolId));
            $schedulesQuery->where('school_id', $schoolId);
            $teachersQuery->where('school_id', $schoolId);
        }

        $journals = $journalsQuery->latest()->paginate(15);
        $schedules = $schedulesQuery->get();
        $teachers = $teachersQuery->get();
        if ($teachers->isEmpty()) {
            $teachers = $schoolId ? Employee::where('school_id', $schoolId)->get() : Employee::all();
        }

        return view('admin.academic.journals', compact('journals', 'schedules', 'teachers'));
    }

    public function storeJournal(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'teacher_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $jrn = KbmJournal::create([
            'schedule_id' => $request->schedule_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'topic' => $request->topic,
            'notes' => $request->notes,
        ]);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'JURNAL KBM',
                'model_type' => 'KbmJournal',
                'model_id' => $jrn->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Catatan Jurnal KBM Guru Berhasil Disimpan!');
    }

    /**
     * Modul 2.2: Penilaian Multi-Kurikulum (K13 & Merdeka P5)
     */
    public function grades()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $gradesQuery = Grade::with(['student.classroom', 'subject', 'academicYear']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);

        if ($schoolId) {
            $gradesQuery->whereHas('student', fn($q) => $q->where('school_id', $schoolId));
            $studentsQuery->where('school_id', $schoolId);
        }

        $grades = $gradesQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
        if ($students->isEmpty()) {
            $students = $schoolId ? Student::where('school_id', $schoolId)->get() : Student::all();
        }
        $subjects = $schoolId ? Subject::where('school_id', $schoolId)->get() : Subject::all();
        $academicYears = AcademicYear::all();

        return view('admin.academic.grades', compact('grades', 'students', 'subjects', 'academicYears', 'schoolId'));
    }

    public function storeGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'type' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $grd = Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'academic_year_id' => $request->academic_year_id,
            'assessment_type' => $request->type,
            'competency_code' => 'TP-01',
            'score' => $request->score,
            'notes' => $request->notes,
        ]);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'PENILAIAN E-RAPOR',
                'model_type' => 'Grade',
                'model_id' => $grd->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Nilai Siswa Berhasil Diinput!');
    }

    /**
     * Modul 2.3: Cetak Rapor Siswa PDF Preview
     */
    public function reportCard($studentId)
    {
        $student = Student::with(['school', 'classroom.homeroomTeacher', 'guardian'])->findOrFail($studentId);
        $grades = Grade::where('student_id', $studentId)->with('subject')->get();
        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();

        return view('admin.academic.report_card', compact('student', 'grades', 'academicYear'));
    }
}
