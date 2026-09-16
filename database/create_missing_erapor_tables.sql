-- =========================================================================
-- SIT ROBBANI SMARTEDU - SKRIP PERBAIKAN TABEL E-RAPOR & SINKRONISASI KODING
-- Database: pesonaas_db_sitrobbani
-- Jalankan skrip ini di phpMyAdmin (Tab SQL) atau via terminal MySQL
-- =========================================================================

-- 1. Tabel Kriteria Penilaian Al-Qur'an (Metode Wafa & Tahfidz)
CREATE TABLE IF NOT EXISTS `quran_criteria` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned DEFAULT NULL,
  `category` enum('tahsin','tahfidz') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tahsin',
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order_number` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quran_criteria_school_id_index` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel Nilai Al-Qur'an (Rapor Tahsin Wafa & Tahfidz)
CREATE TABLE IF NOT EXISTS `quran_grades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `academic_year_id` bigint unsigned DEFAULT NULL,
  `tahsin_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Wafa',
  `tahsin_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahsin_scores` json DEFAULT NULL,
  `tahsin_final_score` decimal(5,2) DEFAULT NULL,
  `tahsin_predicate` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahsin_notes` text COLLATE utf8mb4_unicode_ci,
  `tahfidz_target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahfidz_achievement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahfidz_score` decimal(5,2) DEFAULT NULL,
  `tahfidz_predicate` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tasmi_exam_result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahfidz_notes` text COLLATE utf8mb4_unicode_ci,
  `examiner_teacher_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quran_grades_student_id_index` (`student_id`),
  KEY `quran_grades_academic_year_id_index` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel Indikator Standar Mutu Karakter (7 SKL JSIT)
CREATE TABLE IF NOT EXISTS `character_indicators` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned DEFAULT NULL,
  `standard_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `standard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indicator_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `character_indicators_school_id_index` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel Nilai Karakter & Pembinaan Pribadi Islami (BPI)
CREATE TABLE IF NOT EXISTS `character_grades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `academic_year_id` bigint unsigned DEFAULT NULL,
  `indicator_scores` json DEFAULT NULL,
  `mutabaah_sholat_fardhu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Selalu Berjamaah',
  `mutabaah_sholat_dhuha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Rutin Setiap Hari',
  `mutabaah_tilawah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Rutin 1/2 Juz per Hari',
  `mutabaah_infaq` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Rutin Infaq Jumat',
  `bpi_mentor_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `character_grades_student_id_index` (`student_id`),
  KEY `character_grades_academic_year_id_index` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel Catatan Wali Kelas, Presensi, Fisik & Ekskul Siswa
CREATE TABLE IF NOT EXISTS `homeroom_notes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `academic_year_id` bigint unsigned DEFAULT NULL,
  `sick_count` int NOT NULL DEFAULT '0',
  `permission_count` int NOT NULL DEFAULT '0',
  `absent_count` int NOT NULL DEFAULT '0',
  `height_cm` decimal(5,1) DEFAULT NULL,
  `weight_kg` decimal(5,1) DEFAULT NULL,
  `hearing_health` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Baik',
  `vision_health` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Baik',
  `dental_health` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Baik',
  `extracurriculars` json DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `homeroom_notes_student_id_index` (`student_id`),
  KEY `homeroom_notes_academic_year_id_index` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel Pengaturan Cetak Rapor (Kop, Tanda Tangan, Logo)
CREATE TABLE IF NOT EXISTS `report_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `kop_header_text` text COLLATE utf8mb4_unicode_ci,
  `kop_image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jsit_logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foundation_logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stamp_image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_signature_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Bandung',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_settings_school_id_index` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel Master Ekstrakurikuler
CREATE TABLE IF NOT EXISTS `extracurriculars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coach_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `extracurriculars_school_id_index` (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabel Projek Penguatan Profil Pelajar Pancasila (P5)
CREATE TABLE IF NOT EXISTS `p5_projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `classroom_id` bigint unsigned DEFAULT NULL,
  `academic_year_id` bigint unsigned DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `coordinator_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_dimensions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p5_projects_school_id_index` (`school_id`),
  KEY `p5_projects_classroom_id_index` (`classroom_id`),
  KEY `p5_projects_academic_year_id_index` (`academic_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tambahkan Kolom Tanda Tangan Wali Kelas ke Tabel classrooms (jika belum ada)
SET @dbname = DATABASE();
SET @tablename = "classrooms";
SET @columnname = "homeroom_signature_path";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 1",
  "ALTER TABLE classrooms ADD COLUMN homeroom_signature_path VARCHAR(255) NULL AFTER homeroom_teacher_id;"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 10. Seed Data Awal 7 Standar Karakter JSIT
INSERT IGNORE INTO `character_indicators` (`standard_code`, `standard_name`, `indicator_name`, `order_number`, `created_at`, `updated_at`) VALUES
('SKL-01', 'Akidah yang Lurus (Salimul Aqidah)', 'Mengenal Allah melalui ciptaan-Nya, tidak melakukan syirik, dan ikhlas beribadah.', 1, NOW(), NOW()),
('SKL-02', 'Ibadah yang Benar (Shahihul Ibadah)', 'Melaksanakan sholat fardhu berjamaah dengan tertib, terbiasa dhuha dan rawatib.', 2, NOW(), NOW()),
('SKL-03', 'Kepribadian Matang & Berakhlak Mulia (Matinul Khuluq)', 'Santun kepada guru, orang tua, dan teman, bersikap jujur dan amanah.', 3, NOW(), NOW()),
('SKL-04', 'Pribadi yang Mandiri (Qadirun alal Kasbi)', 'Mandiri dalam mengurus perlengkapan sekolah dan tugas-tugas harian.', 4, NOW(), NOW()),
('SKL-05', 'Cerdas & Berpengetahuan Luas (Mutsaqqoful Fikri)', 'Memiliki rasa ingin tahu tinggi, gemar membaca dan berpikir kritis.', 5, NOW(), NOW()),
('SKL-06', 'Sehat & Kuat (Qawiyyul Jismi)', 'Menjaga kebersihan fisik, lingkungan, makan makanan halal & bergizi, gemar berolahraga.', 6, NOW(), NOW()),
('SKL-07', 'Disiplin & Bermanfaat bagi Sesama (Nafiun Lighairihi)', 'Disiplin waktu, tertib aturan, peduli lingkungan dan suka membantu orang lain.', 7, NOW(), NOW());

-- 11. SINKRONISASI ISTILAH ROBOTIK MENJADI KODING DI SELURUH TABEL
UPDATE `homeroom_notes` SET `extracurriculars` = REPLACE(REPLACE(REPLACE(REPLACE(`extracurriculars`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') WHERE `extracurriculars` LIKE '%obotik%';
UPDATE `extracurriculars` SET `name` = REPLACE(REPLACE(REPLACE(REPLACE(`name`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') WHERE `name` LIKE '%obotik%';
UPDATE `subjects` SET `name` = REPLACE(REPLACE(REPLACE(REPLACE(`name`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') WHERE `name` LIKE '%obotik%';
