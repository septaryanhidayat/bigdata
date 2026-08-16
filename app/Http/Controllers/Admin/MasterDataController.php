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
        $teachersCount = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])->count();
        $staffCount = Employee::whereIn('role_type', ['STAFF', 'TREASURER'])->count();
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
        $user = auth()->user();
        if ($user && $user->school_id) {
            return redirect()->back()->with('error', '⛔ Akun Anda terkunci pada unit ' . ($user->school->name ?? 'sekolah'));
        }

        $schoolId = $request->input('school_id', 'all');
        if ($schoolId !== 'all') {
            $request->validate(['school_id' => 'exists:schools,id']);
            $school = School::find($schoolId);
            $schoolName = $school ? $school->name : 'Unit Sekolah';
        } else {
            $schoolName = 'Semua Unit (Yayasan Robbani)';
        }

        session([
            'dashboard_school_id' => $schoolId,
            'active_school_id' => $schoolId,
        ]);

        return redirect()->back()->with('success', "✓ Mode Unit Aktif Berhasil Diubah: {$schoolName}");
    }

    /**
     * Kelola Unit & Profil Sekolah (Multi-Sekolah Yayasan)
     */
    public function schools()
    {
        $user = auth()->user();
        if ($user && $user->school_id) {
            $schools = School::where('id', $user->school_id)->withCount(['classrooms', 'employees', 'students'])->get();
        } else {
            $schools = School::withCount(['classrooms', 'employees', 'students'])->get();
        }
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
            'kop_letterhead' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = ImageOptimizerService::convertAndOptimizeToWebp($request->file('logo'), 'schools');
        }

        if ($request->hasFile('kop_letterhead')) {
            $validated['kop_image_url'] = ImageOptimizerService::convertAndOptimizeToWebp($request->file('kop_letterhead'), 'schools');
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
            'kop_letterhead' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = ImageOptimizerService::convertAndOptimizeToWebp($request->file('logo'), 'schools');
        }

        if ($request->hasFile('kop_letterhead')) {
            $validated['kop_image_url'] = ImageOptimizerService::convertAndOptimizeToWebp($request->file('kop_letterhead'), 'schools');
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
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $classroomsQuery = Classroom::with(['school', 'level', 'homeroomTeacher']);
        if ($schoolId) {
            $classroomsQuery->where('school_id', $schoolId);
        }

        $classrooms = $classroomsQuery->paginate(15);
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();
        $levels = $schoolId ? Level::where('school_id', $schoolId)->get() : Level::all();
        $teachers = $schoolId ? Employee::where('school_id', $schoolId)->whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])->get() : Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])->get();

        return view('admin.master.classrooms', compact('classrooms', 'schools', 'levels', 'teachers'));
    }

    public function storeClassroom(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : $request->school_id;

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string',
            'capacity' => 'required|integer',
            'homeroom_teacher_id' => 'nullable|exists:employees,id',
        ]);

        $validated['school_id'] = $schoolId;
        $activeYear = AcademicYear::where('is_active', true)->first() ?? AcademicYear::first();
        $validated['academic_year_id'] = $request->academic_year_id ?? ($activeYear ? $activeYear->id : 1);

        Classroom::create($validated);

        return redirect()->back()->with('success', 'Rombel Kelas Berhasil Ditambahkan!');
    }

    /**
     * Kelola Data Siswa & Wali
     */
    public function students(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $query = Student::with(['school', 'classroom', 'guardian']);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        } elseif ($request->has('school_id') && $request->school_id != '') {
            $query->where('school_id', $request->school_id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('rfid_tag', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(15);
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();
        $classrooms = $schoolId ? Classroom::where('school_id', $schoolId)->get() : Classroom::all();

        return view('admin.master.students', compact('students', 'schools', 'classrooms'));
    }

    public function storeStudent(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : $request->school_id;

        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'nis' => 'required|string|unique:students,nis',
            'nisn' => 'nullable|string',
            'full_name' => 'required|string',
            'gender' => 'required',
            'birth_place' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'rfid_tag' => 'nullable|string|unique:students,rfid_tag',
            'status' => 'nullable|string',
        ]);

        $gender = in_array(strtoupper($request->gender), ['L', 'LAKI_LAKI', 'M']) ? 'M' : 'F';
        $status = in_array(strtoupper($request->status ?? 'ACTIVE'), ['AKTIF', 'ACTIVE']) ? 'ACTIVE' : 'ACTIVE';

        Student::create([
            'school_id' => $schoolId,
            'classroom_id' => $request->classroom_id,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'full_name' => $request->full_name,
            'gender' => $gender,
            'pob' => $request->birth_place ?? $request->pob,
            'dob' => $request->birth_date ?? $request->dob,
            'rfid_tag' => $request->rfid_tag,
            'status' => $status,
            'savings_balance' => 0,
            'canteen_balance' => 0,
            'canteen_daily_limit' => 50000,
        ]);

        return redirect()->back()->with('success', 'Data Siswa Baru Berhasil Ditambahkan!');
    }

    /**
     * Export Data Siswa ke CSV/Excel
     */
    public function exportStudents()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $query = Student::with(['school', 'classroom']);
        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }
        $students = $query->get();

        $filename = 'export_students_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'NIS', 'NISN', 'Nama Lengkap', 'Jenis Kelamin', 'Unit Sekolah', 'Kelas', 'RFID Tag', 'Saldo Tabungan', 'Status']);

            foreach ($students as $st) {
                fputcsv($file, [
                    $st->id,
                    $st->nis,
                    $st->nisn ?? '-',
                    $st->full_name,
                    $st->gender == 'M' ? 'Laki-Laki' : 'Perempuan',
                    $st->school->name ?? '-',
                    $st->classroom->name ?? '-',
                    $st->rfid_tag ?? '-',
                    $st->savings_balance,
                    $st->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Massal Data Siswa dari File CSV
     */
    public function importStudents(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $user = auth()->user();
        $defaultSchool = $user && $user->school_id ? School::find($user->school_id) : School::first();

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        $header = fgetcsv($handle); // Skip header

        $importedCount = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (count($data) >= 3) {
                $nis = trim($data[0]);
                $fullName = trim($data[1]);
                $genderInput = strtoupper(trim($data[2] ?? 'L'));
                $gender = in_array($genderInput, ['L', 'LAKI_LAKI', 'M']) ? 'M' : 'F';

                Student::firstOrCreate(
                    ['nis' => $nis],
                    [
                        'school_id' => $defaultSchool->id ?? 1,
                        'full_name' => $fullName,
                        'gender' => $gender,
                        'rfid_tag' => 'RFID-IMP-' . rand(10000, 99999),
                        'status' => 'ACTIVE',
                        'savings_balance' => 50000,
                        'canteen_balance' => 20000,
                        'canteen_daily_limit' => 50000,
                    ]
                );
                $importedCount++;
            }
        }
        fclose($handle);

        return redirect()->back()->with('success', "✓ Berhasil mengimpor {$importedCount} data siswa baru secara massal!");
    }

    /**
     * Export Data Guru/Pendidik ke CSV
     */
    public function exportTeachers()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $query = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR']);
        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }
        $teachers = $query->get();

        $filename = 'export_teachers_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($teachers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'NIP', 'Nama Guru', 'Gelar', 'Jabatan', 'Unit Sekolah', 'No. HP', 'Email']);

            foreach ($teachers as $t) {
                fputcsv($file, [
                    $t->id,
                    $t->nip ?? '-',
                    $t->full_name,
                    $t->title_suffix ?? $t->title_prefix ?? '-',
                    $t->employment_status ?? 'Guru Pelajaran',
                    $t->school->name ?? '-',
                    $t->phone ?? '-',
                    $t->email ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Kelola Data Guru & Staf Pengajar
     */
    public function teachers()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $query = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])->with('school');
        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        $teachers = $query->latest()->paginate(15);
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();

        return view('admin.master.teachers', compact('teachers', 'schools'));
    }

    public function storeTeacher(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : $request->school_id;

        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'nip' => 'required|string|unique:employees,nip',
            'full_name' => 'required|string',
            'title' => 'nullable|string',
            'type' => 'nullable|string',
            'position' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $roleType = in_array(strtoupper($request->type ?? 'GURU'), ['NON_GURU', 'STAFF']) ? 'STAFF' : 'TEACHER';

        Employee::create([
            'school_id' => $schoolId,
            'nip' => $request->nip,
            'full_name' => $request->full_name,
            'title_suffix' => $request->title,
            'role_type' => $roleType,
            'employment_status' => $request->position ?? 'PERMANENT',
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Data Guru Baru Berhasil Ditambahkan!');
    }

    /**
     * Kelola Seluruh Data Karyawan & Pegawai
     */
    public function employees()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $query = Employee::with('school');
        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        $employees = $query->latest()->paginate(15);
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();

        return view('admin.master.employees', compact('employees', 'schools'));
    }

    /**
     * Referensi Mata Pelajaran & Ruangan
     */
    public function references()
    {
        $user = auth()->user();
        $schoolId = $user?->getEffectiveSchoolId();

        $subjectsQuery = Subject::with('school');
        $roomsQuery = Room::with('school');
        if ($schoolId) {
            $subjectsQuery->where('school_id', $schoolId);
            $roomsQuery->where('school_id', $schoolId);
        }

        $subjects = $subjectsQuery->get();
        $rooms = $roomsQuery->get();
        $schools = $schoolId ? School::where('id', $schoolId)->get() : School::all();

        return view('admin.master.references', compact('subjects', 'rooms', 'schools'));
    }

    public function storeSubject(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string',
            'name' => 'required|string',
            'group' => 'nullable|string',
        ]);

        Subject::create([
            'school_id' => $request->school_id,
            'code' => $request->code,
            'name' => $request->name,
            'category' => $request->group ?? $request->category ?? 'MUATAN_NASIONAL',
            'passing_grade' => 75,
        ]);

        return redirect()->back()->with('success', 'Mata Pelajaran Berhasil Ditambahkan!');
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string',
            'name' => 'required|string',
            'building' => 'nullable|string',
            'capacity' => 'required|integer',
        ]);

        Room::create([
            'school_id' => $request->school_id,
            'code' => $request->code,
            'name' => $request->name,
            'location_building' => $request->building ?? $request->location_building ?? 'Gedung Utama',
            'capacity' => $request->capacity,
            'category' => 'CLASSROOM',
        ]);

        return redirect()->back()->with('success', 'Ruangan Berhasil Ditambahkan!');
    }
}
