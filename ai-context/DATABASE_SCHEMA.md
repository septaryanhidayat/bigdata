# SmartEdu SIT Robbani — Database Schema (DATABASE_SCHEMA.md)

> **Skema Lengkap 57 Tabel Database Aktual**
> *Terakhir diperbarui: 17 Agustus 2026 | DB Engine: SQLite (dev) / MySQL (prod)*

---

## 📊 Daftar Lengkap 57 Tabel

### 🏛️ Core — Yayasan & Multi-Tenancy
| Tabel | Deskripsi |
|-------|-----------|
| `schools` | Data 4 unit sekolah (TKIT, SDIT, SMPIT, SMAIT) + Yayasan — `school_id` adalah anchor multi-tenancy |
| `users` | Akun pengguna (15 role RBAC), kolom `school_id`, `role`, `avatar` |
| `academic_years` | Tahun ajaran aktif per unit sekolah |
| `site_settings` | Pengaturan global sistem (nama sekolah, logo, warna tema, dll) |
| `feature_modules` | Toggle on/off fitur modul per unit |
| `audit_logs` | Log aktivitas pengguna untuk audit trail |
| `sessions` | Session login aktif |
| `migrations` | Laravel migration tracking |
| `cache` / `cache_locks` | Laravel cache driver |
| `jobs` / `job_batches` / `failed_jobs` | Laravel queue worker |
| `password_reset_tokens` | Token reset password |

### 👩‍🏫 Akademik & Kurikulum
| Tabel | Deskripsi |
|-------|-----------|
| `students` | Data siswa lengkap (NIS, nama, kelas, sekolah, foto) |
| `guardians` | Data wali murid / orang tua siswa |
| `classrooms` | Data kelas (nama, tingkat, wali kelas, tahun ajaran) |
| `levels` | Tingkatan kelas (1-6 SD, 7-9 SMP, dll) |
| `subjects` | Mata pelajaran per unit sekolah |
| `grades` | Nilai akademik siswa (per mapel, per semester) |
| `schedules` | Jadwal pelajaran harian |
| `kbm_journals` | Jurnal kegiatan belajar mengajar harian |
| `student_leaves` | Izin tidak masuk siswa |

### 💰 Keuangan
| Tabel | Deskripsi |
|-------|-----------|
| `spp_bills` | Tagihan SPP per siswa per bulan |
| `spp_payments` | Pembayaran SPP (kasir, transfer, gateway) |
| `chart_of_accounts` | Bagan akun keuangan (COA) yayasan |
| `journal_entries` | Jurnal akuntansi harian |
| `savings_transactions` | Buku tabungan siswa |

### 🛒 Kantin & RFID
| Tabel | Deskripsi |
|-------|-----------|
| `canteen_outlets` | Data booth/outlet kantin sekolah |
| `canteen_products` | Menu produk kantin + harga |
| `canteen_transactions` | Transaksi pembelian kantin (saldo RFID) |

### 🧑‍💼 HRIS & Kepegawaian
| Tabel | Deskripsi |
|-------|-----------|
| `employees` | Data lengkap pegawai (NIK, NUPTK, jabatan, foto, biometrik face) |
| `payroll_salaries` | Data penggajian bulanan |
| `employee_attendance_logs` | Presensi pegawai (GPS/face recognition) |
| `employee_leaves` | Izin/cuti pegawai |
| `employee_kpis` | Penilaian kinerja (KPI) pegawai |

### 🕌 BPI & Mutabaah
| Tabel | Deskripsi |
|-------|-----------|
| `bpi_mutabaahs` | Mutabaah yaumiyah siswa (sholat, tilawah, puasa) |
| `employee_mutabaahs` | Mutabaah yaumiyah pegawai |
| `employee_bpi_groups` | Kelompok halaqah BPI pegawai |
| `employee_bpi_members` | Anggota kelompok BPI pegawai |
| `employee_bpi_meetings` | Catatan pertemuan BPI/Halaqah |

### 📋 Presensi
| Tabel | Deskripsi |
|-------|-----------|
| `attendances` | Presensi siswa (QR/RFID) |

### 📚 Perpustakaan
| Tabel | Deskripsi |
|-------|-----------|
| `library_books` | Koleksi buku perpustakaan + status sirkulasi |

### 💻 LMS & CBT
| Tabel | Deskripsi |
|-------|-----------|
| `lms_materials` | Materi e-learning (file, video, link) |
| `cbt_exams` | Soal & ujian CBT (termasuk CBT PPDB) |

### 🏫 Sarpras
| Tabel | Deskripsi |
|-------|-----------|
| `sarpras_assets` | Inventaris aset sarana prasarana |
| `rooms` | Data ruangan untuk booking fasilitas |

### 💬 BK
| Tabel | Deskripsi |
|-------|-----------|
| `bk_records` | Catatan bimbingan konseling siswa |

### 📝 Persuratan & TTE
| Tabel | Deskripsi |
|-------|-----------|
| `official_letters` | Surat masuk & keluar resmi |
| `letter_templates` | Template surat dengan KOP unit |
| `letter_dispositions` | Disposisi surat antar pejabat |
| `letter_audit_trails` | Jejak audit penandatanganan TTE |
| `digital_signatures` | Hash SHA-256 & UUID token TTE |

### 🎓 SPMB & PPDB
| Tabel | Deskripsi |
|-------|-----------|
| `ppdb_registrations` | Pendaftaran siswa baru (formulir online) |

### 🤖 AI Knowledge Base
| Tabel | Deskripsi |
|-------|-----------|
| `ai_knowledge_bases` | Dokumen knowledge base RAG (PDF chunks, teks manual) |
| `faq_items` | FAQ yang bisa di-training ke chatbot AI |

### ⚙️ Sistem
| Tabel | Deskripsi |
|-------|-----------|
| `system_error_logs` | Log error PHP/Laravel otomatis (dengan auto-mitigation) |

---

## 🔑 Kunci Multi-Tenancy

```sql
-- Semua tabel yang memiliki data per-unit menyimpan school_id
ALTER TABLE students ADD COLUMN school_id INTEGER REFERENCES schools(id);
ALTER TABLE employees ADD COLUMN school_id INTEGER REFERENCES schools(id);
ALTER TABLE spp_bills ADD COLUMN school_id INTEGER;
-- dst.

-- Query dengan scoping wajib:
SELECT * FROM students WHERE school_id = ? -- (atau tidak ada filter jika SUPER_ADMIN)
```

---

## 🗃️ File Database

| Environment | File/Config | Keterangan |
|-------------|-------------|------------|
| **Development** | `database/database.sqlite` (~20MB) | SQLite lokal, excluded dari Git |
| **Produksi** | MySQL database cPanel | Import dari `scratch/mysql_FINAL_sitrobbani.sql` |
| **Export Script** | `scratch/export_sqlite_to_mysql.php` | Konversi SQLite → MySQL |
