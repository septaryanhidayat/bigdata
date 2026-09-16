-- =============================================================================
-- SMARTEDU & SIT RAPOR EXTENSION - PRODUCTION MYSQL MIGRATION SCRIPT
-- =============================================================================
-- Script ini dapat dijalankan langsung di phpMyAdmin / MySQL CLI jika tidak menggunakan `php artisan migrate`
-- Kompatibel dengan MySQL 5.7, 8.0+, dan MariaDB 10.3+
-- =============================================================================

-- 1. Tambah Kolom Tanda Tangan Digital Wali Kelas pada Tabel Classrooms (Rombel)
ALTER TABLE `classrooms` 
ADD COLUMN IF NOT EXISTS `homeroom_signature_path` VARCHAR(255) NULL AFTER `homeroom_teacher_id`;

-- 2. Tabel Pengaturan Kop Surat, Logo & Stempel Rapor per Unit Sekolah
CREATE TABLE IF NOT EXISTS `report_settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `school_id` BIGINT UNSIGNED NOT NULL,
    `letterhead_image_path` VARCHAR(255) NULL,
    `watermark_image_path` VARCHAR(255) NULL,
    `principal_signature_path` VARCHAR(255) NULL,
    `stamp_image_path` VARCHAR(255) NULL,
    `report_city` VARCHAR(100) NOT NULL DEFAULT 'Bengkulu',
    `report_date` VARCHAR(100) NOT NULL DEFAULT '20 Desember 2026',
    `principal_name` VARCHAR(150) NOT NULL DEFAULT 'Ustadz Dr. H. Sulaiman, M.Pd',
    `principal_nip` VARCHAR(50) NOT NULL DEFAULT '198205152008011003',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_report_settings_school` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Kriteria & Aspek Penilaian Al-Qur'an Wafa & Tahfidz
CREATE TABLE IF NOT EXISTS `quran_criteria` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `school_id` BIGINT UNSIGNED NULL,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `category` VARCHAR(50) NOT NULL DEFAULT 'TAHSIN',
    `description` TEXT NULL,
    `order_number` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_quran_criteria_school` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Indikator 7 Standar Kompetensi Lulusan (SKL) JSIT
CREATE TABLE IF NOT EXISTS `character_indicators` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `school_id` BIGINT UNSIGNED NULL,
    `standard_code` VARCHAR(50) NOT NULL,
    `standard_name` VARCHAR(150) NOT NULL,
    `indicator_name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `order_number` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_character_indicators_school` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel Nilai Al-Qur'an Metode Wafa & Tahfidz Siswa
CREATE TABLE IF NOT EXISTS `quran_grades` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `academic_year_id` BIGINT UNSIGNED NOT NULL,
    `student_id` BIGINT UNSIGNED NOT NULL,
    `tahsin_level` VARCHAR(100) NULL,
    `tahsin_scores` JSON NULL,
    `tahsin_predicate` VARCHAR(50) NULL,
    `tahsin_notes` TEXT NULL,
    `tahfidz_achievement` VARCHAR(255) NULL,
    `tasmi_exam_result` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_quran_grades_student` (`student_id`),
    INDEX `idx_quran_grades_academic` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel Nilai Karakter 7 SKL JSIT & Catatan Pembinaan BPI
CREATE TABLE IF NOT EXISTS `character_grades` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `academic_year_id` BIGINT UNSIGNED NOT NULL,
    `student_id` BIGINT UNSIGNED NOT NULL,
    `indicator_scores` JSON NULL,
    `bpi_mentor_notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_character_grades_student` (`student_id`),
    INDEX `idx_character_grades_academic` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel Catatan Wali Kelas, Kepribadian & Presensi Rapor
CREATE TABLE IF NOT EXISTS `homeroom_notes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `academic_year_id` BIGINT UNSIGNED NOT NULL,
    `student_id` BIGINT UNSIGNED NOT NULL,
    `sakit` INT NOT NULL DEFAULT 0,
    `izin` INT NOT NULL DEFAULT 0,
    `tanpa_keterangan` INT NOT NULL DEFAULT 0,
    `teacher_notes` TEXT NULL,
    `physical_growth` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_homeroom_notes_student` (`student_id`),
    INDEX `idx_homeroom_notes_academic` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabel Data Ekstrakurikuler Unit (Bab IV.F.7 e-Rapor SD)
CREATE TABLE IF NOT EXISTS `extracurriculars` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `school_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `coach_name` VARCHAR(150) NULL,
    `description` TEXT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_extracurriculars_school` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabel Projek Penguatan Profil Pelajar Pancasila / P5 (Bab IV.G & IV.I e-Rapor SD)
CREATE TABLE IF NOT EXISTS `p5_projects` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `school_id` BIGINT UNSIGNED NOT NULL,
    `classroom_id` BIGINT UNSIGNED NULL,
    `academic_year_id` BIGINT UNSIGNED NULL,
    `theme` VARCHAR(150) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `coordinator_name` VARCHAR(150) NULL,
    `target_dimensions` JSON NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_p5_projects_school` (`school_id`),
    INDEX `idx_p5_projects_classroom` (`classroom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- INSERT DATA AWAL (SEEDING) UNTUK KRITERIA WAFA & 7 SKL JSIT
-- =============================================================================

INSERT IGNORE INTO `quran_criteria` (`code`, `name`, `category`, `description`, `order_number`) VALUES
('MAKHRAJ', 'Makharijul Huruf', 'TAHSIN', 'Ketepatan tempat keluarnya huruf hijaiyah sesuai kaidah tajwid', 1),
('TAJWID', 'Kaidah Hukum Tajwid', 'TAHSIN', 'Penerapan hukum nun mati/tanwin, mim mati, mad, dan ghunnah', 2),
('LAGU_HIJAZ', 'Irama & Lagu Hijaz Wafa', 'TAHSIN', 'Kefasihan dan keindahan melantunkan nada khas metode Wafa', 3),
('ADAB', 'Adab & Tartil Tilawah', 'TAHSIN', 'Kerapian tartil, kebersihan, khusyuk dan etika membaca Al-Quran', 4);

INSERT IGNORE INTO `character_indicators` (`standard_code`, `standard_name`, `indicator_name`, `description`, `order_number`) VALUES
('SKL-1', 'Salimul Aqidah', 'Memiliki Akidah yang Lurus', 'Menjaga kemurnian tauhid, menjauhi syirik dan khurafat', 1),
('SKL-2', 'Shahihul Ibadah', 'Melakukan Ibadah yang Benar', 'Tertib shalat fardhu berjamaah, dhuha, rawatib, dan tilawah', 2),
('SKL-3', 'Matinul Khuluq', 'Berkepribadian Matang & Berakhlak Mulia', 'Santun kepada ustadz/ustadzah, menghormati orang tua dan teman', 3),
('SKL-4', 'Qadirun Alal Kasbi', 'Mandiri & Memiliki Keterampilan', 'Mampu mengurus perlengkapan pribadi dan bertanggung jawab', 4),
('SKL-5', 'Mutsaqqoful Fikri', 'Berpengetahuan Luas & Kritis', 'Gemar membaca buku, gemar bertanya, dan bernalar logis', 5),
('SKL-6', 'Qawiyyul Jismi', 'Memiliki Fisik yang Sehat & Kuat', 'Menjaga kebersihan diri, makanan halal-thayyib dan berolahraga', 6),
('SKL-7', 'Nafiun Lighairihi', 'Bermanfaat Bagi Orang Lain', 'Peduli sesama, gemar berinfaq, dan aktif membantu teman', 7);

-- =============================================================================
-- SELESAI
-- =============================================================================
