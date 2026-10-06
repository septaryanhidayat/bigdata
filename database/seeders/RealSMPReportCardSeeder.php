<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\School;
use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Grade;
use App\Models\HomeroomNote;
use App\Models\Extracurricular;
use App\Models\QuranGrade;
use App\Models\CharacterGrade;
use App\Models\Employee;
use App\Models\User;
use App\Models\ReportSetting;
use App\Http\Controllers\Admin\AcademicController;

class RealSMPReportCardSeeder extends Seeder
{
    /**
     * Run the database seeds for Real SMP IT Robbani data.
     */
    public function run(): void
    {
        // 0. Ensure all extended columns & tables exist
        AcademicController::ensureExtendedTablesExist();

        $jsonPath = database_path('data/data_erapor_smp_real.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("File {$jsonPath} not found!");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        $schoolInfo = $data['school'] ?? [];
        $classroomInfo = $data['classroom'] ?? [];
        $subjectsData = $data['subjects'] ?? [];
        $studentsData = $data['students'] ?? [];
        $reportSettingInfo = $data['report_setting'] ?? [];

        // 1. School (SMP IT Robbani)
        $school = School::where('code', 'SMPIT')
            ->orWhere('code', 'smpit')
            ->orWhere('name', 'LIKE', '%SMP%')
            ->first();

        if (!$school) {
            $school = School::create([
                'code' => 'SMPIT',
                'name' => 'SMP Islam Terpadu Robbani',
                'npsn' => '20198033',
                'is_active' => true,
            ]);
        }

        $school->code = 'SMPIT';
        $school->name = 'SMP Islam Terpadu Robbani';
        $school->npsn = '20198033';
        $school->principal_name = 'Tia Wulandari, S.Pd.,Gr.';
        $school->address = 'Jl. Sarjana Gg. Padang Guci Kel. Timbangan';
        $school->phone = '+62 853-7719-3977';
        $school->email = 'smpit@sitrobbani.sch.id';

        if (Schema::hasColumn('schools', 'principal_nip')) {
            $school->principal_nip = '142062021012';
            $school->village = 'Timbangan';
            $school->district = 'Indralaya Utara';
            $school->city = 'Ogan Ilir';
            $school->province = 'Sumatera Selatan';
            $school->postal_code = '30662';
            $school->website = 'www.smp.sitrobbani.sch.id';
        }
        $school->save();

        // 2. Academic Year (2025/2026 Genap)
        $academicYear = AcademicYear::firstOrCreate(
            ['name' => '2025/2026', 'semester' => 'Genap'],
            [
                'curriculum_code' => 'MERDEKA',
                'start_date' => '2026-01-05',
                'end_date' => '2026-06-25',
                'is_active' => true
            ]
        );
        $activeAyId = $academicYear->id;

        // 3. Level (Kelas 9 SMP)
        $level = null;
        if (Schema::hasTable('levels')) {
            $level = \App\Models\Level::where('school_id', $school->id)
                ->where(function ($q) {
                    $q->where('name', 'LIKE', '%9%')
                      ->orWhere('name', 'LIKE', '%IX%');
                })->first();

            if (!$level) {
                $levelData = [
                    'school_id' => $school->id,
                    'name' => 'Kelas 9 SMP',
                ];
                if (Schema::hasColumn('levels', 'code')) {
                    $levelData['code'] = 'IX';
                }
                if (Schema::hasColumn('levels', 'sort_order')) {
                    $levelData['sort_order'] = 9;
                } elseif (Schema::hasColumn('levels', 'order')) {
                    $levelData['order'] = 9;
                }
                $level = \App\Models\Level::create($levelData);
            }
        }

        // 4. Tenaga Pendidik Real SMP
        // 4.1 Kepala Sekolah (Tia Wulandari, S.Pd.,Gr.)
        $principalEmployee = Employee::firstOrNew([
            'school_id' => $school->id,
            'full_name' => 'Tia Wulandari, S.Pd.,Gr.'
        ]);
        $principalEmployee->nip = '142062021012';
        $principalEmployee->role_type = 'PRINCIPAL';
        $principalEmployee->gender = 'F';
        $principalEmployee->religion = 'ISLAM';
        $principalEmployee->employment_status = 'PERMANENT';
        $principalEmployee->is_active = true;
        $principalEmployee->save();

        // 4.2 Wali Kelas IX (Sulis Setiya Ningsih, S.Pd.Gr.)
        $homeroomTeacher = Employee::firstOrNew([
            'school_id' => $school->id,
            'full_name' => 'Sulis Setiya Ningsih, S.Pd.Gr.'
        ]);
        $homeroomTeacher->nip = '-';
        $homeroomTeacher->role_type = 'TEACHER';
        $homeroomTeacher->gender = 'F';
        $homeroomTeacher->religion = 'ISLAM';
        $homeroomTeacher->employment_status = 'PERMANENT';
        $homeroomTeacher->is_active = true;
        $homeroomTeacher->save();

        // 4.3 Guru Tahfidz TTQ (Nurul Hamidah Yanti, S.E)
        $tahfidzTeacher = Employee::firstOrNew([
            'school_id' => $school->id,
            'full_name' => 'Nurul Hamidah Yanti, S.E'
        ]);
        $tahfidzTeacher->nip = '-';
        $tahfidzTeacher->role_type = 'TEACHER';
        $tahfidzTeacher->gender = 'F';
        $tahfidzTeacher->religion = 'ISLAM';
        $tahfidzTeacher->employment_status = 'PERMANENT';
        $tahfidzTeacher->is_active = true;
        $tahfidzTeacher->save();

        // 4.4 Pembina BPI (Syaifudin, S.Sn., Gr.)
        $bpiMentor = Employee::firstOrNew([
            'school_id' => $school->id,
            'full_name' => 'Syaifudin, S.Sn., Gr.'
        ]);
        $bpiMentor->nip = '-';
        $bpiMentor->role_type = 'TEACHER';
        $bpiMentor->gender = 'M';
        $bpiMentor->religion = 'ISLAM';
        $bpiMentor->employment_status = 'PERMANENT';
        $bpiMentor->is_active = true;
        $bpiMentor->save();

        // 5. Classroom (Kelas IX)
        $classroom = Classroom::firstOrNew([
            'school_id' => $school->id,
            'name' => 'Kelas IX'
        ]);
        if ($level) {
            $classroom->level_id = $level->id;
        }
        $classroom->academic_year_id = $activeAyId;
        $classroom->homeroom_teacher_id = $homeroomTeacher->id;
        $classroom->room_number = 'SMP-301';
        $classroom->capacity = 25;
        $classroom->save();

        // 6. 13 Mata Pelajaran Resmi SMP Sesuai PDF 1
        $subjectMap = [];
        foreach ($subjectsData as $s) {
            $subject = Subject::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'code' => $s['code'],
                ],
                [
                    'name' => $s['name'],
                    'category' => $s['category'] ?? 'NASIONAL',
                    'passing_grade' => $s['passing_grade'] ?? 75
                ]
            );
            $subjectMap[$s['code']] = $subject;
        }

        // 7. Ekstrakurikuler SMP
        $ekskulList = [
            ['name' => 'Pramuka SIT Robbani', 'coach_name' => 'Ustadz Danang', 'description' => 'Kepanduan dan life skills karakter islami'],
            ['name' => 'Seni Teater & Sastra', 'coach_name' => 'Ustadz Syaifudin, S.Sn.', 'description' => 'Olah peran teater islami dan literasi panggung'],
            ['name' => 'Futsal & Bela Diri', 'coach_name' => 'Ustadz Heru', 'description' => 'Ketangkasan fisik, sportivitas dan kesehatan raga'],
            ['name' => 'Klub Tahfidz Intensif', 'coach_name' => 'Ustadzah Nurul Hamidah, S.E', 'description' => 'Pemantapan hafalan Al-Baqarah dan tahsin tajwid']
        ];
        foreach ($ekskulList as $ek) {
            Extracurricular::updateOrCreate(
                ['school_id' => $school->id, 'name' => $ek['name']],
                ['coach_name' => $ek['coach_name'], 'description' => $ek['description'], 'is_active' => true]
            );
        }

        // 8. 9 Siswa Real SMP Kelas IX & Seluruh Penilaian
        $totalInserted = 0;
        foreach ($studentsData as $stData) {
            $student = Student::firstOrNew([
                'school_id' => $school->id,
                'nis' => $stData['nis'],
            ]);

            $student->classroom_id = $classroom->id;
            $student->nisn = $stData['nisn'] ?: null;
            $student->full_name = $stData['name'];
            $student->gender = $stData['gender'] ?? 'L';
            $student->pob = $stData['pob'] ?? 'Ogan Ilir';
            $student->dob = $stData['dob'] ?? '2011-05-12';
            $student->status = 'ACTIVE';

            // Biodata Lengkap Siswa & Orang Tua
            if (Schema::hasColumn('students', 'father_name')) {
                $student->father_name = $stData['father_name'] ?? null;
                $student->mother_name = $stData['mother_name'] ?? null;
                $student->father_job = $stData['father_job'] ?? null;
                $student->mother_job = $stData['mother_job'] ?? null;
                $student->address = $stData['address'] ?? null;
                $student->village = $stData['village'] ?? 'Timbangan';
                $student->district = $stData['district'] ?? 'Indralaya Utara';
                $student->city = $stData['city'] ?? 'Ogan Ilir';
                $student->province = $stData['province'] ?? 'Sumatera Selatan';
                $student->previous_school = 'SDIT Robbani';
            }

            // Sync ke bio_data JSON jika tersedia
            if (Schema::hasColumn('students', 'bio_data')) {
                $student->bio_data = array_merge($student->bio_data ?? [], [
                    'father_name' => $stData['father_name'] ?? null,
                    'mother_name' => $stData['mother_name'] ?? null,
                    'father_job' => $stData['father_job'] ?? null,
                    'mother_job' => $stData['mother_job'] ?? null,
                    'address' => $stData['address'] ?? null,
                    'village' => $stData['village'] ?? 'Timbangan',
                    'district' => $stData['district'] ?? 'Indralaya Utara',
                    'city' => $stData['city'] ?? 'Ogan Ilir',
                    'province' => $stData['province'] ?? 'Sumatera Selatan',
                    'quran_group' => 'Jannatu Al-Firdaus'
                ]);
            }

            $student->save();

            // Auto-create / update user account
            if (Schema::hasTable('users')) {
                $email = "siswa.{$stData['nis']}@sitrobbani.sch.id";
                $user = User::firstOrNew(['email' => $email]);
                if (!$user->exists) {
                    $user->name = $stData['name'];
                    $user->password = Hash::make('password123');
                    $user->school_id = $school->id;
                    $user->role = 'STUDENT';
                    $user->save();
                }
            }

            // 8.1 Simpan Nilai Akademik 13 Mata Pelajaran
            $grades = $stData['grades'] ?? [];
            foreach ($grades as $g) {
                $code = $g['subject_code'];
                if (isset($subjectMap[$code])) {
                    $subId = $subjectMap[$code]->id;
                    $score = (float) $g['score'];
                    $notes = $g['highest_achievement'] . ($g['lowest_achievement'] ? ". Namun {$g['lowest_achievement']}" : '');

                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'subject_id' => $subId,
                            'academic_year_id' => $activeAyId,
                        ],
                        [
                            'assessment_type' => 'FINAL',
                            'competency_code' => 'CP-SEM2',
                            'score' => $score,
                            'notes' => $notes
                        ]
                    );
                }
            }

            // 8.2 Simpan Nilai TTQ (Tahsin & Tahfidz SMP Sesuai PDF 2)
            $ttq = $stData['ttq'] ?? [];
            $hafalanScore = $ttq['hafalan_score'] ?? 'A';
            $tahsinScore = $ttq['tahsin_score'] ?? 'A';
            $tilawahScore = $ttq['tilawah_score'] ?? 'A';
            $targetHafalan = $ttq['hafalan_target'] ?? 'Hafalan Surah Al-Baqarah 1 – 50 ayat';

            QuranGrade::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $activeAyId,
                ],
                [
                    'tahsin_method' => 'Metode TTQ Robbani',
                    'tahsin_level' => 'Juz 1 – Juz 30',
                    'quran_group' => 'Jannatu Al-Firdaus',
                    'tahsin_scores' => [
                        'makhraj' => ($tahsinScore === 'A' ? 92 : 82),
                        'tajwid' => ($tahsinScore === 'A' ? 95 : 84),
                        'kelancaran' => ($tilawahScore === 'A' ? 94 : 85),
                        'adab' => 95
                    ],
                    'tahsin_final_score' => ($tahsinScore === 'A' ? 94.0 : 84.0),
                    'tahsin_predicate' => $tahsinScore,
                    'tahsin_notes' => "Alhamdulillah, ananda {$student->full_name} sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.",
                    'tilawah_predicate' => $tilawahScore,
                    'tahfidz_target' => $targetHafalan,
                    'tahfidz_achievement' => "Tuntas {$targetHafalan}",
                    'tahfidz_score' => ($hafalanScore === 'A' ? 95.0 : 82.0),
                    'tahfidz_predicate' => $hafalanScore,
                    'tasmi_exam_result' => "Lulus Ujian Tasmi' Al-Baqarah Predikat {$hafalanScore}",
                    'tahfidz_notes' => $ttq['notes'] ?? "Alhamdulillah, ananda {$student->full_name} sudah menuntaskan hafalan {$targetHafalan} dengan sangat baik.",
                    'examiner_teacher_id' => $tahfidzTeacher->id
                ]
            );

            // 8.3 Simpan Nilai BPI (Bina Pribadi Islam SMP Sesuai PDF 3)
            $bpi = $stData['bpi'] ?? [];
            $akidahScore = $bpi['akidah'] ?? 'A';
            $ibadahScore = $bpi['ibadah'] ?? 'B';

            CharacterGrade::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $activeAyId,
                ],
                [
                    'indicator_scores' => [
                        'akidah' => $akidahScore,
                        'ibadah' => $ibadahScore,
                        'salimul_aqidah' => $akidahScore,
                        'shahihul_ibadah' => $ibadahScore,
                        'bpi_attendance' => [
                            'sakit' => '-',
                            'izin' => '-',
                            'alpa' => '-',
                            'total' => 3
                        ]
                    ],
                    'mutabaah_sholat_fardhu' => 'Selalu Berjamaah di Masjid',
                    'mutabaah_sholat_dhuha' => 'Rutin Berjamaah',
                    'mutabaah_tilawah' => '1 Juz per Hari',
                    'mutabaah_infaq' => 'Setiap Hari Jumat',
                    'bpi_mentor_notes' => $bpi['notes'] ?? "Alhamdulillah, ananda {$student->full_name} sudah baik dalam memahami materi akidah yang lurus dan istiqomah dalam ibadah harian. Bismillah, ananda dapat terus belajar dan meningkatkan semangat dalam ibadah hariannya, sehingga kelak menjadi seorang muslim yang kaffah."
                ]
            );

            // 8.4 Presensi & Catatan Wali Kelas
            HomeroomNote::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $activeAyId,
                ],
                [
                    'sick_count' => 0,
                    'permission_count' => 0,
                    'absent_count' => 0,
                    'height_cm' => 155.0 + ($student->id % 15),
                    'weight_kg' => 45.0 + ($student->id % 12),
                    'hearing_health' => 'Normal / Baik',
                    'vision_health' => 'Normal / Baik',
                    'dental_health' => 'Bersih & Sehat',
                    'extracurriculars' => [
                        [
                            'name' => 'Pramuka SIT Robbani',
                            'predicate' => 'Sangat Baik',
                            'description' => 'Aktif dan disiplin dalam kepanduan SIT'
                        ],
                        [
                            'name' => 'Seni Teater & Sastra',
                            'predicate' => 'Baik',
                            'description' => 'Berperan aktif dalam pertunjukan teater islami'
                        ]
                    ],
                    'notes' => "Alhamdulillah ananda {$student->full_name} menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri."
                ]
            );

            $totalInserted++;
        }

        // 9. Report Setting Resmi SMP IT Robbani
        ReportSetting::updateOrCreate(
            ['school_id' => $school->id],
            [
                'school_logo_url' => 'uploads/reports/logo_smp_robbani.png',
                'kop_image_url' => 'uploads/reports/kop_smp_robbani.png',
                'principal_name' => 'Tia Wulandari, S.Pd.,Gr.',
                'principal_nip' => '142062021012',
                'report_city' => 'Ogan Ilir',
                'report_date' => '19 Juni 2026',
                'stamp_image_url' => 'uploads/reports/stempel_resmi.png',
                'principal_signature_url' => 'uploads/reports/ttd_kepsek.png',
            ]
        );

        if (Schema::hasColumn('schools', 'kop_image_url')) {
            $school->update([
                'kop_image_url' => 'uploads/reports/kop_smp_robbani.png',
                'logo_url' => 'uploads/reports/logo_smp_robbani.png',
                'principal_name' => 'Tia Wulandari, S.Pd.,Gr.',
            ]);
        }

        echo "SUCCESS: Seeded {$totalInserted} real SMP students, 13 subjects, grades, TTQ, BPI, attendance, and official SMP IT Robbani report settings!\n";
    }
}
