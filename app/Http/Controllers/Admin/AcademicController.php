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
        $schoolId = session('dashboard_school_id', 'all');

        $schedulesQuery = Schedule::with(['school', 'classroom', 'subject', 'teacher']);
        $classroomsQuery = Classroom::query();
        $teachersQuery = Employee::whereIn('role_type', ['TEACHER', 'GURU'])->orWhere('type', 'GURU');

        if ($schoolId !== 'all') {
            $schedulesQuery->where('school_id', $schoolId);
            $classroomsQuery->where('school_id', $schoolId);
            $teachersQuery->where('school_id', $schoolId);
        }

        $schedules = $schedulesQuery->get();
        $schools = School::all();
        $classrooms = $classroomsQuery->get();
        $subjects = Subject::all();
        $teachers = $teachersQuery->get();
        if ($teachers->isEmpty()) {
            $teachers = ($schoolId !== 'all') ? Employee::where('school_id', $schoolId)->get() : Employee::all();
        }

        return view('admin.academic.schedules', compact('schedules', 'schools', 'classrooms', 'subjects', 'teachers', 'schoolId'));
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:employees,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

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
        $journals = KbmJournal::with(['schedule.classroom', 'schedule.subject', 'teacher'])->latest()->paginate(15);
        $schedules = Schedule::with(['classroom', 'subject'])->get();
        $teachers = Employee::whereIn('role_type', ['TEACHER', 'GURU'])->orWhere('type', 'GURU')->get();
        if ($teachers->isEmpty()) {
            $teachers = Employee::all();
        }

        return view('admin.academic.journals', compact('journals', 'schedules', 'teachers'));
    }

    public function storeJournal(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'teacher_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $schedule = Schedule::find($request->schedule_id);
        $validated['school_id'] = $schedule->school_id ?? 1;

        $jrn = KbmJournal::create($validated);

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
        $schoolId = session('dashboard_school_id', 'all');

        $gradesQuery = Grade::with(['student', 'subject', 'academicYear']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);

        if ($schoolId !== 'all') {
            $gradesQuery->where('school_id', $schoolId);
            $studentsQuery->where('school_id', $schoolId);
        }

        $grades = $gradesQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
        if ($students->isEmpty()) {
            $students = ($schoolId !== 'all') ? Student::where('school_id', $schoolId)->get() : Student::all();
        }
        $subjects = Subject::all();
        $academicYears = AcademicYear::all();

        return view('admin.academic.grades', compact('grades', 'students', 'subjects', 'academicYears', 'schoolId'));
    }

    public function storeGrade(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'type' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $student = Student::find($request->student_id);
        $validated['school_id'] = $student->school_id;

        // Auto compute predicate
        $score = $validated['score'];
        if ($score >= 90) $validated['predicate'] = 'A';
        elseif ($score >= 80) $validated['predicate'] = 'B';
        elseif ($score >= 70) $validated['predicate'] = 'C';
        else $validated['predicate'] = 'D';

        $grd = Grade::create($validated);

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
        $student = Student::with(['school', 'classroom', 'guardian'])->findOrFail($studentId);
        $grades = Grade::where('student_id', $studentId)->with('subject')->get();
        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();

        return view('admin.academic.report_card', compact('student', 'grades', 'academicYear'));
    }
}
