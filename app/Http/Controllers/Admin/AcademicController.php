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
        $schedules = Schedule::with(['school', 'classroom', 'subject', 'teacher'])->get();
        $schools = School::all();
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        $teachers = Employee::where('type', 'GURU')->get();

        return view('admin.academic.schedules', compact('schedules', 'schools', 'classrooms', 'subjects', 'teachers'));
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

        Schedule::create($validated);

        return redirect()->back()->with('success', 'Jadwal Pelajaran Berhasil Ditambahkan!');
    }

    /**
     * Jurnal KBM Guru
     */
    public function journals()
    {
        $journals = KbmJournal::with(['schedule.classroom', 'schedule.subject', 'teacher'])->latest()->paginate(15);
        $schedules = Schedule::with(['classroom', 'subject'])->get();
        $teachers = Employee::where('role_type', 'TEACHER')->orWhere('type', 'GURU')->get();

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
        $validated['school_id'] = $schedule->school_id;

        KbmJournal::create($validated);

        return redirect()->back()->with('success', 'Catatan Jurnal KBM Guru Berhasil Disimpan!');
    }

    /**
     * Modul 2.2: Penilaian Multi-Kurikulum (K13 & Merdeka P5)
     */
    public function grades()
    {
        $grades = Grade::with(['student', 'subject', 'academicYear'])->latest()->paginate(15);
        $students = Student::where('status', 'AKTIF')->get();
        $subjects = Subject::all();
        $academicYears = AcademicYear::all();

        return view('admin.academic.grades', compact('grades', 'students', 'subjects', 'academicYears'));
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

        Grade::create($validated);

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
