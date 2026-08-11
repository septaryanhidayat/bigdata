<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Level;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Guardian;
use App\Models\Subject;
use App\Models\Room;
use App\Models\AuditLog;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Dashboard & Ringkasan Fondasi Master Data
     */
    public function index(Request $request)
    {
        $schools = School::withCount(['classrooms', 'employees', 'students'])->get();
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();
        $activeYear = AcademicYear::where('is_active', 1)->first() ?? $academicYears->first();
        
        $studentsCount = Student::count();
        $teachersCount = Employee::where('type', 'GURU')->count();
        $staffCount = Employee::where('type', 'NON_GURU')->count();
        $classroomsCount = Classroom::count();

        $activeSchoolId = session('active_school_id', $schools->first()->id ?? 1);
        $activeSchool = School::find($activeSchoolId) ?? $schools->first();

        $recentAuditLogs = AuditLog::with('user')->latest()->take(10)->get();

        return view('admin.master.index', compact(
            'schools', 'academicYears', 'activeYear', 
            'studentsCount', 'teachersCount', 'staffCount', 
            'classroomsCount', 'activeSchool', 'recentAuditLogs'
        ));
    }

    /**
     * Switch Unit Sekolah Aktif Yayasan
     */
    public function switchSchool(Request $request)
    {
        $request->validate(['school_id' => 'required|exists:schools,id']);
        session(['active_school_id' => $request->school_id]);
        
        $school = School::find($request->school_id);

        return redirect()->back()->with('success', "Berhasil beralih ke unit sekolah: {$school->name}");
    }

    /**
     * Kelola Unit & Profil Sekolah (Multi-Sekolah Yayasan)
     */
    public function schools()
    {
        $schools = School::withCount(['classrooms', 'employees', 'students'])->get();
        return view('admin.master.schools', compact('schools'));
    }

    public function storeSchool(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:schools,code',
            'name' => 'required|string|max:255',
            'npsn' => 'nullable|string',
            'principal_name' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'theme_color' => 'required|string',
            'logo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = ImageOptimizerService::convertAndOptimizeToWebp($request->file('logo'), 'schools');
        }

        School::create($validated);

        return redirect()->back()->with('success', 'Unit Sekolah Baru Berhasil Ditambahkan!');
    }

    public function updateSchool(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npsn' => 'nullable|string',
            'principal_name' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'theme_color' => 'required|string',
            'logo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = ImageOptimizerService::convertAndOptimizeToWebp($request->file('logo'), 'schools');
        }

        $school->update($validated);

        return redirect()->back()->with('success', "Data Unit Sekolah {$school->name} Berhasil Diperbarui!");
    }

    /**
     * Kelola Kurikulum & Tahun Akademik
     */
    public function curriculums()
    {
        $academicYears = AcademicYear::orderBy('id', 'desc')->get();
        return view('admin.master.curriculums', compact('academicYears'));
    }

    public function storeAcademicYear(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'semester' => 'required|string',
            'curriculum_code' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($request->has('is_active')) {
            AcademicYear::query()->update(['is_active' => false]);
            $validated['is_active'] = true;
        }

        AcademicYear::create($validated);

        return redirect()->back()->with('success', 'Tahun Akademik & Kurikulum Berhasil Ditambahkan!');
    }

    /**
     * Kelola Tingkat & Rombel Kelas
     */
    public function classrooms()
    {
        $classrooms = Classroom::with(['school', 'level', 'homeroomTeacher'])->get();
        $schools = School::all();
        $levels = Level::all();
        $teachers = Employee::where('type', 'GURU')->get();

        return view('admin.master.classrooms', compact('classrooms', 'schools', 'levels', 'teachers'));
    }

    public function storeClassroom(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string',
            'capacity' => 'required|integer',
            'homeroom_teacher_id' => 'nullable|exists:employees,id',
        ]);

        Classroom::create($validated);

        return redirect()->back()->with('success', 'Rombel Kelas Berhasil Ditambahkan!');
    }

    /**
     * Kelola Data Siswa & Wali
     */
    public function students(Request $request)
    {
        $query = Student::with(['school', 'classroom', 'guardian']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('rfid_tag', 'like', "%{$search}%");
            });
        }

        if ($request->has('school_id') && $request->school_id != '') {
            $query->where('school_id', $request->school_id);
        }

        $students = $query->latest()->paginate(15);
        $schools = School::all();
        $classrooms = Classroom::all();

        return view('admin.master.students', compact('students', 'schools', 'classrooms'));
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'nis' => 'required|string|unique:students,nis',
            'nisn' => 'nullable|string',
            'full_name' => 'required|string',
            'gender' => 'required|in:L,P',
            'birth_place' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'rfid_tag' => 'nullable|string|unique:students,rfid_tag',
            'status' => 'required|in:AKTIF,LULUS,KELUAR,MUTASI',
        ]);

        Student::create($validated);

        return redirect()->back()->with('success', 'Data Siswa Baru Berhasil Ditambahkan!');
    }

    /**
     * Kelola Data Guru & Staf Pengajar
     */
    public function teachers()
    {
        $teachers = Employee::where('type', 'GURU')->with('school')->latest()->paginate(15);
        $schools = School::all();

        return view('admin.master.teachers', compact('teachers', 'schools'));
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'nip' => 'required|string|unique:employees,nip',
            'full_name' => 'required|string',
            'title' => 'nullable|string',
            'type' => 'required|in:GURU,NON_GURU',
            'position' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        Employee::create($validated);

        return redirect()->back()->with('success', 'Data Guru/Pendidik Berhasil Ditambahkan!');
    }

    /**
     * Kelola Karyawan Non-Guru (TU, CS, Security)
     */
    public function employees()
    {
        $employees = Employee::where('type', 'NON_GURU')->with('school')->latest()->paginate(15);
        $schools = School::all();

        return view('admin.master.employees', compact('employees', 'schools'));
    }

    /**
     * Kelola Referensi Mata Pelajaran & Ruangan
     */
    public function references()
    {
        $subjects = Subject::with('school')->get();
        $rooms = Room::with('school')->get();
        $schools = School::all();

        return view('admin.master.references', compact('subjects', 'rooms', 'schools'));
    }

    public function storeSubject(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string',
            'name' => 'required|string',
            'group' => 'required|string',
        ]);

        Subject::create($validated);

        return redirect()->back()->with('success', 'Mata Pelajaran Berhasil Ditambahkan!');
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string',
            'name' => 'required|string',
            'building' => 'nullable|string',
            'capacity' => 'required|integer',
        ]);

        Room::create($validated);

        return redirect()->back()->with('success', 'Ruangan Berhasil Ditambahkan!');
    }
}
