-- ==============================================================================
-- SCRIPT PEMBAHARUAN DATABASE SIT ROBBANI:
-- 1. Penggantian Domain Email Akun Menjadi @sitrobbani.sch.id
-- 2. Penggantian Istilah Robotik / Robotika Menjadi Koding
-- ==============================================================================

-- 1. UPDATE EMAIL PENGGUNA (USERS & EMPLOYEES)
UPDATE `users` 
SET `email` = CONCAT(SUBSTRING_INDEX(`email`, '@', 1), '@sitrobbani.sch.id') 
WHERE `email` NOT LIKE '%@sitrobbani.sch.id';

UPDATE `employees` 
SET `email` = CONCAT(SUBSTRING_INDEX(`email`, '@', 1), '@sitrobbani.sch.id') 
WHERE `email` IS NOT NULL AND `email` NOT LIKE '%@sitrobbani.sch.id';

-- 2. UPDATE ISTILAH ROBOTIK MENJADI KODING
-- Tabel Catatan Wali Kelas (Ekskul Siswa)
UPDATE `homeroom_notes` 
SET `extracurriculars` = REPLACE(REPLACE(REPLACE(REPLACE(`extracurriculars`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') 
WHERE `extracurriculars` LIKE '%obotik%';

-- Tabel Ekstrakurikuler
UPDATE `extracurriculars` 
SET `name` = REPLACE(REPLACE(REPLACE(REPLACE(`name`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') 
WHERE `name` LIKE '%obotik%';

-- Tabel Mata Pelajaran
UPDATE `subjects` 
SET `name` = REPLACE(REPLACE(`name`, 'Sains & Robotika', 'Sains & Koding Digital'), 'Robotik', 'Koding') 
WHERE `name` LIKE '%obotik%';

-- Tabel Ruangan
UPDATE `rooms` 
SET `name` = REPLACE(REPLACE(`name`, 'Lab Robotika Modern', 'Lab Koding Digital Modern'), 'Robotika', 'Koding') 
WHERE `name` LIKE '%obotik%';

-- Tabel Pengaturan Situs & Profil Unit
UPDATE `site_settings` 
SET `value` = REPLACE(REPLACE(REPLACE(REPLACE(`value`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') 
WHERE `value` LIKE '%obotik%';

-- Tabel Modul Fitur
UPDATE `feature_modules` 
SET `full_desc` = REPLACE(REPLACE(`full_desc`, 'Robotik', 'Koding'), 'robotik', 'Koding') 
WHERE `full_desc` LIKE '%obotik%';

-- Tabel Basis Pengetahuan AI
UPDATE `ai_knowledge_bases` 
SET `raw_content` = REPLACE(REPLACE(REPLACE(REPLACE(`raw_content`, 'Robotika', 'Koding'), 'robotika', 'Koding'), 'Robotik', 'Koding'), 'robotik', 'Koding') 
WHERE `raw_content` LIKE '%obotik%';
