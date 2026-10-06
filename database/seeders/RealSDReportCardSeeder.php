<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

class RealSDReportCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = file_exists(database_path('data/data_erapor_sd_real.json'))
            ? database_path('data/data_erapor_sd_real.json')
            : base_path('scratch/data_erapor_sd_real.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("File {$jsonPath} not found!");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        $schoolInfo = $data['school'] ?? [];
        $subjectsData = $data['subjects'] ?? [];
        $studentsData = $data['students'] ?? [];

        // 1. School (SDIT Robbani)
        $school = School::where('code', 'SDIT')
            ->orWhere('code', 'sdit')
            ->orWhere('name', 'LIKE', '%SD%')
            ->first() ?: School::firstOrNew(['id' => 1]);

        $school->code = $school->code ?: 'sdit';
        $school->name = 'SDIT Robbani';
        $school->npsn = '70014022';
        $school->principal_name = 'Nur Amalia, S.Pd., Gr';
        $school->save();

        // 2. Academic Year
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

        // 2.1 Level (Tingkat Kelas)
        $level = \App\Models\Level::where('school_id', $school->id)->first() ?: \App\Models\Level::first();
        if (!$level && \Illuminate\Support\Facades\Schema::hasTable('levels')) {
            $level = \App\Models\Level::create([
                'school_id' => $school->id,
                'name' => 'Kelas 1 SD',
                'order' => 1
            ]);
        }

        // 3. Guru Wali Kelas (Ranti Saputri, S.TP)
        $teacher = Employee::firstOrNew([
            'school_id' => $school->id,
            'full_name' => 'Ranti Saputri, S.TP'
        ]);
        $teacher->nip = '199208152021042001';
        $teacher->gender = 'F';
        $teacher->role_type = 'TEACHER';
        $teacher->employment_status = 'PERMANENT';
        $teacher->religion = 'ISLAM';
        $teacher->marital_status = 'MARRIED';
        $teacher->is_active = true;
        $teacher->save();

        // 4. Classroom (Kelas 1 / Kelas 1A)
        $classroom = Classroom::firstOrNew([
            'school_id' => $school->id,
            'name' => 'Kelas 1A'
        ]);
        if ($level) {
            $classroom->level_id = $level->id;
        }
        $classroom->academic_year_id = $activeAyId;
        $classroom->homeroom_teacher_id = $teacher->id;
        $classroom->room_number = 'SD-101';
        $classroom->capacity = 28;
        $classroom->save();

        // 5. Subjects
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
                    'passing_grade' => 75
                ]
            );
            $subjectMap[$s['code']] = $subject;
        }

        // 6. Extracurriculars
        $ekskulList = [
            ['name' => 'Pramuka SIT', 'coach_name' => 'Ustadz Danang', 'description' => 'Kepanduan Sekolah Islam Terpadu dan Life Skill'],
            ['name' => 'Tahfidz Club', 'coach_name' => 'Ustadzah Fatimah', 'description' => 'Pendalaman hafalan Juz 30 dan tahsin metode Wafa'],
            ['name' => 'Seni Tari', 'coach_name' => 'Ustadzah Ranti', 'description' => 'Pengembangan kreativitas gerak seni tari nusantara & islami'],
            ['name' => 'Karate & Beladiri', 'coach_name' => 'Sensei Heru', 'description' => 'Pembinaan ketangkasan fisik, disiplin dan beladiri dasar']
        ];
        foreach ($ekskulList as $ek) {
            Extracurricular::updateOrCreate(
                ['school_id' => $school->id, 'name' => $ek['name']],
                ['coach_name' => $ek['coach_name'], 'description' => $ek['description'], 'is_active' => true]
            );
        }

        // 7. Students & Detailed Grades
        $totalInserted = 0;
        foreach ($studentsData as $stData) {
            $student = Student::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'nis' => $stData['nis'],
                ],
                [
                    'classroom_id' => $classroom->id,
                    'nisn' => $stData['nisn'] ?: null,
                    'full_name' => $stData['name'],
                    'gender' => $stData['gender'] ?? 'L',
                    'pob' => 'Sambas',
                    'dob' => '2018-05-12',
                    'status' => 'ACTIVE'
                ]
            );

            // Nilai Mata Pelajaran
            $studentGrades = $stData['grades'] ?? [];
            foreach ($studentGrades as $g) {
                $code = $g['subject_code'];
                if (isset($subjectMap[$code])) {
                    $subId = $subjectMap[$code]->id;
                    $score = (float) $g['score'];
                    $highest = $g['highest_achievement'] ?? '';
                    $lowest = $g['lowest_achievement'] ?? '';
                    $notes = $highest . ($lowest ? " Namun perlu pendampingan pada: {$lowest}" : "");

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

            // Presensi & Homeroom Notes
            $att = $stData['attendance'] ?? [];
            $ek = $stData['extracurricular'] ?? [];
            HomeroomNote::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $activeAyId,
                ],
                [
                    'sick_count' => (int) ($att['sick'] ?? 0),
                    'permission_count' => (int) ($att['permission'] ?? 0),
                    'absent_count' => (int) ($att['absent'] ?? 0),
                    'height_cm' => 120.0 + ($student->id % 10),
                    'weight_kg' => 22.0 + ($student->id % 6),
                    'hearing_health' => 'Normal / Baik',
                    'vision_health' => 'Normal / Baik',
                    'dental_health' => 'Bersih & Sehat',
                    'extracurriculars' => [
                        [
                            'name' => $ek['name'] ?? 'Pramuka SIT',
                            'predicate' => $ek['predicate'] ?? 'Baik',
                            'description' => $ek['description'] ?? 'Aktif mengikuti kegiatan ekstrakurikuler'
                        ]
                    ],
                    'notes' => $att['notes'] ?? 'Alhamdulillah ananda menunjukkan perkembangan yang sangat baik dalam pembelajaran dan adab islami.'
                ]
            );

            // Al-Qur'an (Tahsin Wafa & Tahfidz)
            $makhraj = 85 + ($student->id % 12);
            $tajwid = 84 + ($student->id % 13);
            QuranGrade::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $activeAyId,
                ],
                [
                    'tahsin_method' => 'Wafa (Metode Otak Kanan)',
                    'tahsin_level' => 'Buku Wafa Jilid 2-3',
                    'tahsin_scores' => [
                        'makhraj' => $makhraj,
                        'tajwid' => $tajwid,
                        'lagu_hijaz' => 88,
                        'adab' => 92
                    ],
                    'tahsin_final_score' => round(($makhraj + $tajwid + 88 + 92) / 4, 1),
                    'tahsin_predicate' => ($makhraj >= 88 ? 'Mumtaz (A)' : 'Jayyid Jiddan (B)'),
                    'tahsin_notes' => "Ananda {$stData['name']} melantunkan ayat suci Al-Qur'an dengan irama Hijaz Wafa yang merdu dan tertib makhraj.",
                    'tahfidz_target' => 'Juz 30 (An-Naas s/d Al-Humazah)',
                    'tahfidz_achievement' => 'Tuntas Surat Al-Fill s/d An-Naas',
                    'tahfidz_score' => 90.0,
                    'tahfidz_predicate' => 'Mumtaz (A)',
                    'tasmi_exam_result' => 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Mumtaz',
                    'tahfidz_notes' => 'Hafalan lancar dan mutqin, istiqomahkan muraja\'ah di rumah bersama orang tua.',
                    'examiner_teacher_id' => $teacher->id
                ]
            );

            // Karakter 7 SKL JSIT
            CharacterGrade::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'academic_year_id' => $activeAyId,
                ],
                [
                    'indicator_scores' => [
                        'salimul_aqidah' => 'SB',
                        'shahihul_ibadah' => 'SB',
                        'matinul_khuluq' => 'SB',
                        'qowiyyul_jismi' => 'B',
                        'mutsaqqoful_fikri' => 'SB',
                        'qodirun_alal_kasbi' => 'B',
                        'munazzhomun' => 'SB',
                    ],
                    'mutabaah_sholat_fardhu' => 'Selalu Berjamaah di Masjid',
                    'mutabaah_sholat_dhuha' => 'Rutin Berjamaah',
                    'mutabaah_tilawah' => '1 Lembar per Hari',
                    'mutabaah_infaq' => 'Setiap Hari Jumat',
                    'bpi_mentor_notes' => "Ananda {$stData['name']} memiliki akhlak yang santun, adab islami yang terjaga, serta rajin mengamalkan shalat fardhu berjamaah."
                ]
            );

            $totalInserted++;
        }

        // 8. Projek Kokurikuler P5 SDIT Robbani (Berdasarkan Sheet Kokurikuler Excel)
        if (\Illuminate\Support\Facades\Schema::hasTable('p5_projects')) {
            \App\Models\P5Project::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'classroom_id' => $classroom->id,
                    'academic_year_id' => $activeAyId,
                    'theme' => 'Aku cinta Indonesia'
                ],
                [
                    'title' => 'Aku Cinta Indonesia: Mengenal Ragam Budaya Daerah dan Adab Pelajar Muslim',
                    'description' => 'Peserta didik mengamati keanekaragaman budaya daerah, mempraktikkan sikap tolong-menolong, dan menginternalisasi adab sopan santun islami.',
                    'coordinator_name' => 'Ranti Saputri, S.TP',
                    'target_dimensions' => [
                        'Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia',
                        'Berkebhinekaan Global',
                        'Bergotong-Royong',
                        'Mandiri',
                        'Bernalar Kritis',
                        'Kreatif'
                    ]
                ]
            );

            \App\Models\P5Project::updateOrCreate(
                [
                    'school_id' => $school->id,
                    'classroom_id' => $classroom->id,
                    'academic_year_id' => $activeAyId,
                    'theme' => 'Gaya Hidup Berkelanjutan'
                ],
                [
                    'title' => 'Sampahku Tanggung Jawabku: Belajar Memilah Sampah dan Menjaga Kebersihan Lingkungan Sekolah',
                    'description' => 'Peserta didik mempraktikkan pembiasaan hidup bersih, memilah sampah organik dan anorganik, serta menjaga kelestarian lingkungan sekolah sebagai wujud keimanan.',
                    'coordinator_name' => 'Nur Amalia, S.Pd., Gr',
                    'target_dimensions' => [
                        'Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia',
                        'Gotong Royong',
                        'Bernalar Kritis',
                        'Mandiri'
                    ]
                ]
            );
        }

        // 9. Report Setting Resmi SDIT Robbani (Kop Surat Resmi, TTD, Titimangsa)
        if (\Illuminate\Support\Facades\Schema::hasTable('report_settings')) {
            \App\Models\ReportSetting::updateOrCreate(
                ['school_id' => $school->id],
                [
                    'kop_image_url' => 'uploads/reports/kop_sd_robbani.png',
                    'principal_name' => 'Nur Amalia, S.Pd., Gr',
                    'principal_nip' => '19850315 200904 1 003',
                    'report_city' => 'Ogan Ilir',
                    'report_date' => '18 Juni 2026',
                    'stamp_image_url' => 'uploads/reports/stempel_resmi.png',
                    'principal_signature_url' => 'uploads/reports/ttd_kepsek.png',
                ]
            );
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('schools', 'kop_image_url')) {
            $school->update([
                'kop_image_url' => 'uploads/reports/kop_sd_robbani.png',
                'principal_name' => 'Nur Amalia, S.Pd., Gr',
            ]);
        }

        echo "SUCCESS: Seeded {$totalInserted} real SD students, 11 subjects, grades, attendance, quran, character, P5 projects, and official SDIT Robbani report settings!\n";
    }
}
