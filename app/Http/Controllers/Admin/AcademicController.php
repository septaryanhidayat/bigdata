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

        return view('admin.academic.schedules', compact('schedules', 'schools', 'classrooms', 'subjects', 'teachers', 'schoolId'));
    }

    public function storeSchedule(Request $request)
    {
        $user = auth()->user();
        $effectiveSchoolId = $user?->getEffectiveSchoolId();

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:employees,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($effectiveSchoolId && $request->school_id != $effectiveSchoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Unit sekolah tidak sesuai hak akses Anda.');
        }

        $validated['school_id'] = $effectiveSchoolId ?: $request->school_id;
        $sch = Schedule::create($validated);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'TAMBAH JADWAL KBM',
                'model_type' => 'Schedule',
                'model_id' => $sch->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Jadwal Pelajaran Berhasil Ditambahkan!');
    }

    public function destroySchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $schedule->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak memiliki otoritas atas jadwal unit ini.');
        }

        $schedule->delete();
        return redirect()->back()->with('success', '✓ Jadwal Pelajaran berhasil dihapus.');
    }

    /**
     * Jurnal KBM Guru
     */
    public function journals()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

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

        $schedule = Schedule::findOrFail($request->schedule_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $schedule->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Jadwal ini bukan dari unit sekolah Anda.');
        }

        $jrn = KbmJournal::create([
            'schedule_id' => $request->schedule_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'topic' => $request->topic,
            'notes' => $request->notes,
        ]);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'JURNAL KBM',
                'model_type' => 'KbmJournal',
                'model_id' => $jrn->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Catatan Jurnal KBM Guru Berhasil Disimpan!');
    }

    public function destroyJournal($id)
    {
        $journal = KbmJournal::with('schedule')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $journal->schedule && $journal->schedule->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak memiliki otoritas atas jurnal ini.');
        }

        $journal->delete();
        return redirect()->back()->with('success', '✓ Jurnal KBM berhasil dihapus.');
    }

    /**
     * Modul 2.2: Penilaian & E-Rapor Terpadu SIT (Kurikulum Merdeka, Wafa & 7 SKL JSIT)
     */
    /**
     * Modul 2.2: Penilaian & E-Rapor Terpadu SIT (Kurikulum Merdeka, Wafa & 7 SKL JSIT)
     */
    public function grades(Request $request)
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
        $activeAcademicYear = AcademicYear::where('is_active', 1)->first() ?? $academicYears->first();
        
        // Active Submenu / Tab
        $activeMenu = $request->query('menu', $request->query('tab', 'dashboard'));

        // Classrooms in this school
        $classrooms = Classroom::where('school_id', $schoolId)->with(['homeroomTeacher'])->get();
        $selectedClassroomId = $request->query('classroom_id');
        if (!$selectedClassroomId && $classrooms->isNotEmpty()) {
            $selectedClassroomId = $classrooms->first()->id;
        }
        $selectedClassroom = $classrooms->firstWhere('id', $selectedClassroomId);

        // Subjects in this school
        $subjects = Subject::where(function($q) use ($schoolId) {
            $q->where('school_id', $schoolId)->orWhereNull('school_id');
        })->get();
        if ($subjects->isEmpty()) {
            $subjects = Subject::all();
        }
        $selectedSubjectId = $request->query('subject_id');
        if (!$selectedSubjectId && $subjects->isNotEmpty()) {
            $selectedSubjectId = $subjects->first()->id;
        }
        $selectedSubject = $subjects->firstWhere('id', $selectedSubjectId);

        // Students of Selected Classroom
        $classStudents = Student::where('classroom_id', $selectedClassroomId)
            ->whereIn('status', ['ACTIVE', 'AKTIF'])
            ->orderBy('nis')
            ->get();
        if ($classStudents->isEmpty() && $selectedClassroomId) {
            $classStudents = Student::where('classroom_id', $selectedClassroomId)->orderBy('nis')->get();
        }

        $studentIds = $classStudents->pluck('id');

        // Pre-fetch existing grades for current class
        $existingGrades = Grade::where('subject_id', $selectedSubjectId)
            ->where('academic_year_id', $activeAcademicYear?->id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->keyBy('student_id');

        $existingQuran = QuranGrade::where('academic_year_id', $activeAcademicYear?->id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->keyBy('student_id');

        $existingCharacter = CharacterGrade::where('academic_year_id', $activeAcademicYear?->id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->keyBy('student_id');

        $existingHomeroom = HomeroomNote::where('academic_year_id', $activeAcademicYear?->id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->keyBy('student_id');

        // Master Criteria & Settings
        $quranCriteria = QuranCriterion::where(function($q) use ($schoolId) {
            $q->where('school_id', $schoolId)->orWhereNull('school_id');
        })->orderBy('order_number')->get();

        $characterIndicators = CharacterIndicator::where(function($q) use ($schoolId) {
            $q->where('school_id', $schoolId)->orWhereNull('school_id');
        })->orderBy('order_number')->get();

        $reportSetting = ReportSetting::firstOrCreate(
            ['school_id' => $schoolId],
            [
                'kop_header_text' => "YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI\n" . strtoupper($activeSchool->name ?? 'SEKOLAH ISLAM TERPADU ROBBANI') . "\nNPSN: " . ($activeSchool->npsn ?? '20198033') . " • Akreditasi: A (Unggul)\nAlamat: " . ($activeSchool->address ?? 'Jl. Raya Pendidikan Terpadu No. 8, Bandung'),
                'principal_name' => $activeSchool->principal_name ?? 'Ustadz H. Ahmad Fauzi, M.Pd.',
                'principal_nip' => '19850315 200904 1 003',
                'report_city' => 'Bandung',
                'report_date' => '20 Desember 2026',
            ]
        );

        // Dashboard Stats & Classroom Progress Calculation
        $allSchoolStudents = Student::where('school_id', $schoolId)->whereIn('status', ['ACTIVE', 'AKTIF'])->get();
        $totalSchoolStudents = $allSchoolStudents->count();
        $totalClassrooms = $classrooms->count();
        $totalSubjects = $subjects->count();

        $classroomProgress = [];
        foreach ($classrooms as $cls) {
            $clsStudents = Student::where('classroom_id', $cls->id)->whereIn('status', ['ACTIVE', 'AKTIF'])->get();
            $stCount = $clsStudents->count();
            $stIds = $clsStudents->pluck('id');

            $mapelGradesCount = $stCount > 0 ? Grade::whereIn('student_id', $stIds)->distinct('student_id')->count('student_id') : 0;
            $quranGradesCount = $stCount > 0 ? QuranGrade::whereIn('student_id', $stIds)->count() : 0;
            $charGradesCount = $stCount > 0 ? CharacterGrade::whereIn('student_id', $stIds)->count() : 0;
            $hrNotesCount = $stCount > 0 ? HomeroomNote::whereIn('student_id', $stIds)->count() : 0;

            $totalExpected = $stCount * 4;
            $totalFilled = $mapelGradesCount + $quranGradesCount + $charGradesCount + $hrNotesCount;
            $pct = $totalExpected > 0 ? min(100, round(($totalFilled / $totalExpected) * 100)) : 0;

            $classroomProgress[$cls->id] = [
                'classroom' => $cls,
                'student_count' => $stCount,
                'mapel_count' => $mapelGradesCount,
                'quran_count' => $quranGradesCount,
                'char_count' => $charGradesCount,
                'hr_count' => $hrNotesCount,
                'percentage' => $pct,
            ];
        }

        // Print readiness checklist for each student in selected class
        $printReadiness = [];
        foreach ($classStudents as $st) {
            $hasMapel = Grade::where('student_id', $st->id)->exists();
            $hasQuran = isset($existingQuran[$st->id]);
            $hasChar = isset($existingCharacter[$st->id]);
            $hasHr = isset($existingHomeroom[$st->id]);
            $isReady = $hasMapel && $hasQuran && $hasChar && $hasHr;

            $printReadiness[$st->id] = [
                'mapel' => $hasMapel,
                'quran' => $hasQuran,
                'character' => $hasChar,
                'homeroom' => $hasHr,
                'is_ready' => $isReady,
            ];
        }

        // Teachers of this school for assigning Wali Kelas
        $schoolTeachers = Employee::where('school_id', $schoolId)
            ->whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])
            ->get();
        if ($schoolTeachers->isEmpty()) {
            $schoolTeachers = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER', 'COUNSELOR'])->get();
        }

        $rekapGuru = $schoolTeachers->count();
        $assignedWaliCount = $classrooms->whereNotNull('homeroom_teacher_id')->count();
        $rekapMapel = Grade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
        $rekapWafa = QuranGrade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
        $rekapKarakter = CharacterGrade::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');
        $rekapHomeroom = HomeroomNote::whereHas('student', fn($q) => $q->where('school_id', $schoolId))->distinct('student_id')->count('student_id');

        // All students in this unit for Data Siswa Unit menu
        $unitStudents = Student::where('school_id', $schoolId)
            ->with(['classroom', 'school'])
            ->orderBy('nis')
            ->get();

        $schoolLevels = \App\Models\Level::where('school_id', $schoolId)->get();
        if ($schoolLevels->isEmpty()) {
            $schoolLevels = \App\Models\Level::all();
        }

        // Ekstrakurikuler & Ko-Kurikuler P5
        $extracurriculars = \App\Models\Extracurricular::where('school_id', $schoolId)->get();
        $p5Projects = \App\Models\P5Project::where('school_id', $schoolId)->with(['classroom'])->get();

        // Current user role display label
        $currentUser = auth()->user();
        $userRoleLabel = 'Staf Akademik';
        if ($currentUser?->isSuperAdmin()) $userRoleLabel = 'Super Admin Yayasan';
        elseif ($currentUser?->isHeadmaster()) $userRoleLabel = 'Kepala Sekolah (' . ($activeSchool->code ?? 'Unit') . ')';
        elseif ($currentUser?->isTeacher()) $userRoleLabel = 'Guru & Wali Kelas';
        elseif ($currentUser?->isStaffTu()) $userRoleLabel = 'Operator / Tata Usaha';

        return view('admin.academic.grades', compact(
            'schools',
            'activeSchool',
            'schoolId',
            'activeMenu',
            'classrooms',
            'selectedClassroomId',
            'selectedClassroom',
            'subjects',
            'selectedSubjectId',
            'selectedSubject',
            'classStudents',
            'academicYears',
            'activeAcademicYear',
            'existingGrades',
            'existingQuran',
            'existingCharacter',
            'existingHomeroom',
            'quranCriteria',
            'characterIndicators',
            'reportSetting',
            'totalSchoolStudents',
            'totalClassrooms',
            'totalSubjects',
            'classroomProgress',
            'printReadiness',
            'schoolTeachers',
            'rekapGuru',
            'assignedWaliCount',
            'rekapMapel',
            'rekapWafa',
            'rekapKarakter',
            'rekapHomeroom',
            'unitStudents',
            'schoolLevels',
            'userRoleLabel',
            'extracurriculars',
            'p5Projects'
        ));
    }

    /**
     * Simpan / Update Rombel & Penetapan Wali Kelas oleh Kepsek / Operator
     */
    public function saveClassroom(Request $request)
    {
        $schoolId = $request->input('school_id');
        $classroomId = $request->input('classroom_id');

        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string',
            'homeroom_teacher_id' => 'nullable|exists:employees,id',
        ]);

        if ($classroomId) {
            $classroom = Classroom::findOrFail($classroomId);
            $classroom->update([
                'name' => $request->name,
                'homeroom_teacher_id' => $request->homeroom_teacher_id ?: null,
                'capacity' => $request->capacity ?: $classroom->capacity,
            ]);
            $msg = "Data Rombel {$classroom->name} & Penetapan Wali Kelas Berhasil Diperbarui!";
        } else {
            $activeYear = AcademicYear::where('is_active', true)->first() ?? AcademicYear::first();
            $level = \App\Models\Level::where('school_id', $schoolId)->first();
            $classroom = Classroom::create([
                'school_id' => $schoolId,
                'level_id' => $request->level_id ?: ($level ? $level->id : 1),
                'academic_year_id' => $activeYear ? $activeYear->id : 1,
                'name' => $request->name,
                'capacity' => $request->capacity ?: 30,
                'homeroom_teacher_id' => $request->homeroom_teacher_id ?: null,
            ]);
            $msg = "Rombel Baru {$classroom->name} Berhasil Ditambahkan!";
        }

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'classrooms'
        ])->with('success', $msg);
    }

    /**
     * Simpan / Tambah Data Siswa oleh Kepsek / Operator
     */
    public function saveStudent(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'nis' => 'required|string',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
        ]);

        Student::updateOrCreate(
            [
                'school_id' => $request->school_id,
                'nis' => $request->nis,
            ],
            [
                'classroom_id' => $request->classroom_id,
                'nisn' => $request->nisn,
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'status' => 'ACTIVE',
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'students'
        ])->with('success', "Data Santri {$request->full_name} (NIS: {$request->nis}) Berhasil Disimpan!");
    }

    /**
     * Hapus Santri oleh Kepsek / Operator
     */
    public function deleteStudent($studentId, Request $request)
    {
        $student = Student::findOrFail($studentId);
        $schoolId = $student->school_id;
        $name = $student->full_name;
        $student->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'students'
        ])->with('success', "Data Santri {$name} berhasil dihapus dari sistem.");
    }

    /**
     * Unduh Template CSV Import Santri
     */
    public function downloadStudentTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Template_Import_Siswa.csv"',
        ];

        $callback = function () {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($output, ['NIS', 'NISN', 'Nama_Lengkap', 'Jenis_Kelamin_L_P', 'Nama_Rombel']);
            fputcsv($output, ['SMP-2026-0099', '0099123456', 'Ahmad Demo Santri', 'L', 'Kelas 7A Tahfidz Unggulan']);
            fputcsv($output, ['SMP-2026-0100', '0099123457', 'Fatimah Az-Zahra', 'P', 'Kelas 7A Tahfidz Unggulan']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Data Santri dari File CSV
     */
    public function importStudents(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $schoolId = $request->input('school_id');
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0]) || empty($row[2])) continue;
            $nis = trim($row[0]);
            $nisn = !empty($row[1]) ? trim($row[1]) : null;
            $name = trim($row[2]);
            $gender = strtoupper(trim($row[3] ?? 'L'));
            if (!in_array($gender, ['L', 'P', 'M', 'F'])) $gender = 'L';
            if ($gender === 'M') $gender = 'L';
            if ($gender === 'F') $gender = 'P';

            $classroomName = !empty($row[4]) ? trim($row[4]) : null;
            $classroomId = null;
            if ($classroomName) {
                $cls = Classroom::firstOrCreate(
                    ['school_id' => $schoolId, 'name' => $classroomName],
                    ['capacity' => 30, 'level_id' => 1]
                );
                $classroomId = $cls->id;
            }

            Student::updateOrCreate(
                ['school_id' => $schoolId, 'nis' => $nis],
                [
                    'nisn' => $nisn,
                    'full_name' => $name,
                    'gender' => $gender,
                    'classroom_id' => $classroomId,
                    'status' => 'ACTIVE',
                ]
            );
            $count++;
        }
        fclose($handle);

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'students',
        ])->with('success', "Alhamdulillah! Berhasil mengimpor {$count} data santri ke sistem.");
    }

    /**
     * Hapus Rombel oleh Kepsek / Operator
     */
    public function deleteClassroom($classroomId, Request $request)
    {
        $cls = Classroom::findOrFail($classroomId);
        $schoolId = $cls->school_id;
        $name = $cls->name;
        Student::where('classroom_id', $classroomId)->update(['classroom_id' => null]);
        $cls->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'classrooms'
        ])->with('success', "Rombel {$name} berhasil dihapus.");
    }

    /**
     * Upload Tanda Tangan Wali Kelas per Rombel
     */
    public function uploadHomeroomSignature($classroomId, Request $request)
    {
        $request->validate([
            'homeroom_signature' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $classroom = Classroom::findOrFail($classroomId);
        $file = $request->file('homeroom_signature');
        $filename = 'ttd_walas_' . $classroomId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $dest = public_path('uploads/signatures');
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }
        $file->move($dest, $filename);

        $classroom->homeroom_signature_path = '/uploads/signatures/' . $filename;
        $classroom->save();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $classroom->school_id,
            'menu' => 'classrooms',
        ])->with('success', "Tanda tangan digital Wali Kelas untuk {$classroom->name} berhasil disimpan!");
    }

    /**
     * Simpan / Tambah / Update Mata Pelajaran
     */
    public function saveSubject(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string|max:30',
            'name' => 'required|string|max:255',
            'passing_grade' => 'nullable|numeric|min:0|max:100',
        ]);

        $subject = Subject::updateOrCreate(
            [
                'id' => $request->subject_id,
            ],
            [
                'school_id' => $request->school_id,
                'code' => strtoupper($request->code),
                'name' => $request->name,
                'category' => $request->category ?? 'Kelompok A (Umum)',
                'passing_grade' => $request->passing_grade ?: 75,
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'subjects',
        ])->with('success', "Mata Pelajaran {$subject->name} ({$subject->code}) Berhasil Disimpan!");
    }

    /**
     * Hapus Mata Pelajaran
     */
    public function deleteSubject($subjectId, Request $request)
    {
        $sub = Subject::findOrFail($subjectId);
        $schoolId = $sub->school_id;
        $name = $sub->name;
        $sub->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'subjects',
        ])->with('success', "Mata Pelajaran {$name} berhasil dihapus.");
    }

    /**
     * Unduh Template CSV Mata Pelajaran
     */
    public function downloadSubjectTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Template_Import_Mapel.csv"',
        ];

        $callback = function () {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, ['Kode_Mapel', 'Nama_Mata_Pelajaran', 'Kelompok_Kurikulum', 'KKTP_KKM']);
            fputcsv($output, ['PAI-01', 'Pendidikan Agama Islam & Budi Pekerti', 'Kelompok A (Umum)', '75']);
            fputcsv($output, ['TQ-01', 'Tahsin & Tahfidz Al-Qur\'an', 'Muatan Khusus JSIT', '80']);
            fputcsv($output, ['MTK-01', 'Matematika', 'Kelompok A (Umum)', '75']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import Data Mapel dari File CSV
     */
    public function importSubjects(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $schoolId = $request->input('school_id');
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0]) || empty($row[1])) continue;
            $code = strtoupper(trim($row[0]));
            $name = trim($row[1]);
            $category = !empty($row[2]) ? trim($row[2]) : 'Kelompok A (Umum)';
            $kktp = !empty($row[3]) ? (float) $row[3] : 75;

            Subject::updateOrCreate(
                ['school_id' => $schoolId, 'code' => $code],
                [
                    'name' => $name,
                    'category' => $category,
                    'passing_grade' => $kktp,
                ]
            );
            $count++;
        }
        fclose($handle);

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'subjects',
        ])->with('success', "Alhamdulillah! Berhasil mengimpor {$count} mata pelajaran.");
    }

    /**
     * Simpan / Tambah / Update Ekstrakurikuler
     */
    public function saveExtracurricular(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
        ]);

        $ekskul = \App\Models\Extracurricular::updateOrCreate(
            ['id' => $request->id],
            [
                'school_id' => $request->school_id,
                'name' => $request->name,
                'coach_name' => $request->coach_name,
                'description' => $request->description,
                'is_active' => true,
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'extracurriculars',
        ])->with('success', "Ekstrakurikuler {$ekskul->name} Berhasil Disimpan!");
    }

    /**
     * Hapus Ekstrakurikuler
     */
    public function deleteExtracurricular($id, Request $request)
    {
        $ekskul = \App\Models\Extracurricular::findOrFail($id);
        $schoolId = $ekskul->school_id;
        $name = $ekskul->name;
        $ekskul->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'extracurriculars',
        ])->with('success', "Ekstrakurikuler {$name} berhasil dihapus.");
    }

    /**
     * Simpan / Tambah / Update Projek P5 / Kokurikuler
     */
    public function saveProjectP5(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'theme' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ]);

        $dims = $request->target_dimensions;
        if (is_string($dims)) {
            $dims = array_map('trim', explode(',', $dims));
        }

        $p5 = \App\Models\P5Project::updateOrCreate(
            ['id' => $request->id],
            [
                'school_id' => $request->school_id,
                'classroom_id' => $request->classroom_id ?: null,
                'academic_year_id' => $request->academic_year_id ?: null,
                'theme' => $request->theme,
                'title' => $request->title,
                'description' => $request->description,
                'coordinator_name' => $request->coordinator_name,
                'target_dimensions' => $dims ?: ['Beriman & Berakhlak Mulia', 'Gotong Royong', 'Kreatif'],
            ]
        );

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'menu' => 'p5',
        ])->with('success', "Projek Kokurikuler / P5 {$p5->title} Berhasil Disimpan!");
    }

    /**
     * Hapus Projek P5 / Kokurikuler
     */
    public function deleteProjectP5($id, Request $request)
    {
        $p5 = \App\Models\P5Project::findOrFail($id);
        $schoolId = $p5->school_id;
        $title = $p5->title;
        $p5->delete();

        return redirect()->route('admin.academic.grades', [
            'school_id' => $schoolId,
            'menu' => 'p5',
        ])->with('success', "Projek Kokurikuler / P5 {$title} berhasil dihapus.");
    }

    /**
     * Batch Store Nilai Mata Pelajaran 1 Kelas Sekaligus (Guru Mapel)
     */
    public function batchStoreGrades(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'grades' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->grades as $studentId => $data) {
            $score = isset($data['score']) && $data['score'] !== '' ? (float) $data['score'] : null;
            if (is_null($score)) continue;

            $notes = $data['notes'] ?? '';
            if (empty(trim($notes))) {
                if ($score >= 90) {
                    $notes = 'Menunjukkan penguasaan capaian pembelajaran yang sangat istimewa (Mumtaz) serta mampu bernalar kritis secara mandiri.';
                } elseif ($score >= 80) {
                    $notes = 'Menunjukkan penguasaan capaian pembelajaran yang amat baik dan aktif dalam pemecahan masalah.';
                } elseif ($score >= 70) {
                    $notes = 'Menunjukkan penguasaan capaian pembelajaran yang cukup baik, perlu sedikit penguatan pada materi lanjutan.';
                } else {
                    $notes = 'Memerlukan bimbingan dan remedial intensif untuk mencapai kriteria ketuntasan tujuan pembelajaran.';
                }
            }

            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'academic_year_id' => $request->academic_year_id,
                    'assessment_type' => $data['assessment_type'] ?? 'Sumatif Akhir Semester (SAS)',
                ],
                [
                    'competency_code' => $data['competency_code'] ?? 'TP-MERDEKA',
                    'score' => $score,
                    'notes' => $notes,
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH NILAI MAPEL',
                'model_type' => 'Grade',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'menu' => 'academic'
        ])->with('success', "Berhasil menyimpan nilai untuk {$savedCount} siswa secara bersamaan!");
    }

    /**
     * Batch Store Nilai Al-Qur'an Metode Wafa & Tahfidz 1 Kelas Sekaligus
     */
    public function batchStoreQuran(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'quran' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->quran as $studentId => $data) {
            $makhraj = !empty($data['makhraj']) ? (float)$data['makhraj'] : 85;
            $tajwid = !empty($data['tajwid']) ? (float)$data['tajwid'] : 85;
            $lagu = !empty($data['lagu_hijaz']) ? (float)$data['lagu_hijaz'] : 85;
            $adab = !empty($data['adab']) ? (float)$data['adab'] : 90;

            $scores = [
                'makhraj' => $makhraj,
                'tajwid' => $tajwid,
                'lagu_hijaz' => $lagu,
                'adab' => $adab,
            ];
            $finalScore = round(($makhraj + $tajwid + $lagu + $adab) / 4, 1);

            $predicate = 'Jayyid (Baik)';
            if ($finalScore >= 90) $predicate = 'Mumtaz (Istimewa)';
            elseif ($finalScore >= 80) $predicate = 'Jayyid Jiddan (Sangat Baik)';
            elseif ($finalScore >= 70) $predicate = 'Jayyid (Baik)';
            elseif ($finalScore > 0) $predicate = 'Maqbul (Cukup)';

            QuranGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'tahsin_method' => $data['tahsin_method'] ?? 'Wafa',
                    'tahsin_level' => $data['tahsin_level'] ?? 'Buku Wafa 3 Hal 25',
                    'tahsin_scores' => $scores,
                    'tahsin_final_score' => $finalScore,
                    'tahsin_predicate' => $predicate,
                    'tahsin_notes' => $data['tahsin_notes'] ?? 'Makhraj dan tajwid tertata baik, irama nada Wafa Hijaz teratur.',
                    'tahfidz_target' => $data['tahfidz_target'] ?? 'Juz 30 (An-Naba s/d An-Nas)',
                    'tahfidz_achievement' => $data['tahfidz_achievement'] ?? 'Tuntas Surat Al-A\'la s/d An-Nas',
                    'tahfidz_score' => !empty($data['tahfidz_score']) ? (float)$data['tahfidz_score'] : 90,
                    'tahfidz_predicate' => $data['tahfidz_predicate'] ?? 'Mutqin (Kuat)',
                    'tasmi_exam_result' => $data['tasmi_exam_result'] ?? 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Mumtaz',
                    'tahfidz_notes' => $data['tahfidz_notes'] ?? 'Hafalan mutqin, siap melangkah ke target ziyadah berikutnya.',
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH NILAI WAFA & TAHFIDZ',
                'model_type' => 'QuranGrade',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'quran'
        ])->with('success', "Berhasil menyimpan penilaian Al-Qur'an (Metode Wafa & Tahfidz) untuk {$savedCount} santri!");
    }

    /**
     * Batch Store Penilaian Karakter 7 SKL JSIT & BPI 1 Kelas Sekaligus
     */
    public function batchStoreCharacter(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'character' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->character as $studentId => $data) {
            $indicators = $data['indicators'] ?? [
                'salimul_aqidah' => 'SB',
                'shahihul_ibadah' => 'SB',
                'matinul_khuluq' => 'SB',
                'qowiyyul_jismi' => 'B',
                'mutsaqqoful_fikri' => 'SB',
                'qodirun_alal_kasbi' => 'B',
                'munazzhomun' => 'SB',
            ];

            CharacterGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'indicator_scores' => $indicators,
                    'mutabaah_sholat_fardhu' => $data['mutabaah_sholat_fardhu'] ?? 'Selalu Berjamaah di Masjid',
                    'mutabaah_sholat_dhuha' => $data['mutabaah_sholat_dhuha'] ?? 'Rutin Setiap Hari',
                    'mutabaah_tilawah' => $data['mutabaah_tilawah'] ?? 'Rutin 1/2 Juz per Hari',
                    'mutabaah_infaq' => $data['mutabaah_infaq'] ?? 'Rutin Infaq Jumat',
                    'bpi_mentor_notes' => $data['bpi_mentor_notes'] ?? 'Ananda menunjukkan profil karakter muslim tangguh dan istiqomah dalam ibadah yaumiyah.',
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH KARAKTER 7 SKL JSIT',
                'model_type' => 'CharacterGrade',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'character'
        ])->with('success', "Berhasil menyimpan evaluasi Karakter 7 SKL JSIT & BPI untuk {$savedCount} santri!");
    }

    /**
     * Batch Store Catatan Wali Kelas, Presensi & Kesehatan 1 Kelas Sekaligus
     */
    public function batchStoreHomeroom(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'homeroom' => 'required|array',
        ]);

        $savedCount = 0;
        foreach ($request->homeroom as $studentId => $data) {
            $ekskul = [];
            if (!empty($data['ekskul_name'])) {
                $ekskul[] = [
                    'name' => $data['ekskul_name'],
                    'score' => $data['ekskul_score'] ?? 'A',
                    'notes' => $data['ekskul_notes'] ?? 'Disiplin dan berjiwa ksatria',
                ];
            }

            HomeroomNote::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'academic_year_id' => $request->academic_year_id,
                ],
                [
                    'sick_count' => (int) ($data['sick_count'] ?? 0),
                    'permission_count' => (int) ($data['permission_count'] ?? 0),
                    'absent_count' => (int) ($data['absent_count'] ?? 0),
                    'height_cm' => !empty($data['height_cm']) ? (float)$data['height_cm'] : null,
                    'weight_kg' => !empty($data['weight_kg']) ? (float)$data['weight_kg'] : null,
                    'hearing_health' => $data['hearing_health'] ?? 'Sangat Baik / Normal',
                    'vision_health' => $data['vision_health'] ?? 'Sangat Baik / Normal',
                    'dental_health' => $data['dental_health'] ?? 'Bersih & Terawat',
                    'extracurriculars' => !empty($ekskul) ? $ekskul : null,
                    'notes' => $data['notes'] ?? 'Pertahankan prestasi ananda dan terus bersemangat menggapai cita-cita mulia.',
                ]
            );
            $savedCount++;
        }

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BATCH WALI KELAS & PRESENSI',
                'model_type' => 'HomeroomNote',
                'model_id' => $request->classroom_id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->route('admin.academic.grades', [
            'school_id' => $request->school_id,
            'classroom_id' => $request->classroom_id,
            'menu' => 'homeroom'
        ])->with('success', "Berhasil menyimpan rekap kehadiran dan catatan wali kelas untuk {$savedCount} siswa!");
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

        $student = Student::findOrFail($request->student_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Siswa ini bukan dari unit sekolah Anda.');
        }

        $score = (float) $request->score;
        $notes = $request->notes;
        if (empty($notes)) {
            if ($score >= 90) {
                $notes = 'Menunjukkan penguasaan capaian pembelajaran yang sangat istimewa (Mumtaz) dan mampu bernalar kritis secara mandiri.';
            } elseif ($score >= 80) {
                $notes = 'Menunjukkan penguasaan capaian pembelajaran yang amat baik dan aktif dalam pemecahan masalah.';
            } elseif ($score >= 70) {
                $notes = 'Menunjukkan penguasaan capaian pembelajaran yang cukup baik, perlu peningkatan pada materi lanjutan.';
            } else {
                $notes = 'Memerlukan bimbingan dan remedial berkelanjutan untuk mencapai ketuntasan tujuan pembelajaran.';
            }
        }

        $grd = Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'academic_year_id' => $request->academic_year_id,
                'assessment_type' => $request->type,
            ],
            [
                'competency_code' => $request->competency_code ?? 'TP-MERDEKA',
                'score' => $score,
                'notes' => $notes,
            ]
        );

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'PENILAIAN AKADEMIK',
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
    public function reportCard($studentId, Request $request)
    {
        $user = auth()->user();
        $student = Student::with(['school', 'classroom.homeroomTeacher', 'guardian'])->findOrFail($studentId);
        $grades = Grade::where('student_id', $studentId)->with('subject')->get();
        $quranGrade = QuranGrade::where('student_id', $studentId)->first();
        $characterGrade = CharacterGrade::where('student_id', $studentId)->first();
        $homeroomNote = HomeroomNote::where('student_id', $studentId)->first();
        $reportSetting = ReportSetting::where('school_id', $student->school_id)->first();
        $quranCriteria = QuranCriterion::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->orderBy('order_number')->get();
        $characterIndicators = CharacterIndicator::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->orderBy('order_number')->get();

        $printType = $request->query('type', 'all_in_one'); // all_in_one, academic, quran, character, leger

        $classStudents = collect();
        $classSubjects = collect();
        if ($printType === 'leger') {
            $classStudents = Student::where('classroom_id', $student->classroom_id)->with(['grades.subject'])->get();
            $classSubjects = Subject::where(fn($q) => $q->where('school_id', $student->school_id)->orWhereNull('school_id'))->get();
        }

        return view('admin.academic.report_card', compact(
            'student',
            'grades',
            'academicYear',
            'quranGrade',
            'characterGrade',
            'homeroomNote',
            'reportSetting',
            'quranCriteria',
            'characterIndicators',
            'printType',
            'classStudents',
            'classSubjects'
        ));
    }

    /**
     * Download / Export Leger Nilai Rombel ke format CSV/Excel (Sesuai e-Rapor SD)
     */
    public function exportLeger(Request $request)
    {
        $user = auth()->user();
        $classroomId = $request->query('classroom_id');
        $classroom = Classroom::with(['school', 'homeroomTeacher'])->findOrFail($classroomId);

        // Strict multi-unit access restriction:
        if ($user && !$user->isSuperAdmin() && $user->school_id && $classroom->school_id != $user->school_id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengunduh leger dari unit sekolah lain.');
        }

        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();
        
        $classStudents = Student::where('classroom_id', $classroomId)
            ->with(['grades.subject'])
            ->orderBy('nis')
            ->get();
            
        $classSubjects = Subject::where(fn($q) => $q->where('school_id', $classroom->school_id)->orWhereNull('school_id'))->get();
        
        $cleanClassName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $classroom->name);
        $filename = 'Leger_Nilai_' . $cleanClassName . '_' . date('Ymd_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        $callback = function() use ($classroom, $academicYear, $classStudents, $classSubjects) {
            $output = fopen('php://output', 'w');
            
            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Document Header
            fputcsv($output, ['LEGER REKAPITULASI NILAI HASIL BELAJAR SISWA']);
            fputcsv($output, ['Satuan Pendidikan', $classroom->school->name ?? 'SIT Robbani']);
            fputcsv($output, ['Rombongan Belajar', $classroom->name]);
            fputcsv($output, ['Wali Kelas', $classroom->homeroomTeacher->name ?? '-']);
            fputcsv($output, ['Tahun Pelajaran / Semester', ($academicYear->name ?? '2026/2027') . ' / ' . ($academicYear->semester ?? 'Ganjil')]);
            fputcsv($output, ['Tanggal Unduh', date('d/m/Y H:i')]);
            fputcsv($output, []); // Empty row
            
            // Table Header
            $tableHeaders = ['No', 'NIS', 'NISN', 'Nama Lengkap Siswa', 'L/P'];
            foreach ($classSubjects as $sb) {
                $tableHeaders[] = $sb->name . ' (' . ($sb->code ?? 'MP') . ')';
            }
            $tableHeaders[] = 'Rata-Rata';
            $tableHeaders[] = 'Predikat';
            fputcsv($output, $tableHeaders);
            
            // Rows
            foreach ($classStudents as $idx => $st) {
                $scores = [];
                $numericScores = [];
                foreach ($classSubjects as $sb) {
                    $grade = $st->grades->firstWhere('subject_id', $sb->id);
                    $scoreVal = $grade ? $grade->score : 88;
                    $scores[] = $scoreVal;
                    $numericScores[] = $scoreVal;
                }
                
                $avg = !empty($numericScores) ? round(array_sum($numericScores) / count($numericScores), 1) : 0;
                $pred = $avg >= 85 ? 'A' : ($avg >= 75 ? 'B' : ($avg >= 65 ? 'C' : 'D'));
                
                $row = [
                    $idx + 1,
                    $st->nis,
                    $st->nisn ?? '-',
                    $st->full_name,
                    $st->gender ?? 'L',
                ];
                
                foreach ($scores as $s) {
                    $row[] = $s;
                }
                
                $row[] = $avg;
                $row[] = $pred;
                
                fputcsv($output, $row);
            }
            
            fclose($output);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
