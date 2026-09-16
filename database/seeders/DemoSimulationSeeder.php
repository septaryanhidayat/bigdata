<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\QuranGrade;
use App\Models\CharacterGrade;
use App\Models\HomeroomNote;
use App\Models\ReportSetting;

class DemoSimulationSeeder extends Seeder
{
    public function run(): void
    {
        $academicYear = AcademicYear::where('is_active', 1)->first() ?? AcademicYear::first();
        $academicYearId = $academicYear ? $academicYear->id : 1;

        $schools = School::all();

        // 1. Setup Proper Rombel per Unit
        $classroomsConfig = [
            1 => [ // TKIT
                ['name' => 'TK A - Khadijah', 'capacity' => 20],
                ['name' => 'TK B - Aisyah', 'capacity' => 20],
            ],
            2 => [ // SDIT
                ['name' => '1 - Abu Bakar Ash-Shiddiq', 'capacity' => 28],
                ['name' => '1 - Umar bin Khattab', 'capacity' => 28],
                ['name' => '2 - Utsman bin Affan', 'capacity' => 28],
                ['name' => '3 - Ali bin Abi Thalib', 'capacity' => 28],
            ],
            3 => [ // SMPIT
                ['name' => 'Kelas 7A Tahfidz Unggulan', 'capacity' => 30],
                ['name' => '7 - Aisyah binti Abu Bakar', 'capacity' => 30],
                ['name' => '8 - Ali bin Abi Thalib', 'capacity' => 30],
                ['name' => '8 - Khadijah Al-Kubra', 'capacity' => 30],
            ],
            4 => [ // SMAIT
                ['name' => '10 - MIPA 1 Al-Khawarizmi', 'capacity' => 30],
                ['name' => '10 - IPS 1 Ibnu Khaldun', 'capacity' => 30],
                ['name' => '11 - MIPA 1 Ibnu Sina', 'capacity' => 30],
            ],
        ];

        // Delete test bogus classrooms (like "Test Kelas 9-Ali" in TKIT)
        Classroom::where('name', 'like', '%Test%')->delete();

        $allCreatedClassrooms = [];

        foreach ($schools as $school) {
            $configs = $classroomsConfig[$school->id] ?? [];
            $teachers = Employee::where('school_id', $school->id)->get();
            if ($teachers->isEmpty()) {
                $teachers = Employee::all();
            }

            $level = \App\Models\Level::where('school_id', $school->id)->first();
            if (!$level) {
                $level = \App\Models\Level::create([
                    'school_id' => $school->id,
                    'code' => $school->code . '-LVL',
                    'name' => 'Kelompok ' . $school->code,
                    'sort_order' => 1,
                ]);
            }

            foreach ($configs as $idx => $cfg) {
                $teacher = $teachers->get($idx % $teachers->count());
                $cls = Classroom::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'name' => $cfg['name'],
                    ],
                    [
                        'level_id' => $level->id,
                        'academic_year_id' => $academicYearId,
                        'capacity' => $cfg['capacity'],
                        'homeroom_teacher_id' => $teacher?->id,
                    ]
                );
                $allCreatedClassrooms[] = $cls;
            }

            // Update Report Settings with Real Generated Kop, Stamp & Signature
            ReportSetting::updateOrCreate(
                ['school_id' => $school->id],
                [
                    'kop_image_url' => '/uploads/reports/kop_resmi_sit.png',
                    'stamp_image_url' => '/uploads/reports/stempel_resmi.png',
                    'principal_signature_url' => '/uploads/reports/ttd_kepsek.png',
                    'school_logo_url' => '/uploads/reports/kop_resmi_sit.png',
                    'principal_name' => $school->principal_name ?? ($school->code === 'SMPIT' ? 'Ustadz H. Ahmad Fauzi, M.Pd.' : ($school->code === 'SDIT' ? 'Ustadzah Siti Fatimah, S.Pd.I.' : 'Ustadz Muhammad Arifin, M.Pd.')),
                    'principal_nip' => '19850315 200904 1 003',
                    'report_city' => 'Kota Bandung',
                    'report_date' => '20 Desember 2026',
                ]
            );
        }

        // 2. Realistic Muslim Student Names for Seeding
        $maleNames = [
            'Muhammad Al-Fatih Pratama',
            'Fathir Ar-Razi Al-Ghifari',
            'Bilal Ramadhan Asy-Syahid',
            'Zaidan Raihan Al-Mubarak',
            'Hamzah Dzulfiqar Robbani',
            'Dzaki Hafizhurrahman',
            'Ibrahim Malik Syahputra',
            'Sulaiman Azzam Hakim',
        ];

        $femaleNames = [
            'Zahra Salsabila Khairunnisa',
            'Aisyah Humaira Putri',
            'Maryam Yasmin Robbani',
            'Khadijah Az-Zahra',
            'Nabila Syifa Al-Hasani',
            'Fathimah Mumtazah',
            'Alya Syakira Rahman',
        ];

        $wafaLevels = [
            'Buku Wafa 2 Hal 15',
            'Buku Wafa 3 Hal 20',
            'Buku Wafa 4 Hal 10',
            'Buku Wafa 5 Hal 28',
            'Al-Qur\'an Juz 30 (Tajwid)',
            'Al-Qur\'an Juz 29 (Tahfidz)',
        ];

        $tahfidzTargets = [
            'Surah An-Naba s.d. An-Nazi\'at (Mutqin)',
            'Surah Al-Infitar s.d. Al-Muthaffifin (Mutqin)',
            'Juz 30 Lengkap (Tasmi\' Mumtaz)',
            'Juz 29 s.d. Surah Al-Mulk (Mutqin)',
            'Surah Al-Qalam s.d. Al-Ma\'arij (Lancar)',
        ];

        echo "Seeding students and grades into " . count($allCreatedClassrooms) . " classrooms...\n";

        foreach ($allCreatedClassrooms as $cls) {
            $schoolId = $cls->school_id;
            $subjects = Subject::where(function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId)->orWhereNull('school_id');
            })->get();
            if ($subjects->isEmpty()) {
                $subjects = Subject::all();
            }

            // Seed 10-12 students per class if less than 10
            $existingCount = Student::where('classroom_id', $cls->id)->count();
            $targetCount = 12;

            for ($i = $existingCount; $i < $targetCount; $i++) {
                $isMale = ($i % 2 === 0);
                $namePool = $isMale ? $maleNames : $femaleNames;
                $name = $namePool[$i % count($namePool)] . ' ' . chr(65 + ($cls->id % 5));
                $nis = sprintf("%02d%02d%04d", $schoolId, $cls->id, 100 + $i + 1);
                $nisn = '00' . rand(10000000, 99999999);

                $student = Student::firstOrCreate(
                    [
                        'school_id' => $schoolId,
                        'nis' => $nis,
                    ],
                    [
                        'classroom_id' => $cls->id,
                        'nisn' => $nisn,
                        'full_name' => $name,
                        'gender' => $isMale ? 'M' : 'F',
                        'status' => 'ACTIVE',
                    ]
                );

                // Make sure classroom_id is updated
                $student->update(['classroom_id' => $cls->id]);

                // 3. Seed Real Academic Grades for 5-8 subjects
                foreach ($subjects->take(6) as $sb) {
                    $score = rand(82, 96);
                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'subject_id' => $sb->id,
                            'academic_year_id' => $academicYearId,
                            'assessment_type' => 'SUMATIF_AKHIR_SEMESTER',
                        ],
                        [
                            'competency_code' => 'TP-1',
                            'score' => $score,
                            'notes' => $score >= 90
                                ? 'Menunjukkan penguasaan capaian pembelajaran yang istimewa (Mumtaz) pada seluruh materi dan mampu bernalar kritis secara mandiri.'
                                : 'Menunjukkan penguasaan yang sangat baik dalam memahami konsep materi dan aktif dalam diskusi pembelajaran.',
                        ]
                    );
                }

                // 4. Seed Real Quran Wafa Grade
                QuranGrade::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'academic_year_id' => $academicYearId,
                    ],
                    [
                        'tahsin_method' => 'Wafa (Metode Hijaz)',
                        'tahsin_level' => $wafaLevels[$i % count($wafaLevels)],
                        'tahsin_scores' => [
                            'makhraj' => rand(86, 96),
                            'tajwid' => rand(85, 95),
                            'lagu_hijaz' => rand(85, 94),
                            'adab' => rand(90, 98),
                        ],
                        'tahsin_final_score' => rand(88, 95),
                        'tahsin_predicate' => 'A (Mumtaz)',
                        'tahsin_notes' => 'Ananda menunjukkan kecintaan dan adab yang tinggi terhadap Al-Qur\'an, pelafalan makhorijul huruf sangat fasih.',
                        'tahfidz_target' => $tahfidzTargets[$i % count($tahfidzTargets)],
                        'tahfidz_achievement' => 'Tercapai 100% dengan kelancaran tajwid dan tartil sesuai irama Hijaz Wafa',
                        'tahfidz_score' => rand(87, 96),
                        'tahfidz_predicate' => 'A',
                        'tasmi_exam_result' => ($i % 3 === 0) ? 'LULUS TASMI 1 JUZ (MUMTAZ)' : 'LULUS TARTIL WAFA',
                        'tahfidz_notes' => 'Hafalan sangat mutqin dan lancar sekali duduk.',
                    ]
                );

                // 5. Seed Real Character 7 SKL Grade
                CharacterGrade::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'academic_year_id' => $academicYearId,
                    ],
                    [
                        'indicator_scores' => [
                            'SKL_1' => ['score' => rand(88, 98), 'predicate' => 'BSB', 'desc' => 'Meyakini Allah Maha Melihat dan istiqomah zikir'],
                            'SKL_2' => ['score' => rand(86, 96), 'predicate' => 'BSB', 'desc' => 'Tertib shalat fardhu berjamaah dan shalat dhuha'],
                            'SKL_3' => ['score' => rand(88, 95), 'predicate' => 'BSB', 'desc' => 'Santun bertutur kata 3S dan berbakti kepada orang tua'],
                            'SKL_4' => ['score' => rand(84, 92), 'predicate' => 'BSH', 'desc' => 'Menjaga kebersihan diri dan gemar berolahraga'],
                            'SKL_5' => ['score' => rand(85, 94), 'predicate' => 'BSH', 'desc' => 'Gemar membaca dan aktif bernalar kritis'],
                            'SKL_6' => ['score' => rand(86, 95), 'predicate' => 'BSB', 'desc' => 'Mandiri menyiapkan perlengkapan dan gemar berinfaq'],
                            'SKL_7' => ['score' => rand(88, 96), 'predicate' => 'BSB', 'desc' => 'Tertib jadwal harian dan disiplin hadir tepat waktu'],
                        ],
                        'mutabaah_sholat_fardhu' => 'Sangat Tertib Berjamaah',
                        'mutabaah_sholat_dhuha' => 'Tertib Melazimkan',
                        'mutabaah_tilawah' => 'Rutin 1 Lembar / Hari',
                        'mutabaah_infaq' => 'Rutin Infaq Jumat',
                        'bpi_mentor_notes' => 'Ananda menunjukkan kematangan akhlak islami yang membanggakan serta istiqomah dalam ibadah harian.',
                    ]
                );

                // 6. Seed Real Homeroom Note & Attendance
                HomeroomNote::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'academic_year_id' => $academicYearId,
                    ],
                    [
                        'sick_count' => rand(0, 2),
                        'permission_count' => rand(0, 1),
                        'absent_count' => 0,
                        'height_cm' => rand(135, 165),
                        'weight_kg' => rand(30, 52),
                        'hearing_health' => 'Normal / Sehat',
                        'vision_health' => 'Normal / Sehat',
                        'dental_health' => 'Bersih & Terawat',
                        'extracurriculars' => [
                            ['name' => 'Pramuka SIT', 'predicate' => 'Sangat Baik', 'notes' => 'Aktif dalam giat perkemahan dan kepanduan'],
                            ['name' => 'Panahan Tradisional / Robotik', 'predicate' => 'Baik', 'notes' => 'Disiplin dan memiliki fokus tinggi'],
                        ],
                        'notes' => 'Prestasi belajar Ananda semester ini sangat membanggakan. Pertahankan ketekunan dan istiqomah dalam ibadah harian.',
                    ]
                );
            }
        }

        echo "Demo simulation data seeded successfully for all units!\n";
    }
}
