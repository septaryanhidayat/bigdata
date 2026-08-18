# 🏫 SmartEdu SIT Robbani — Ekosistem Digital & SIM Sekolah Islam Terpadu

> **Platform Tata Kelola Pendidikan Terpadu, Web Portal Multi-Unit, Aplikasi Mobile SDM & Smart AI RAG Assistant**  
> **Yayasan Generasi Robbani Ogan Ilir, Sumatera Selatan**  
> *Versi: 3.0 — Final Pre-Production (Tahun Ajaran 2026/2027)*  
> *Rilis: 18 Agustus 2026*

---

## 🌟 Tentang SmartEdu SIT Robbani

**SmartEdu SIT Robbani** adalah platform ekosistem digital terpadu (*All-in-One Educational ERP, Multi-Unit Web Portal & Mobile SDM App*) yang dirancang khusus untuk memenuhi standar mutu **Jaringan Sekolah Islam Terpadu (JSIT)** dan **Kurikulum Merdeka**.

Platform ini mengintegrasikan **23+ Modul Digital Terpadu** yang menghubungkan seluruh tata kelola akademik, keuangan E-SPP, persuratan digital ber-TTE resmi, pembentukan karakter Islami (BPI Mutabaah), portal SPMB Online integratif, aplikasi mobile SDM (React Native Expo SDK 52), dan Chatbot AI cerdas berbasis RAG.

---

## 🏛️ Struktur Multi-Tenancy (4 Unit Sekolah + Yayasan)

| Unit Sekolah / Lembaga | Kode | school_id | Pimpinan Lembaga |
| :--- | :---: | :---: | :--- |
| **Yayasan Generasi Robbani** | `YAYASAN` | *Global (null)* | **Sughesti Wulandari, S.Pd** *(Ketua Yayasan)* |
| **KB / TKIT Robbani** | `TKIT` | `1` | **Ani Oktar Yansi, S.Pd.I** *(Kepala Sekolah)* |
| **SDIT Robbani** | `SDIT` | `2` | **Nur Amalia, S.Pd** *(Kepala Sekolah)* |
| **SMPIT Robbani** | `SMPIT` | `3` | **Tia Wulandari, S.Pd., Gr.** *(Kepala Sekolah)* |
| **SMAIT Robbani** | `SMAIT` | `4` | *(Persiapan Program Sains & IT)* |

---

## 📦 Ekosistem 23+ Modul Digital Terpadu

### 📚 1. Akademik, Kurikulum & E-Learning
1. **Master Data Multi-Unit**: Pengelolaan data Siswa, Guru, Kelas, dan Rombel.
2. **E-Rapor Kurikulum Merdeka & JSIT**: Penilaian Formatif/Sumatif, Capaian P5, & Cetak Rapor PDF Resmi.
3. **CBT Ujian & Asesmen Digital**: Bank Soal Pilihan Ganda & Essay, Timer, Acak Soal, Penilaian Otomatis.
4. **E-Learning LMS**: Materi pelajaran (Video/PDF), tugas siswa, & forum diskusi KBM.
5. **Jurnal Mengajar & Absensi Kelas**: Pengisian jurnal KBM harian guru & rekapitulasi kehadiran siswa.

### 💰 2. Keuangan, POS & Cashless School
6. **E-SPP & Billing Otomatis**: Penagihan SPP bulanan otomatis, cetak kuitansi PDF resmi ber-QR, & akuntansi COA.
7. **Tabungan Siswa & Kantin Digital**: Setor/tarik tabungan siswa & transaksi non-tunai kantin sekolah.
8. **Penggajian & HRIS SDM (Payroll)**: Perhitungan gaji pokok, tunjangan, potongan absensi, & cetak Slip Gaji PDF.

### 🌙 3. Pembentukan Karakter & Layanan Sekolah
9. **Bina Pribadi Islam (BPI Mutabaah Yaumiyah)**: Pencatatan ibadah harian (Sholat 5 Waktu, Tilawah, Dhuha, Tahajjud).
10. **Bimbingan Konseling (BK Online)**: Pencatatan poin prestasi & pelanggaran siswa, booking konseling.
11. **Sarana Prasarana (Sarpras Barcode)**: Inventarisasi aset ruangan, barcode generator, & pemeliharaan barang.
12. **E-Library & Sirkulasi QR**: Katalog buku perpustakaan & peminjaman/pengembalian buku via QR.
13. **Layanan Sewa Fasilitas & Kerjasama**: Formulir permohonan kunjungan & sewa gedung/lapangan.

### 🚀 4. Portal Publik, SPMB Online & Persuratan TTE
14. **Website Publik & Profil 4 Unit**: Portal resmi dengan dual logo, dark mode Obsidian/Neon Lime, jadwal sholat, & ratusan berita asli WordPress.
15. **Halaman Profil Yayasan (CMS Admin)**: Sambutan ketua, visi misi, 5 pilar JSIT, struktur pengurus — dapat diedit via admin.
16. **Portal SPMB Online Integratif**: Formulir pendaftaran multi-step wizard, upload berkas, kartu ujian, & verifikasi QR.
17. **Persuratan Digital & QR TTE**: Draf surat keluar KOP resmi, disposisi pimpinan, hash SHA-256 & verifikasi publik.

### 🤖 5. Layanan Cerdas & Mobile SDM
18. **Smart AI Assistant & Knowledge Base RAG**: Chatbot AI cerdas 24/7 dengan Retrieval-Augmented Generation dari dokumen PDF resmi.
19. **Aplikasi Mobile SDM SIT Robbani (Expo React Native SDK 52)**: Presensi GPS & biometrik wajah, pengajuan cuti, slip gaji mobile, mutabaah SDM.
20. **Filter Konten Terlarang**: Auto-filter judol, pinjol, SARA, kekerasan, pornografi, dan konten terlarang lainnya.

---

## 🛠️ Spesifikasi Teknologi (Tech Stack)

| Komponen | Spesifikasi / Pustaka | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 13.24.x** | PHP 8.4.24 (Herd lokal) / PHP 8.4 (cPanel) |
| **Frontend Styling** | **Tailwind CSS CDN v4 / Vite v3** | Dark Mode Obsidian (`#040d06`) + Neon Lime (`#c6f634`) |
| **Interaktivitas UI** | **Alpine.js 3.x & SweetAlert2** | State management reaktif, dialog konfirmasi |
| **Asset Bundler** | **Vite 6.x** | Pre-built di `public/build/` — committed ke Git untuk cPanel |
| **Database Dev** | **SQLite 3** | `database/database.sqlite` (~20MB), excluded dari Git |
| **Database Prod** | **MySQL 5.7+ / MariaDB 10.3+** | 58 Tabel InnoDB, Import `smartedu_FINAL_sitrobbani.sql` (2.14MB) |
| **Mobile App** | **React Native (Expo SDK 52)** | Folder `sdm-robbani-mobile/` |
| **REST API Security** | **Laravel Sanctum Token** | Bearer Token pada seluruh endpoint `/api/v1/mobile/*` |
| **AI LLM Engine** | **Google Gemini 1.5 Flash API** | Mesin RAG dengan semantic document retrieval |
| **PDF & QR Engine** | **DomPDF & Simple QrCode** | Kuitansi SPP, Slip Gaji, Kartu Ujian, & Surat TTE |
| **Tipografi** | **Plus Jakarta Sans (Google Fonts)** | Font premium di semua halaman web & admin |

---

## 🛡️ 8 Lapisan Keamanan Sistem (Cybersecurity Hardening)

1. **Auth & RBAC Guard**: Proteksi middleware `auth` dan pemisahan 15 hak akses pengguna (Super Admin → Ketua Yayasan → Kepala Sekolah → Guru → dst).
2. **REST API Sanctum Guard**: Semua endpoint API mobile diproteksi `auth:sanctum` (kecuali login publik).
3. **Multi-Tenancy Scoping**: Strict isolation `school_id` mencegah akses silang data antar-unit.
4. **SQL Injection Defense**: Parameter binding PDO via Eloquent ORM pada seluruh query.
5. **Cross-Site Scripting (XSS) & CSRF Defense**: Blade auto-escape, sanitasi input, & token CSRF wajib di semua form.
6. **Global Security Headers**: `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`.
7. **TTE Cryptographic Integrity**: Hash digital SHA-256 dan token UUID publik untuk verifikasi keaslian surat.
8. **Auto Error Logging**: Semua exception PHP/Laravel otomatis tercatat ke `system_error_logs` dengan mitigasi solusi.

---

## 🚀 Panduan Deployment ke cPanel

### Langkah Cepat:
1. **Clone Repository**:
   ```bash
   git clone https://github.com/septaryanhidayat/bigdata.git ~/bigdata
   ```
2. **Setup `.env` Produksi**:
   Salin template `.env.cpanel` menjadi `.env`, isi koneksi database MySQL cPanel.
3. **Install Dependencies**:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan storage:link
   php artisan optimize
   ```
4. **Import Database MySQL**:
   phpMyAdmin cPanel → Buat database baru → **Import** file `smartedu_FINAL_sitrobbani.sql` (2.14 MB, 58 tabel).
5. **Konfigurasi DocumentRoot**:
   Arahkan DocumentRoot domain `sitrobbani.sch.id` ke subfolder `~/bigdata/public`.
6. **Set Permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

> **Catatan**: `public/build/` sudah di-commit ke Git, sehingga **tidak perlu Node.js** di server cPanel.

---

## 🔑 Kredensial Pengujian Awal

* **URL Login Admin**: `https://sitrobbani.sch.id/admin/login` *(atau `http://bigdata.test/admin/login`)*
* **Email Super Admin**: `admin@smartedu.id`
* **Kata Sandi Default**: `p4l3mb4ng`

> ⚠️ **Ganti password default segera setelah pertama kali login di produksi!**

---

## 📁 Struktur Folder Penting

```
bigdata/
├── app/Http/Controllers/
│   ├── SchoolWebsiteController.php   ← Controller web publik (1584 baris)
│   ├── Admin/CmsController.php       ← Dashboard admin (1895 baris)
│   └── Api/HrisMobileApiController.php ← API mobile (54KB)
├── resources/views/
│   ├── school/home.blade.php         ← Beranda utama (200KB)
│   ├── school/unit.blade.php         ← 4 Profil unit (94KB)
│   ├── school/profil.blade.php       ← Profil Yayasan
│   ├── school/ppdb.blade.php         ← SPMB Online (64KB)
│   └── admin/cms/content.blade.php   ← CMS admin dashboard
├── database/
│   ├── migrations/                   ← 27 file migration aktual
│   └── seeders/                      ← 7 seeder (CMS, MasterData, Users, dll)
├── ai-context/                       ← 9 dokumen panduan sistem
├── sdm-robbani-mobile/               ← Aplikasi Expo React Native
├── smartedu_FINAL_sitrobbani.sql     ← ✅ Database MySQL produksi (2.14 MB)
└── .env.cpanel                       ← Template .env untuk cPanel
```

---

## 📄 Lisensi & Hak Cipta

Dikembangkan khusus untuk **[SIT Robbani Ogan Ilir](https://sitrobbani.sch.id)** oleh **[Beranda Teknologi Digital](https://berandadigital.net)**.  
© 2026 SmartEdu SIT Robbani. Hak Cipta Dilindungi Undang-Undang.
