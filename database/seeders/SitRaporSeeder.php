<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\QuranCriterion;
use App\Models\QuranGrade;
use App\Models\CharacterIndicator;
use App\Models\CharacterGrade;
use App\Models\HomeroomNote;
use App\Models\ReportSetting;

class SitRaporSeeder extends Seeder
{
    public function run(): void
    {
        $schools = School::all();
        $academicYear = AcademicYear::first();
        $academicYearId = $academicYear ? $academicYear->id : null;

        $wafaCriteriaList = [
            ['category' => 'tahsin', 'code' => 'tilawah', 'name' => 'Kelancaran Membaca (Metode Wafa)', 'description' => 'Kelancaran membaca ayat demi ayat sesuai ritme Wafa', 'order_number' => 1],
            ['category' => 'tahsin', 'code' => 'makhraj', 'name' => 'Makharijul Huruf', 'description' => 'Ketepatan pengeluaran huruf hijaiyyah', 'order_number' => 2],
            ['category' => 'tahsin', 'code' => 'tajwid', 'name' => 'Hukum Tajwid & Mad', 'description' => 'Penerapan hukum nun mati, mim mati, dan panjang mad', 'order_number' => 3],
            ['category' => 'tahsin', 'code' => 'nada_wafa', 'name' => 'Irama Wafa (Lagu Hijaz)', 'description' => 'Penerapan 3 nada khas Wafa (rendah, sedang, tinggi)', 'order_number' => 4],
            ['category' => 'tahsin', 'code' => 'adab', 'name' => 'Adab & Kehadiran', 'description' => 'Sikap hormat, khusyuk, dan adab terhadap mushaf Al-Qur\'an', 'order_number' => 5],
        ];

        $jsitIndicatorsList = [
            ['standard_code' => 'SKL_1', 'standard_name' => '1. Salimul Aqidah (Akidah yang Bersih)', 'indicator_name' => 'Meyakini Allah Maha Melihat, bersyukur atas nikmat, menjauhi syirik, dan istiqomah berdoa.', 'order_number' => 1],
            ['standard_code' => 'SKL_2', 'standard_name' => '2. Shahihul Ibadah (Ibadah yang Benar)', 'indicator_name' => 'Tertib wudhu, shalat fardhu berjamaah tepat waktu, melazimkan shalat dhuha & zikir.', 'order_number' => 2],
            ['standard_code' => 'SKL_3', 'standard_name' => '3. Matinul Khuluq (Akhlak Mulia)', 'indicator_name' => 'Santun bertutur kata (3S), berbakti kepada orang tua & guru, amanah dan tidak berbohong.', 'order_number' => 3],
            ['standard_code' => 'SKL_4', 'standard_name' => '4. Qawiyyul Jismi (Fisik Kuat & Tangguh)', 'indicator_name' => 'Menjaga kebersihan diri & lingkungan, gemar berolahraga, dan makan makanan halal thoyyib.', 'order_number' => 4],
            ['standard_code' => 'SKL_5', 'standard_name' => '5. Mutsaqqoful Fikri (Wawasan Luas)', 'indicator_name' => 'Gemar membaca buku, aktif bertanya, kritis dalam memecahkan masalah, dan terampil bernalar.', 'order_number' => 5],
            ['standard_code' => 'SKL_6', 'standard_name' => '6. Qadirun \'alal Kasbi (Mandiri)', 'indicator_name' => 'Mandiri menyiapkan perlengkapan belajar, hemat, dan gemar berinfaq dari uang saku.', 'order_number' => 6],
            ['standard_code' => 'SKL_7', 'standard_name' => '7. Munazzhamun fi Syu\'unihi (Teratur & Disiplin)', 'indicator_name' => 'Tertata jadwal belajar harian, hadir tepat waktu, dan disiplin mengumpulkan tugas.', 'order_number' => 7],
        ];

        foreach ($schools as $school) {
            // Seed Quran Criteria per School
            foreach ($wafaCriteriaList as $crit) {
                QuranCriterion::updateOrCreate(
                    ['school_id' => $school->id, 'code' => $crit['code']],
                    array_merge($crit, ['school_id' => $school->id])
                );
            }

            // Seed Character Indicators per School
            foreach ($jsitIndicatorsList as $ind) {
                CharacterIndicator::updateOrCreate(
                    ['school_id' => $school->id, 'standard_code' => $ind['standard_code']],
                    array_merge($ind, ['school_id' => $school->id])
                );
            }

            // Seed Report Settings per School
            ReportSetting::updateOrCreate(
                ['school_id' => $school->id],
                [
                    'kop_header_text' => "YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI\n" . strtoupper($school->name) . "\nNPSN: " . ($school->npsn ?? '20198033') . " • NSS: 102026001002 • Akreditasi: A (Unggul)\nAlamat: " . ($school->address ?? 'Jl. Raya Pendidikan Terpadu No. 8, Bandung') . " • Telp: (022) 7890123",
                    'kop_image_url' => $school->kop_image_url ?? '/images/kop-sekolah.png',
                    'school_logo_url' => $school->logo_url ?? '/images/logo-sekolah.png',
                    'jsit_logo_url' => '/images/logo-jsit.png',
                    'foundation_logo_url' => '/images/logo-yayasan.png',
                    'stamp_image_url' => '/images/stempel-sekolah.png',
                    'principal_signature_url' => '/images/ttd-kepsek.png',
                    'principal_name' => $school->principal_name ?? ($school->code === 'SMPIT' ? 'Ustadz H. Ahmad Fauzi, M.Pd.' : 'Ustadzah Siti Fatimah, S.Pd.I.'),
                    'principal_nip' => '19850315 200904 1 003',
                    'report_date' => '20 Desember 2026',
                    'report_city' => 'Bandung',
                ]
            );
        }

        // Seed Sample Grades for Students
        $students = Student::with('classroom')->take(10)->get();
        $subjects = Subject::all();

        foreach ($students as $idx => $st) {
            // 1. Academic Grades (Kurikulum Merdeka)
            foreach ($subjects->take(5) as $sb) {
                Grade::updateOrCreate(
                    [
                        'student_id' => $st->id,
                        'subject_id' => $sb->id,
                        'academic_year_id' => $academicYearId ?? 1,
                        'assessment_type' => 'SUMATIF_AKHIR_SEMESTER',
                    ],
                    [
                        'competency_code' => 'TP-MERDEKA',
                        'score' => 85 + ($idx % 12),
                        'notes' => 'Menunjukkan penguasaan yang sangat baik dalam memahami materi dan mampu menerapkannya dalam proyek pemecahan masalah secara mandiri.',
                    ]
                );
            }

            // 2. Quran Grades (Metode Wafa & Tahfidz)
            $wafaLevel = ($st->classroom && str_contains(strtolower($st->classroom->name), 'smp')) ? 'Al-Qur\'an Juz 1 (Tahsin Tajwid Lanjutan)' : 'Buku Wafa 3 Hal 25 (Ghorib & Mad)';
            $tahfidzTarget = ($st->classroom && str_contains(strtolower($st->classroom->name), 'smp')) ? 'Juz 29 (Al-Mulk s/d Al-Mursalat)' : 'Juz 30 (An-Naba s/d An-Nas)';
            $tahfidzAch = ($st->classroom && str_contains(strtolower($st->classroom->name), 'smp')) ? 'Tuntas Juz 29 Surat Al-Insan (Mutqin)' : 'Tuntas Juz 30 Surat Al-A\'la s/d An-Nas';

            QuranGrade::updateOrCreate(
                ['student_id' => $st->id],
                [
                    'academic_year_id' => $academicYearId,
                    'tahsin_method' => 'Wafa',
                    'tahsin_level' => $wafaLevel,
                    'tahsin_scores' => [
                        'tilawah' => 90,
                        'makhraj' => 88,
                        'tajwid' => 86,
                        'nada_wafa' => 92,
                        'adab' => 95,
                    ],
                    'tahsin_final_score' => 90.2,
                    'tahsin_predicate' => 'Mumtaz (Istimewa)',
                    'tahsin_notes' => 'Ananda sangat fasih dalam melantunkan ayat dengan irama nada Wafa Hijaz serta makharijul huruf yang tepat.',
                    'tahfidz_target' => $tahfidzTarget,
                    'tahfidz_achievement' => $tahfidzAch,
                    'tahfidz_score' => 92.0,
                    'tahfidz_predicate' => 'Mutqin (Kuat Hafalan)',
                    'tasmi_exam_result' => 'Lulus Ujian Tasmi\' 1 Juz Sekali Duduk Predikat Mumtaz',
                    'tahfidz_notes' => 'Hafalan sangat mutqin dan lancar tanpa keraguan, tajwid terjaga dengan sangat baik.',
                ]
            );

            // 3. Character Grades (7 SKL JSIT)
            CharacterGrade::updateOrCreate(
                ['student_id' => $st->id],
                [
                    'academic_year_id' => $academicYearId,
                    'indicator_scores' => [
                        'SKL_1' => 'SB',
                        'SKL_2' => 'SB',
                        'SKL_3' => 'SB',
                        'SKL_4' => 'B',
                        'SKL_5' => 'SB',
                        'SKL_6' => 'B',
                        'SKL_7' => 'SB',
                    ],
                    'mutabaah_sholat_fardhu' => 'Selalu Berjamaah di Masjid / Musholla',
                    'mutabaah_sholat_dhuha' => 'Rutin 4 Rakaat Setiap Hari',
                    'mutabaah_tilawah' => 'Rutin 1/2 Juz per Hari (One Day Half Juz)',
                    'mutabaah_infaq' => 'Rutin Infaq Jumat & Peduli Dhuafa',
                    'bpi_mentor_notes' => 'Ananda menunjukkan profil karakter Islami yang tangguh, aktif dalam lingkaran mentoring BPI dan menjadi teladan bagi rekan-rekannya.',
                ]
            );

            // 4. Homeroom Notes & Attendance
            HomeroomNote::updateOrCreate(
                ['student_id' => $st->id],
                [
                    'academic_year_id' => $academicYearId,
                    'sick_count' => 1,
                    'permission_count' => 0,
                    'absent_count' => 0,
                    'height_cm' => 142.5 + ($idx * 2),
                    'weight_kg' => 36.0 + ($idx * 1.5),
                    'hearing_health' => 'Sangat Baik / Normal',
                    'vision_health' => 'Sangat Baik / Normal',
                    'dental_health' => 'Bersih & Terawat',
                    'extracurriculars' => [
                        ['name' => 'Pramuka SIT (Penggalang / Siaga)', 'score' => 'A', 'notes' => 'Aktif, disiplin, berjiwa ksatria dan bertanggung jawab.'],
                        ['name' => 'Panahan Sunnah (Archery Club)', 'score' => 'A', 'notes' => 'Fokus tinggi dan menguasai teknik memanah dasar dengan baik.'],
                    ],
                    'notes' => 'Pertahankan prestasi dan akhlak mulia yang telah dicapai. Tetap istiqomah dalam ibadah yaumiyah dan terus asah potensi diri untuk menjadi generasi Rabbani yang unggul.',
                ]
            );
        }
    }
}
