-- ================================================================
-- SQL IMPORT DATA REAL ERAPOR SMP IT ROBBANI (9 SISWA, 13 MAPEL, TTQ, BPI)
-- Dibuat untuk cPanel phpMyAdmin / MySQL Terminal SIT Robbani
-- Aman: Menggunakan INSERT ... ON DUPLICATE KEY UPDATE (Tanpa Menghapus Data Lama)
-- ================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Update/Insert School SMP IT Robbani
INSERT INTO `schools` (`id`, `code`, `name`, `npsn`, `principal_name`, `address`, `phone`, `email`, `created_at`, `updated_at`) 
VALUES (2, 'SMPIT', 'SMP Islam Terpadu Robbani', '20198033', 'Tia Wulandari, S.Pd.,Gr.', 'Jl. Sarjana Gg. Padang Guci Kel. Timbangan', '+62 853-7719-3977', 'smpit@sitrobbani.sch.id', NOW(), NOW())
ON DUPLICATE KEY UPDATE `code`='SMPIT', `name`='SMP Islam Terpadu Robbani', `npsn`='20198033', `principal_name`='Tia Wulandari, S.Pd.,Gr.', `address`='Jl. Sarjana Gg. Padang Guci Kel. Timbangan', `phone`='+62 853-7719-3977', `email`='smpit@sitrobbani.sch.id';

-- 2. Academic Year 2025/2026 Genap
INSERT INTO `academic_years` (`id`, `name`, `semester`, `curriculum_code`, `is_active`, `created_at`, `updated_at`) 
VALUES (2, '2025/2026', 'Genap', 'MERDEKA', 1, NOW(), NOW()) 
ON DUPLICATE KEY UPDATE `curriculum_code`='MERDEKA', `is_active`=1;

-- 3. Level Kelas 9 SMP
INSERT INTO `levels` (`id`, `school_id`, `code`, `name`, `sort_order`, `created_at`, `updated_at`)
VALUES (2, 2, 'IX', 'Kelas 9 SMP', 9, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Kelas 9 SMP', `code`='IX', `sort_order`=9;

-- 4. Pendidik & Tenaga Kependidikan Real SMP IT Robbani
INSERT INTO `employees` (`id`, `school_id`, `nip`, `full_name`, `gender`, `role_type`, `employment_status`, `religion`, `is_active`, `created_at`, `updated_at`)
VALUES (10, 2, '142062021012', 'Tia Wulandari, S.Pd.,Gr.', 'F', 'PRINCIPAL', 'PERMANENT', 'ISLAM', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Tia Wulandari, S.Pd.,Gr.', `nip`='142062021012', `role_type`='PRINCIPAL';
INSERT INTO `employees` (`id`, `school_id`, `nip`, `full_name`, `gender`, `role_type`, `employment_status`, `religion`, `is_active`, `created_at`, `updated_at`)
VALUES (11, 2, '-', 'Sulis Setiya Ningsih, S.Pd.Gr.', 'F', 'TEACHER', 'PERMANENT', 'ISLAM', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Sulis Setiya Ningsih, S.Pd.Gr.', `role_type`='TEACHER';
INSERT INTO `employees` (`id`, `school_id`, `nip`, `full_name`, `gender`, `role_type`, `employment_status`, `religion`, `is_active`, `created_at`, `updated_at`)
VALUES (12, 2, '-', 'Nurul Hamidah Yanti, S.E', 'F', 'TEACHER', 'PERMANENT', 'ISLAM', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Nurul Hamidah Yanti, S.E', `role_type`='TEACHER';
INSERT INTO `employees` (`id`, `school_id`, `nip`, `full_name`, `gender`, `role_type`, `employment_status`, `religion`, `is_active`, `created_at`, `updated_at`)
VALUES (13, 2, '-', 'Syaifudin, S.Sn., Gr.', 'M', 'TEACHER', 'PERMANENT', 'ISLAM', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Syaifudin, S.Sn., Gr.', `role_type`='TEACHER';

-- 5. Classroom Kelas IX
INSERT INTO `classrooms` (`id`, `school_id`, `name`, `level_id`, `academic_year_id`, `homeroom_teacher_id`, `room_number`, `capacity`, `created_at`, `updated_at`)
VALUES (2, 2, 'Kelas IX', 2, 2, 11, 'SMP-301', 25, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Kelas IX', `homeroom_teacher_id`=11, `academic_year_id`=2;

-- 6. 13 Mata Pelajaran Resmi SMP IT Robbani Sesuai PDF 1
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (20, 2, 'PAI', 'Pendidikan Agama Islam', 'PENDIDIKAN AGAMA', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Pendidikan Agama Islam', `category`='PENDIDIKAN AGAMA', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (21, 2, 'PPKN', 'Pendidikan Pancasila', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Pendidikan Pancasila', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (22, 2, 'BIND', 'Bahasa Indonesia', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Bahasa Indonesia', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (23, 2, 'MTK', 'Matematika', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Matematika', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (24, 2, 'IPA', 'Ilmu Pengetahuan Alam', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Ilmu Pengetahuan Alam', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (25, 2, 'IPS', 'Ilmu Pengetahuan Sosial', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Ilmu Pengetahuan Sosial', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (26, 2, 'BING', 'Bahasa Inggris', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Bahasa Inggris', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (27, 2, 'PJOK', 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Pendidikan Jasmani, Olahraga, dan Kesehatan', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (28, 2, 'SBK', 'Seni Budaya dan Keterampilan', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Seni Budaya dan Keterampilan', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (29, 2, 'INF', 'Informatika', 'NASIONAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Informatika', `category`='NASIONAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (30, 2, 'TEATER', 'Seni Teater', 'MUATAN LOKAL', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Seni Teater', `category`='MUATAN LOKAL', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (31, 2, 'HADIST', 'Hadist', 'KEKHASAN ISLAMI', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Hadist', `category`='KEKHASAN ISLAMI', `passing_grade`=75;
INSERT INTO `subjects` (`id`, `school_id`, `code`, `name`, `category`, `passing_grade`, `created_at`, `updated_at`)
VALUES (32, 2, 'ARAB', 'Bahasa Arab', 'KEKHASAN ISLAMI', 75, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Bahasa Arab', `category`='KEKHASAN ISLAMI', `passing_grade`=75;

-- 7. Ekstrakurikuler SMP
INSERT INTO `extracurriculars` (`id`, `school_id`, `name`, `coach_name`, `description`, `is_active`, `created_at`, `updated_at`)
VALUES (10, 2, 'Pramuka SIT Robbani', 'Ustadz Danang', 'Kepanduan dan life skills karakter islami', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Pramuka SIT Robbani', `coach_name`='Ustadz Danang';
INSERT INTO `extracurriculars` (`id`, `school_id`, `name`, `coach_name`, `description`, `is_active`, `created_at`, `updated_at`)
VALUES (11, 2, 'Seni Teater & Sastra', 'Ustadz Syaifudin, S.Sn.', 'Olah peran teater islami dan literasi panggung', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Seni Teater & Sastra', `coach_name`='Ustadz Syaifudin, S.Sn.';
INSERT INTO `extracurriculars` (`id`, `school_id`, `name`, `coach_name`, `description`, `is_active`, `created_at`, `updated_at`)
VALUES (12, 2, 'Futsal & Bela Diri', 'Ustadz Heru', 'Ketangkasan fisik, sportivitas dan kesehatan raga', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Futsal & Bela Diri', `coach_name`='Ustadz Heru';
INSERT INTO `extracurriculars` (`id`, `school_id`, `name`, `coach_name`, `description`, `is_active`, `created_at`, `updated_at`)
VALUES (13, 2, 'Klub Tahfidz Intensif', 'Ustadzah Nurul Hamidah, S.E', 'Pemantapan hafalan Al-Baqarah dan tahsin tajwid', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE `name`='Klub Tahfidz Intensif', `coach_name`='Ustadzah Nurul Hamidah, S.E';

-- 8. 9 Siswa Real SMP Kelas IX & Biodata Lengkap
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (30, 2, 2, '2370031580001', '0112345601', 'Ahmad Rafif Nakhla', 'M', 'ACTIVE', 'Palembang', '2011-04-15', 'Hendra Wijaya', 'Ratna Dewi', 'PNS', 'Guru', 'Jl. Sarjana Gg. Padang Guci No. 12', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Hendra Wijaya", "mother_name": "Ratna Dewi", "father_job": "PNS", "mother_job": "Guru", "address": "Jl. Sarjana Gg. Padang Guci No. 12", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Ahmad Rafif Nakhla', `classroom_id`=2, `nisn`='0112345601', `father_name`='Hendra Wijaya', `mother_name`='Ratna Dewi', `address`='Jl. Sarjana Gg. Padang Guci No. 12';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (31, 2, 2, '2370031580002', '0112345602', 'Arvin Danial Azhar', 'M', 'ACTIVE', 'Indralaya', '2011-06-20', 'Azharudin', 'Siti Fatimah', 'Wiraswasta', 'IRT', 'Jl. Lintas Timur Km. 35 Kel. Timbangan', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Azharudin", "mother_name": "Siti Fatimah", "father_job": "Wiraswasta", "mother_job": "IRT", "address": "Jl. Lintas Timur Km. 35 Kel. Timbangan", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Arvin Danial Azhar', `classroom_id`=2, `nisn`='0112345602', `father_name`='Azharudin', `mother_name`='Siti Fatimah', `address`='Jl. Lintas Timur Km. 35 Kel. Timbangan';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (32, 2, 2, '2370031580003', '0112345603', 'Farah Bintang Aulia', 'F', 'ACTIVE', 'Ogan Ilir', '2011-08-11', 'Bambang Irawan', 'Lina Marlina', 'Pegawai BUMN', 'PNS', 'Jl. Raya Palembang-Prabumulih Indralaya', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Bambang Irawan", "mother_name": "Lina Marlina", "father_job": "Pegawai BUMN", "mother_job": "PNS", "address": "Jl. Raya Palembang-Prabumulih Indralaya", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Farah Bintang Aulia', `classroom_id`=2, `nisn`='0112345603', `father_name`='Bambang Irawan', `mother_name`='Lina Marlina', `address`='Jl. Raya Palembang-Prabumulih Indralaya';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (33, 2, 2, '2370031580004', '0112345604', 'Filza Syakila Khansa', 'F', 'ACTIVE', 'Palembang', '2011-02-18', 'Muhammad Ridwan', 'Nurhayati', 'Wiraswasta', 'IRT', 'Perumahan Griya Indralaya Indah Blok B4', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Muhammad Ridwan", "mother_name": "Nurhayati", "father_job": "Wiraswasta", "mother_job": "IRT", "address": "Perumahan Griya Indralaya Indah Blok B4", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Filza Syakila Khansa', `classroom_id`=2, `nisn`='0112345604', `father_name`='Muhammad Ridwan', `mother_name`='Nurhayati', `address`='Perumahan Griya Indralaya Indah Blok B4';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (34, 2, 2, '2370031580005', '0112345605', 'Khayla Ahza Nazura', 'F', 'ACTIVE', 'Indralaya', '2011-09-09', 'Nazirwan', 'Yuliana', 'Dosen', 'Guru', 'Jl. Sarjana Komplek Unsri No. 18', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Nazirwan", "mother_name": "Yuliana", "father_job": "Dosen", "mother_job": "Guru", "address": "Jl. Sarjana Komplek Unsri No. 18", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Khayla Ahza Nazura', `classroom_id`=2, `nisn`='0112345605', `father_name`='Nazirwan', `mother_name`='Yuliana', `address`='Jl. Sarjana Komplek Unsri No. 18';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (35, 2, 2, '2370031580006', '0112345606', 'Lionel Andhika Kobela', 'M', 'ACTIVE', 'Palembang', '2011-01-25', 'Kobela Pratama', 'Anita Sari', 'Pegawai Swasta', 'IRT', 'Jl. Pesantren Gg. Melati No. 5', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Kobela Pratama", "mother_name": "Anita Sari", "father_job": "Pegawai Swasta", "mother_job": "IRT", "address": "Jl. Pesantren Gg. Melati No. 5", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Lionel Andhika Kobela', `classroom_id`=2, `nisn`='0112345606', `father_name`='Kobela Pratama', `mother_name`='Anita Sari', `address`='Jl. Pesantren Gg. Melati No. 5';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (36, 2, 2, '2370031580007', '0112345607', 'Muhammad Adam Johrdi', 'M', 'ACTIVE', 'Indralaya', '2011-07-04', 'Johrdi', 'Maryani', 'Wiraswasta', 'Pedagang', 'Pasar Indralaya Kab. Ogan Ilir', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Johrdi", "mother_name": "Maryani", "father_job": "Wiraswasta", "mother_job": "Pedagang", "address": "Pasar Indralaya Kab. Ogan Ilir", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Muhammad Adam Johrdi', `classroom_id`=2, `nisn`='0112345607', `father_name`='Johrdi', `mother_name`='Maryani', `address`='Pasar Indralaya Kab. Ogan Ilir';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (37, 2, 2, '2370031580008', '0112345608', 'Nurqisya Darmayanti', 'F', 'ACTIVE', 'Tanjung Senai', '2011-10-30', 'Darlan', 'Maryati', 'PNS', 'PNS', 'Komplek Pemda Ogan Ilir Blok D2 Tanjung Senai', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Darlan", "mother_name": "Maryati", "father_job": "PNS", "mother_job": "PNS", "address": "Komplek Pemda Ogan Ilir Blok D2 Tanjung Senai", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Nurqisya Darmayanti', `classroom_id`=2, `nisn`='0112345608', `father_name`='Darlan', `mother_name`='Maryati', `address`='Komplek Pemda Ogan Ilir Blok D2 Tanjung Senai';
INSERT INTO `students` (`id`, `school_id`, `classroom_id`, `nis`, `nisn`, `full_name`, `gender`, `status`, `pob`, `dob`, `father_name`, `mother_name`, `father_job`, `mother_job`, `address`, `village`, `district`, `city`, `province`, `bio_data`, `created_at`, `updated_at`)
VALUES (38, 2, 2, '2370031580008', '0119742046', 'Nyimas Raida Alya', 'F', 'ACTIVE', 'Palembang', '2011-05-12', 'Raden M. Fauzi', 'Nyimas Halimah', 'Pegawai BUMN', 'Guru', 'Jl. Sarjana Gg. Padang Guci No. 8 Kel. Timbangan', 'Timbangan', 'Indralaya Utara', 'Ogan Ilir', 'Sumatera Selatan', '{"father_name": "Raden M. Fauzi", "mother_name": "Nyimas Halimah", "father_job": "Pegawai BUMN", "mother_job": "Guru", "address": "Jl. Sarjana Gg. Padang Guci No. 8 Kel. Timbangan", "village": "Timbangan", "district": "Indralaya Utara", "city": "Ogan Ilir", "province": "Sumatera Selatan", "quran_group": "Jannatu Al-Firdaus"}', NOW(), NOW())
ON DUPLICATE KEY UPDATE `full_name`='Nyimas Raida Alya', `classroom_id`=2, `nisn`='0119742046', `father_name`='Raden M. Fauzi', `mother_name`='Nyimas Halimah', `address`='Jl. Sarjana Gg. Padang Guci No. 8 Kel. Timbangan';

-- 9. Nilai Akademik 13 Mapel (Rekap PDF 1)
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (201, 30, 20, 2, 'FINAL', 'CP-SEM2', 80, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=80, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (202, 30, 21, 2, 'FINAL', 'CP-SEM2', 87, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=87, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (203, 30, 22, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (204, 30, 23, 2, 'FINAL', 'CP-SEM2', 88, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=88, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (205, 30, 24, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (206, 30, 25, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (207, 30, 26, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (208, 30, 27, 2, 'FINAL', 'CP-SEM2', 84, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=84, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (209, 30, 28, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (210, 30, 29, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (211, 30, 30, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (212, 30, 31, 2, 'FINAL', 'CP-SEM2', 67, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=67, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (213, 30, 32, 2, 'FINAL', 'CP-SEM2', 81, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=81, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (214, 31, 20, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (215, 31, 21, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (216, 31, 22, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (217, 31, 23, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (218, 31, 24, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (219, 31, 25, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (220, 31, 26, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (221, 31, 27, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (222, 31, 28, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (223, 31, 29, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (224, 31, 30, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (225, 31, 31, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (226, 31, 32, 2, 'FINAL', 'CP-SEM2', 87, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=87, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (227, 32, 20, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (228, 32, 21, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (229, 32, 22, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (230, 32, 23, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (231, 32, 24, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (232, 32, 25, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (233, 32, 26, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (234, 32, 27, 2, 'FINAL', 'CP-SEM2', 86, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=86, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (235, 32, 28, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (236, 32, 29, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (237, 32, 30, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (238, 32, 31, 2, 'FINAL', 'CP-SEM2', 91, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=91, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (239, 32, 32, 2, 'FINAL', 'CP-SEM2', 86, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=86, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (240, 33, 20, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (241, 33, 21, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (242, 33, 22, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (243, 33, 23, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (244, 33, 24, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (245, 33, 25, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (246, 33, 26, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (247, 33, 27, 2, 'FINAL', 'CP-SEM2', 83, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=83, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan. Namun Perlu bimbingan dan pendalaman pada aspek latihan mandiri Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (248, 33, 28, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (249, 33, 29, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (250, 33, 30, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (251, 33, 31, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (252, 33, 32, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (253, 34, 20, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (254, 34, 21, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (255, 34, 22, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (256, 34, 23, 2, 'FINAL', 'CP-SEM2', 87, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=87, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (257, 34, 24, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (258, 34, 25, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (259, 34, 26, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (260, 34, 27, 2, 'FINAL', 'CP-SEM2', 87, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=87, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (261, 34, 28, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (262, 34, 29, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (263, 34, 30, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (264, 34, 31, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (265, 34, 32, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (266, 35, 20, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (267, 35, 21, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (268, 35, 22, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (269, 35, 23, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (270, 35, 24, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (271, 35, 25, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (272, 35, 26, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (273, 35, 27, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (274, 35, 28, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (275, 35, 29, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (276, 35, 30, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (277, 35, 31, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (278, 35, 32, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (279, 36, 20, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (280, 36, 21, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (281, 36, 22, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (282, 36, 23, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (283, 36, 24, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (284, 36, 25, 2, 'FINAL', 'CP-SEM2', 94, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=94, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (285, 36, 26, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (286, 36, 27, 2, 'FINAL', 'CP-SEM2', 89, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=89, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (287, 36, 28, 2, 'FINAL', 'CP-SEM2', 91, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=91, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (288, 36, 29, 2, 'FINAL', 'CP-SEM2', 91, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=91, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (289, 36, 30, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (290, 36, 31, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (291, 36, 32, 2, 'FINAL', 'CP-SEM2', 95, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=95, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (292, 37, 20, 2, 'FINAL', 'CP-SEM2', 87, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=87, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (293, 37, 21, 2, 'FINAL', 'CP-SEM2', 87, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=87, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (294, 37, 22, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (295, 37, 23, 2, 'FINAL', 'CP-SEM2', 85, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=85, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (296, 37, 24, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (297, 37, 25, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (298, 37, 26, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (299, 37, 27, 2, 'FINAL', 'CP-SEM2', 85, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=85, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (300, 37, 28, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (301, 37, 29, 2, 'FINAL', 'CP-SEM2', 85, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=85, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (302, 37, 30, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (303, 37, 31, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (304, 37, 32, 2, 'FINAL', 'CP-SEM2', 86, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=86, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (305, 38, 20, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Agama Islam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (306, 38, 21, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Pancasila';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (307, 38, 22, 2, 'FINAL', 'CP-SEM2', 97, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=97, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Indonesia';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (308, 38, 23, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Matematika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Matematika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (309, 38, 24, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Alam';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (310, 38, 25, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Ilmu Pengetahuan Sosial';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (311, 38, 26, 2, 'FINAL', 'CP-SEM2', 96, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=96, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Inggris';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (312, 38, 27, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Pendidikan Jasmani, Olahraga, dan Kesehatan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (313, 38, 28, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Budaya dan Keterampilan';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (314, 38, 29, 2, 'FINAL', 'CP-SEM2', 90, 'Sangat menguasai seluruh capaian dan materi pembelajaran Informatika', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=90, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Informatika';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (315, 38, 30, 2, 'FINAL', 'CP-SEM2', 93, 'Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=93, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Seni Teater';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (316, 38, 31, 2, 'FINAL', 'CP-SEM2', 98, 'Sangat menguasai seluruh capaian dan materi pembelajaran Hadist', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=98, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Hadist';
INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `academic_year_id`, `assessment_type`, `competency_code`, `score`, `notes`, `created_at`, `updated_at`)
VALUES (317, 38, 32, 2, 'FINAL', 'CP-SEM2', 92, 'Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab', NOW(), NOW())
ON DUPLICATE KEY UPDATE `score`=92, `notes`='Sangat menguasai seluruh capaian dan materi pembelajaran Bahasa Arab';

-- 10. Nilai TTQ (Tahsin & Tahfidz SMP Sesuai PDF 2)
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (30, 30, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 82, "tajwid": 84, "kelancaran": 85, "adab": 95}', 84.0, 'B', 'Alhamdulillah, ananda Ahmad Rafif Nakhla sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'B', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 82.0, 'B', 'Lulus Ujian Tasmi Al-Baqarah Predikat B', 'Alhamdulillah, ananda Rafif sudah menuntaskan hafalan surat Al-Baqarah ayat 1 - 50 dengan baik.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='B', `tahsin_predicate`='B', `tahfidz_notes`='Alhamdulillah, ananda Rafif sudah menuntaskan hafalan surat Al-Baqarah ayat 1 - 50 dengan baik.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (31, 31, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Arvin Danial Azhar sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Alhamdulillah, ananda Arvin sudah menuntaskan hafalan surat Al-Baqarah ayat 1 - 50 dengan sangat baik dan tartil.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='Alhamdulillah, ananda Arvin sudah menuntaskan hafalan surat Al-Baqarah ayat 1 - 50 dengan sangat baik dan tartil.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (32, 32, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Farah Bintang Aulia sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Alhamdulillah, ananda Farah menunjukkan perkembangan hafalan yang sangat membanggakan.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='Alhamdulillah, ananda Farah menunjukkan perkembangan hafalan yang sangat membanggakan.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (33, 33, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Filza Syakila Khansa sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'MasyaAllah, ananda Filza hafalannya sangat mutqin dan bacaan tajwidnya sangat tertib.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='MasyaAllah, ananda Filza hafalannya sangat mutqin dan bacaan tajwidnya sangat tertib.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (34, 34, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Khayla Ahza Nazura sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Alhamdulillah, ananda Khayla sangat tekun dan memiliki adab yang baik dalam belajar Al-Qur''an.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='Alhamdulillah, ananda Khayla sangat tekun dan memiliki adab yang baik dalam belajar Al-Qur''an.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (35, 35, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Lionel Andhika Kobela sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Baarakallah ananda Lionel, capaian hafalan dan ketertiban tajwid sangat istimewa.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='Baarakallah ananda Lionel, capaian hafalan dan ketertiban tajwid sangat istimewa.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (36, 36, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Muhammad Adam Johrdi sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Alhamdulillah, ananda Adam memiliki hafalan yang kuat dan selalu semangat muraja''ah.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='Alhamdulillah, ananda Adam memiliki hafalan yang kuat dan selalu semangat muraja''ah.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (37, 37, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 82, "tajwid": 84, "kelancaran": 94, "adab": 95}', 84.0, 'B', 'Alhamdulillah, ananda Nurqisya Darmayanti sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Alhamdulillah, ananda Nurqisya terus bersemangat meningkatkan kualitas tilawah dan tahsin.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='B', `tahfidz_notes`='Alhamdulillah, ananda Nurqisya terus bersemangat meningkatkan kualitas tilawah dan tahsin.';
INSERT INTO `quran_grades` (`id`, `student_id`, `academic_year_id`, `tahsin_method`, `tahsin_level`, `quran_group`, `tahsin_scores`, `tahsin_final_score`, `tahsin_predicate`, `tahsin_notes`, `tilawah_predicate`, `tahfidz_target`, `tahfidz_achievement`, `tahfidz_score`, `tahfidz_predicate`, `tasmi_exam_result`, `tahfidz_notes`, `examiner_teacher_id`, `created_at`, `updated_at`)
VALUES (38, 38, 2, 'Metode TTQ Robbani', 'Juz 1 – Juz 30', 'Jannatu Al-Firdaus', '{"makhraj": 92, "tajwid": 95, "kelancaran": 94, "adab": 95}', 94.0, 'A', 'Alhamdulillah, ananda Nyimas Raida Alya sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, konsisten melantunkan bacaan tartil.', 'A', 'Hafalan Surah Al-Baqarah 1 – 50 ayat', 'Tuntas Hafalan Surah Al-Baqarah 1 – 50 ayat', 95.0, 'A', 'Lulus Ujian Tasmi Al-Baqarah Predikat A', 'Alhamdulillah, ananda Alya sudah menuntaskan hafalan surat Al-Baqarah ayat 1 - 50 dengan sangat baik.', 12, NOW(), NOW())
ON DUPLICATE KEY UPDATE `tahfidz_predicate`='A', `tahsin_predicate`='A', `tahfidz_notes`='Alhamdulillah, ananda Alya sudah menuntaskan hafalan surat Al-Baqarah ayat 1 - 50 dengan sangat baik.';

-- 11. Nilai BPI (Bina Pribadi Islam SMP Sesuai PDF 3)
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (30, 30, 2, '{"akidah": "B", "ibadah": "C", "salimul_aqidah": "B", "shahihul_ibadah": "C", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Rafif sudah baik dalam memahami materi akidah yang lurus dan cukup baik dalam memahami materi cara melakukan ibadah yang benar.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "B", "ibadah": "C", "salimul_aqidah": "B", "shahihul_ibadah": "C", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Rafif sudah baik dalam memahami materi akidah yang lurus dan cukup baik dalam memahami materi cara melakukan ibadah yang benar.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (31, 31, 2, '{"akidah": "A", "ibadah": "B", "salimul_aqidah": "A", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Arvin sangat baik dalam materi akidah dan tertib dalam ibadah harian.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "B", "salimul_aqidah": "A", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Arvin sangat baik dalam materi akidah dan tertib dalam ibadah harian.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (32, 32, 2, '{"akidah": "A", "ibadah": "B", "salimul_aqidah": "A", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Farah berakhlak mulia dan santun kepada sesama serta rajin beribadah.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "B", "salimul_aqidah": "A", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Farah berakhlak mulia dan santun kepada sesama serta rajin beribadah.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (33, 33, 2, '{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Filza memiliki pemahaman akidah yang lurus dan istiqomah dalam ibadah harian.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Filza memiliki pemahaman akidah yang lurus dan istiqomah dalam ibadah harian.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (34, 34, 2, '{"akidah": "A", "ibadah": "B", "salimul_aqidah": "A", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Khayla aktif dalam halaqah BPI dan berakhlak terpuji.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "B", "salimul_aqidah": "A", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Khayla aktif dalam halaqah BPI dan berakhlak terpuji.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (35, 35, 2, '{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Lionel menunjukkan teladan yang baik dalam kedisiplinan dan ibadah berjamaah.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Lionel menunjukkan teladan yang baik dalam kedisiplinan dan ibadah berjamaah.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (36, 36, 2, '{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Adam istiqomah dalam pembiasaan ibadah shalat fardhu tepat waktu.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Adam istiqomah dalam pembiasaan ibadah shalat fardhu tepat waktu.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (37, 37, 2, '{"akidah": "B", "ibadah": "B", "salimul_aqidah": "B", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Nurqisya rajin menyimak materi pembinaan BPI dan santun dalam pergaulan.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "B", "ibadah": "B", "salimul_aqidah": "B", "shahihul_ibadah": "B", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Nurqisya rajin menyimak materi pembinaan BPI dan santun dalam pergaulan.';
INSERT INTO `character_grades` (`id`, `student_id`, `academic_year_id`, `indicator_scores`, `mutabaah_sholat_fardhu`, `mutabaah_sholat_dhuha`, `mutabaah_tilawah`, `mutabaah_infaq`, `bpi_mentor_notes`, `created_at`, `updated_at`)
VALUES (38, 38, 2, '{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', 'Selalu Berjamaah di Masjid', 'Rutin Berjamaah', '1 Juz per Hari', 'Setiap Hari Jumat', 'Alhamdulillah, ananda Alya sudah baik dalam memahami materi akidah yang lurus dan istiqomah dalam ibadah harian.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `indicator_scores`='{"akidah": "A", "ibadah": "A", "salimul_aqidah": "A", "shahihul_ibadah": "A", "bpi_attendance": {"sakit": "-", "izin": "-", "alpa": "-", "total": 3}}', `bpi_mentor_notes`='Alhamdulillah, ananda Alya sudah baik dalam memahami materi akidah yang lurus dan istiqomah dalam ibadah harian.';

-- 12. Catatan & Presensi Wali Kelas
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (30, 30, 2, 0, 0, 0, 155.0, 51.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Ahmad Rafif Nakhla menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Ahmad Rafif Nakhla menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (31, 31, 2, 0, 0, 0, 156.0, 52.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Arvin Danial Azhar menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Arvin Danial Azhar menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (32, 32, 2, 0, 0, 0, 157.0, 53.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Farah Bintang Aulia menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Farah Bintang Aulia menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (33, 33, 2, 0, 0, 0, 158.0, 54.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Filza Syakila Khansa menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Filza Syakila Khansa menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (34, 34, 2, 0, 0, 0, 159.0, 55.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Khayla Ahza Nazura menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Khayla Ahza Nazura menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (35, 35, 2, 0, 0, 0, 160.0, 56.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Lionel Andhika Kobela menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Lionel Andhika Kobela menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (36, 36, 2, 0, 0, 0, 161.0, 45.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Muhammad Adam Johrdi menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Muhammad Adam Johrdi menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (37, 37, 2, 0, 0, 0, 162.0, 46.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Nurqisya Darmayanti menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Nurqisya Darmayanti menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';
INSERT INTO `homeroom_notes` (`id`, `student_id`, `academic_year_id`, `sick_count`, `permission_count`, `absent_count`, `height_cm`, `weight_kg`, `hearing_health`, `vision_health`, `dental_health`, `extracurriculars`, `notes`, `created_at`, `updated_at`)
VALUES (38, 38, 2, 0, 0, 0, 163.0, 47.0, 'Normal / Baik', 'Normal / Baik', 'Bersih & Sehat', '[{"name": "Pramuka SIT Robbani", "predicate": "Sangat Baik", "description": "Aktif dan disiplin dalam kepanduan SIT"}, {"name": "Seni Teater & Sastra", "predicate": "Baik", "description": "Berperan aktif dalam pertunjukan teater islami"}]', 'Alhamdulillah ananda Nyimas Raida Alya menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `notes`='Alhamdulillah ananda Nyimas Raida Alya menunjukkan prestasi akademik yang sangat memuaskan, akhlak terpuji, dan kedisiplinan yang tinggi. Pertahankan prestasi dan terus kembangkan potensi diri.';

-- 13. Report Setting Resmi SMP IT Robbani
INSERT INTO `report_settings` (`id`, `school_id`, `principal_name`, `principal_nip`, `report_city`, `report_date`, `school_logo_url`, `kop_image_url`, `stamp_image_url`, `principal_signature_url`, `created_at`, `updated_at`)
VALUES (2, 2, 'Tia Wulandari, S.Pd.,Gr.', '142062021012', 'Ogan Ilir', '19 Juni 2026', 'uploads/reports/logo_smp_robbani.png', 'uploads/reports/kop_smp_robbani.png', 'uploads/reports/stempel_resmi.png', 'uploads/reports/ttd_kepsek.png', NOW(), NOW())
ON DUPLICATE KEY UPDATE `principal_name`='Tia Wulandari, S.Pd.,Gr.', `principal_nip`='142062021012', `report_city`='Ogan Ilir', `report_date`='19 Juni 2026', `school_logo_url`='uploads/reports/logo_smp_robbani.png';

SET FOREIGN_KEY_CHECKS = 1;
