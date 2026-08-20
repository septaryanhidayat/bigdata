# SmartEdu SIT Robbani — Database Schema

> *Skema Lengkap 58 Tabel Database Aktual*  
> *Engine: SQLite (dev) / MySQL InnoDB (prod)*  
> *Terakhir diperbarui: 18 Agustus 2026*

---

## 📊 Daftar Lengkap 58 Tabel

### 🏛️ Core — Auth, Multi-Tenancy & Sistem

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `schools` | 4 | Data 4 unit sekolah (TKIT, SDIT, SMPIT, SMAIT) — anchor multi-tenancy |
| `users` | 148 | Akun pengguna (15 role RBAC), kolom `school_id`, `role`, `avatar`, `is_blocked` |
| `personal_access_tokens` | — | Token REST API Mobile (Laravel Sanctum) |
| `academic_years` | 1 | Tahun ajaran aktif per unit sekolah |
| `site_settings` | 42 | Pengaturan global CMS (nama sekolah, logo, berita JSON, profil yayasan, dll) |
| `feature_modules` | 21 | Toggle on/off fitur modul per unit |
| `audit_logs` | 23+ | Log aktivitas pengguna untuk audit trail |
| `system_error_logs` | — | Log error PHP/Laravel otomatis dengan auto-mitigation |
| `sessions` | — | Session login aktif (driver: database) |
| `cache` / `cache_locks` | — | Laravel cache driver |
| `jobs` / `job_batches` / `failed_jobs` | — | Laravel queue worker |
| `password_reset_tokens` | — | Token reset password |
| `migrations` | 27 | Laravel migration tracking (27 file migration) |

### 👩‍🏫 Akademik & Kurikulum

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `students` | 38 | Data siswa (NIS, nama, kelas, school_id, foto, NISN) |
| `guardians` | 13 | Data wali murid / orang tua siswa |
| `classrooms` | 11 | Data kelas (nama, tingkat, wali kelas, tahun ajaran, school_id) |
| `levels` | 6 | Tingkatan kelas (Kelas 1–6 SD, 7–9 SMP, dll) |
| `subjects` | 13 | Mata pelajaran per unit sekolah |
| `grades` | 1+ | Nilai akademik siswa (per mapel, per semester) |
| `schedules` | 1+ | Jadwal pelajaran harian |
| `kbm_journals` | 1+ | Jurnal kegiatan belajar mengajar harian |
| `student_leaves` | 1+ | Izin tidak masuk siswa |
| `attendances` | 104 | Presensi siswa (QR/RFID, status: HADIR/IZIN/SAKIT/ALPHA) |

### 💰 Keuangan

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `spp_bills` | 16 | Tagihan SPP per siswa per bulan |
| `spp_payments` | 13 | Pembayaran SPP (kasir, transfer, gateway) |
| `chart_of_accounts` | 3 | Bagan akun keuangan (COA) yayasan |
| `journal_entries` | 1+ | Jurnal akuntansi harian |
| `savings_transactions` | 73 | Buku tabungan siswa (setor/tarik) |

### 🛒 Kantin & RFID

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `canteen_outlets` | 3 | Data booth/outlet kantin sekolah |
| `canteen_products` | 3 | Menu produk kantin + harga |
| `canteen_transactions` | 13 | Transaksi pembelian kantin |

### 🧑‍💼 HRIS & Kepegawaian

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `employees` | 108 | Data lengkap pegawai (NIK, NUPTK, jabatan, foto, biometrik wajah, dossier) |
| `payroll_salaries` | 10 | Data penggajian bulanan |
| `employee_attendance_logs` | 1+ | Presensi pegawai (GPS/face recognition) |
| `employee_leaves` | 14 | Izin/cuti pegawai |
| `employee_kpis` | 2 | Penilaian kinerja (KPI) pegawai |

### 🕌 BPI & Mutabaah

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `bpi_mutabaahs` | 6 | Mutabaah yaumiyah siswa (sholat 5 waktu, tilawah, puasa, dhuha) |
| `employee_mutabaahs` | 2 | Mutabaah yaumiyah pegawai |
| `employee_bpi_groups` | 2 | Kelompok halaqah BPI pegawai |
| `employee_bpi_members` | 13 | Anggota kelompok BPI |
| `employee_bpi_meetings` | 14 | Catatan pertemuan BPI/Halaqah |

### 📚 Perpustakaan, LMS, CBT

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `library_books` | 4 | Koleksi buku perpustakaan + status sirkulasi |
| `lms_materials` | 4 | Materi e-learning (file, video, link) |
| `cbt_exams` | 10 | Soal & ujian CBT (termasuk CBT PPDB) |

### 🏫 Sarpras & BK

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `sarpras_assets` | 13 | Inventaris aset sarana prasarana |
| `rooms` | 1 | Data ruangan untuk booking fasilitas |
| `bk_records` | 7 | Catatan bimbingan konseling siswa |

### 📝 Persuratan & TTE

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `official_letters` | 38 | Surat masuk & keluar resmi |
| `letter_templates` | 6 | Template surat dengan KOP unit |
| `letter_dispositions` | 18 | Disposisi surat antar pejabat |
| `letter_audit_trails` | 102 | Jejak audit penandatanganan TTE |
| `digital_signatures` | 20 | Hash SHA-256 & UUID token TTE |

### 🎓 SPMB & PPDB

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `ppdb_registrations` | 18 | Pendaftaran siswa baru (formulir online multi-step) |

### 🤖 AI Knowledge Base

| Tabel | Baris (seed) | Deskripsi |
|-------|-------------|-----------|
| `ai_knowledge_bases` | 4 | Dokumen knowledge base RAG (PDF chunks, teks manual) |
| `faq_items` | 7 | FAQ yang bisa di-training ke chatbot AI |

---

## 🔑 Kunci Multi-Tenancy

```sql
-- Semua tabel data per-unit menyimpan school_id
-- school_id = NULL → data global yayasan
-- school_id = 1    → KB/TKIT Robbani
-- school_id = 2    → SDIT Robbani
-- school_id = 3    → SMPIT Robbani
-- school_id = 4    → SMAIT Robbani

-- Query dengan scoping wajib (Eloquent):
$query->when($user->school_id, fn($q) => $q->where('school_id', $user->school_id));
```

---

## 🗃️ File Database

| Environment | Koneksi | File / Keterangan |
|-------------|---------|-------------------|
| **Development** | SQLite 3 | `database/database.sqlite` (~20MB, excluded git) |
| **Produksi cPanel** | MySQL 5.7+ | Import `smartedu_FINAL_sitrobbani.sql` (2.14 MB) |
| **Export Script** | PHP | `scratch/export_full_to_mysql.php` — konversi SQLite → MySQL penuh |

---

## 📌 Kolom Penting Model User

```php
// app/Models/User.php
// Kolom: id, name, email, password, role, school_id, avatar,
//        phone, is_blocked, remember_token, created_at, updated_at
//
// Role constants:
const ROLE_SUPER_ADMIN       = 'SUPER_ADMIN';
const ROLE_YAYASAN_CHAIRMAN  = 'YAYASAN_CHAIRMAN';
const ROLE_HEADMASTER        = 'HEADMASTER';
const ROLE_TEACHER           = 'TEACHER';
const ROLE_STAFF_TU          = 'STAFF_TU';
const ROLE_STAFF_KEUANGAN    = 'STAFF_KEUANGAN';
// ... 15 total roles
```
