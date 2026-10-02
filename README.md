# 🏫 SmartEdu SIT Robbani — Ekosistem Digital & SIM Sekolah Islam Terpadu

> **Platform Tata Kelola Pendidikan Terpadu, Web Portal Multi-Unit, Aplikasi Mobile SDM & Smart AI RAG Assistant**  
> **Yayasan Generasi Robbani Ogan Ilir, Sumatera Selatan**  
> *Versi: 3.2 — Production Release (Tahun Ajaran 2026/2027)*  
> *Update Terkini: Oktober 2026*

[![Laravel](https://img.shields.io/badge/Laravel-11%20%2F%2013-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.4%20%2F%204.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![React Native Expo](https://img.shields.io/badge/Expo-SDK_52-000020?style=for-the-badge&logo=expo&logoColor=white)](https://expo.dev)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)

---

## 🌟 Tentang SmartEdu SIT Robbani

**SmartEdu SIT Robbani** adalah platform ekosistem digital terpadu (*All-in-One Educational ERP, Multi-Unit Web Portal & Mobile SDM App*) yang dirancang khusus untuk memenuhi standar mutu **Jaringan Sekolah Islam Terpadu (JSIT)** dan **Kurikulum Merdeka**.

Platform ini mengintegrasikan **23+ Modul Digital Terpadu** yang menghubungkan seluruh tata kelola akademik, keuangan E-SPP, persuratan digital ber-TTE resmi, pembentukan karakter Islami (BPI Mutabaah Yaumiyah), portal SPMB Online integratif ber-auto-save, aplikasi mobile SDM (React Native Expo SDK 52), dan Chatbot AI cerdas berbasis RAG (*Retrieval-Augmented Generation*).

---

## 🚀 Sorotan Pembaruan Fitur Mutakhir (Update 2026/2027)

### 🎓 1. SPMB Online 5-Step Smart Wizard
* 💾 **Auto-Save Draft & Pemulihan Sesi Otomatis**:
  * Isian formulir otomatis tersimpan secara berkala ke penyimpanan lokal (*encrypted local storage*) saat orang tua mengetik.
  * Jika browser tertutup tidak sengaja, ter-refresh, atau kuota/koneksi internet terputus, formulir akan memunculkan banner pemulihan draf dengan 1-klik sehingga orang tua calon siswa tidak perlu mengisi ulang dari awal.
* 🔢 **Validasi Cerdas NISN (Nomor Induk Siswa Nasional)**:
  * Wajib diisi 10 digit angka khusus untuk pendaftar jenjang **SDIT, SMPIT, dan SMAIT** (lengkap dengan filter proteksi karakter non-angka dan stepper check).
  * Bersifat opsional untuk pendaftar usia dini (TPA, KB, dan TKIT).
* 🏫 **Sistem Sekolah Asal Adaptif**:
  * Pilihan kategori: *Alumni SIT Robbani*, *Luar SIT Robbani*, dan *Belum Pernah Sekolah*.
  * Logika otomatis: Penyesuaian nama sekolah asal, jenjang, dan penonaktifan status sekolah asal (negeri/swasta) bagi calon siswa balita yang belum pernah bersekolah.
* 📱 **Dual Kontak Orang Tua Wajib**:
  * Nomor WhatsApp Ayah dan WhatsApp Ibu keduanya diwajibkan untuk menjamin komunikasi panitia selalu terhubung.
* 💳 **Kemudahan Biaya Pendaftaran**:
  * Menampilkan nomor rekening resmi yayasan yang dilengkapi tombol **Salin Nomor Rekening** instan dengan feedback visual.
  * Tanda kuota promo pendaftar pertama (potongan Rp1.000.000 dan Rp500.000) dengan indikator transparan.
* 📂 **Unggah Berkas Persyaratan Terintegrasi**:
  * Wajib mengunggah Akta Kelahiran, Kartu Keluarga (KK), KTP Orang Tua, dan Bukti Transfer Biaya Pendaftaran.

### 📄 2. Berkas Formulir & Lampiran PDF 4 Halaman Siap Cetak (Print Ready)
Sistem cetak PDF pendaftaran kini otomatis menggabungkan formulir dan foto fisik lampiran berkas dalam dokumen PDF 4 halaman proporsional yang rapi untuk arsip panitia:
* **Halaman 1**: Formulir Pendaftaran Biodata Lengkap, Pilihan Unit, Data Orang Tua, dan Pernyataan Keabsahan bermaterai digital.
* **Halaman 2**: Lampiran Foto Asli Dokumen Akta Kelahiran Calon Siswa (format cetak penuh).
* **Halaman 3**: Lampiran Foto Asli Dokumen Kartu Keluarga (KK).
* **Halaman 4**: Kolase Arsip Terpadu: Pas Foto Calon Siswa, KTP Orang Tua (Ayah/Ibu), dan Bukti Transfer Biaya Pendaftaran.

### 🌐 3. Arsitektur Dual Domain & Subdomain
* Akses form pendaftaran dapat diakses melalui:
  * Domain Utama: `https://sitrobbani.sch.id/ppdb`
  * Subdomain Dedicated: `https://spmb.sitrobbani.sch.id`
* Routing controller mendeteksi subdomain secara dinamis dan menjaga integritas navigasi formulir serta unduhan dokumen.

---

## 🏛️ Struktur Multi-Tenancy (4 Unit Sekolah + Yayasan)

| Unit Sekolah / Lembaga | Kode | school_id | Pimpinan Lembaga | Jenjang Pendidikan |
| :--- | :---: | :---: | :--- | :--- |
| **Yayasan Generasi Robbani** | `YAYASAN` | *Global (null)* | **Sughesti Wulandari, S.Pd** *(Ketua Yayasan)* | Badan Penyelenggara |
| **KB / TKIT Robbani** | `TKIT` | `1` | **Ani Oktar Yansi, S.Pd.I** *(Kepala Sekolah)* | PAUD, KB, & TK Islam Terpadu |
| **SDIT Robbani** | `SDIT` | `2` | **Nur Amalia, S.Pd** *(Kepala Sekolah)* | Sekolah Dasar Islam Terpadu |
| **SMPIT Robbani** | `SMPIT` | `3` | **Tia Wulandari, S.Pd., Gr.** *(Kepala Sekolah)* | SMP Islam Terpadu |
| **SMAIT Robbani** | `SMAIT` | `4` | *(Persiapan Program Sains & IT)* | SMA Islam Terpadu Plus |

---

## 📦 Ekosistem 23+ Modul Digital Terpadu

### 📚 1. Akademik, Kurikulum & E-Learning
1. **Master Data Multi-Unit**: Pengelolaan terisolasi data Siswa, Guru/Ustadz, Kelas, dan Rombel antar-unit.
2. **E-Rapor Kurikulum Merdeka & JSIT**: Penilaian Formatif/Sumatif, Capaian Karakter P5, dan Cetak Rapor PDF Resmi.
3. **CBT Ujian & Asesmen Digital**: Bank Soal Pilihan Ganda & Essay, Timer ujian real-time, acak soal, dan scoring otomatis.
4. **E-Learning LMS**: Materi pelajaran interaktif (Video/PDF), penugasan siswa, dan forum diskusi materi KBM.
5. **Jurnal Mengajar & Absensi Kelas**: Rekapitulasi kehadiran siswa harian dan pencatatan jurnal KBM guru.

### 💰 2. Keuangan, POS & Cashless School
6. **E-SPP & Billing Otomatis**: Penagihan SPP bulanan otomatis, cetak kuitansi PDF resmi ber-QR, dan pembukuan Chart of Accounts (COA).
7. **Tabungan Siswa & Kantin Digital**: Setor/tarik tabungan siswa dan sistem kasir non-tunai kantin sekolah.
8. **Penggajian & HRIS SDM (Payroll)**: Kalkulasi gaji pokok, tunjangan jabatan, potongan absensi, dan cetak Slip Gaji PDF resmi.

### 🌙 3. Pembentukan Karakter & Layanan Sekolah
9. **Bina Pribadi Islam (BPI Mutabaah Yaumiyah)**: Monitoring ibadah harian santri (Sholat 5 Waktu, Tilawah, Dhuha, Tahajjud, Dzikir).
10. **Bimbingan Konseling (BK Online)**: Pencatatan poin prestasi & pelanggaran siswa, serta formulir konseling online.
11. **Sarana Prasarana (Sarpras Barcode)**: Inventarisasi aset ruangan, barcode scanner generator, dan rekap pemeliharaan sarana.
12. **E-Library & Sirkulasi QR**: Katalog buku perpustakaan digital, peminjaman dan pengembalian via scan QR code.
13. **Layanan Sewa Fasilitas & Kemitraan**: Formulir reservasi kunjungan studi tiru dan penyewaan aula/lapangan.

### 🚀 4. Portal Publik, SPMB Online & Persuratan TTE
14. **Website Publik & Profil 4 Unit**: Portal resmi dengan dual logo, palet Obsidian & Neon Lime, jadwal sholat API Kemenag, dan integrasi artikel berita.
15. **Halaman Profil Yayasan (CMS Admin)**: Sambutan ketua, visi misi, 5 pilar JSIT, dan struktur pengurus yang dapat dikelola via panel admin.
16. **Portal SPMB Online Integratif**: 5-step wizard dengan auto-save draft, upload dokumen persyaratan, dan kartu ujian ber-QR verifikasi.
17. **Persuratan Digital & TTE Resmi**: Draf surat keluar dengan KOP resmi, alur disposisi berjenjang, tanda tangan elektronik kriptografis SHA-256 ber-QR.

### 🤖 5. Layanan Cerdas & Mobile SDM
18. **Smart AI Assistant & Knowledge Base RAG**: Chatbot AI interaktif 24/7 menggunakan Google Gemini yang dilatih pada dokumen SOP dan panduan resmi yayasan.
19. **Aplikasi Mobile SDM SIT Robbani (Expo React Native SDK 52)**: Presensi berbasis radius GPS & selfie wajah, permohonan izin/cuti, slip gaji digital, dan mutabaah yaumiyah asatidz.
20. **Filter Konten & Keamanan Siber**: Proteksi konten terlarang, validasi berkas multi-layer, dan enkripsi data sensitif.

---

## 🛠️ Spesifikasi Teknologi (Tech Stack)

| Komponen | Spesifikasi / Library | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 11 / 13** | PHP 8.4.x (Kompatibel PHP 8.2+) |
| **Frontend Styling** | **Tailwind CSS v3.4 / v4** | Palet Emerald Dark Mode Obsidian (`#040d06`) & Neon Lime (`#c6f634`) |
| **Interaktivitas UI** | **Alpine.js 3.x & SweetAlert2** | Dynamic Stepper, Auto-Save LocalStorage, Alert Modals |
| **Mobile Application** | **React Native (Expo SDK 52)** | Folder `sdm-robbani-mobile/` (Android & iOS) |
| **Database** | **MySQL 5.7+ / MariaDB 10.3+** | 58 Tabel InnoDB, Schema Multi-Tenant |
| **AI LLM Engine** | **Google Gemini 1.5 Flash API** | Knowledge Base RAG via Semantic Document Parsing |
| **PDF & QR Engine** | **DomPDF & Simple QrCode** | Formulir 4 Halaman, Kuitansi SPP, Slip Gaji, Kartu Ujian, & Surat TTE |
| **Tipografi** | **Plus Jakarta Sans** | Standar font modern Google Fonts |

---

## 🛡️ Lapisan Keamanan Sistem (Cybersecurity)

1. **Role-Based Access Control (RBAC)**: Pemisahan ketat 15 level akses pengguna (Super Admin Yayasan, Kepala Sekolah, Bendahara, Wali Kelas, Guru, Santri, Orang Tua).
2. **Multi-Tenancy Scoping**: Isolasi data berbasis `school_id` mencegah kebocoran data antar-unit sekolah.
3. **API Token Sanctum**: Seluruh komunikasi data aplikasi mobile SDM terproteksi dengan token bearer `auth:sanctum`.
4. **Proteksi Injeksi & Form Hijacking**: Parameterized SQL queries via Eloquent ORM, sanitasi form XSS, dan validasi token CSRF wajib.
5. **Keamanan Dokumen TTE**: Integritas berkas diverifikasi menggunakan hash kriptografi SHA-256 dan token UUID publik.
6. **Validasi File Unggahan**: Pengecekan ekstensi (JPG, PNG, PDF) dan batas ukuran file maksimal 5 MB dengan penyimpanan terisolasi di disk private/public storage.

---

## 🚀 Panduan Deployment & Sinkronisasi Server

### 1. Sinkronisasi Cepat di Server cPanel / VPS:
Untuk memperbarui kode aplikasi di server produksi, masuk ke terminal SSH/cPanel dan jalankan:

```bash
cd /home/pesonaas/sitrobbani.sch.id
git stash
git pull origin main
php artisan optimize:clear
```

### 2. Setup Baru / Fresh Install:
```bash
# 1. Clone repository
git clone https://github.com/septaryanhidayat/smartedu.git

# 2. Salin environment dan sesuaikan konfigurasi database
cp .env.example .env
composer install --no-dev --optimize-autoloader

# 3. Generate key & symbolic link storage
php artisan key:generate
php artisan storage:link

# 4. Import struktur database produksi
# Buka phpMyAdmin -> Import file pesonaas_db_sitrobbani.sql atau smartedu_FINAL_sitrobbani.sql

# 5. Optimasi cache aplikasi
php artisan optimize:clear
php artisan optimize
```

---

## 🔑 Kredensial Akses Pengujian

* **URL Portal Utama**: `https://sitrobbani.sch.id`
* **URL SPMB Online**: `https://sitrobbani.sch.id/ppdb` atau `https://spmb.sitrobbani.sch.id`
* **URL Panel Admin**: `https://sitrobbani.sch.id/admin/login`
* **Email Super Admin**: `admin@smartedu.id`
* **Kata Sandi Default**: *(Dikelola aman oleh tim IT yayasan)*

> ⚠️ **Peringatan**: Selalu ubah kata sandi default dan amankan berkas `.env` pada lingkungan produksi.

---

## 📁 Struktur Direktori Utama

```
smartedu/
├── app/
│   ├── Http/Controllers/
│   │   ├── SchoolWebsiteController.php   ← Web publik, pendaftaran SPMB & cetak PDF 4 halaman
│   │   ├── Admin/CbtPpdbController.php   ← Manajemen pendaftar & verifikasi berkas admin
│   │   ├── Admin/CmsController.php       ← Manajemen konten profil & berita yayasan
│   │   └── Api/HrisMobileApiController.php ← REST API mobile SDM
│   └── Models/                           ← User, PpdbRegistration, Student, Bill, dll
├── resources/views/
│   ├── school/
│   │   ├── home.blade.php                ← Beranda portal multi-unit
│   │   ├── ppdb.blade.php                ← Formulir SPMB 5-step wizard interaktif
│   │   ├── spmb_pdf.blade.php            ← Template cetak formulir & 4 lampiran berkas
│   │   └── unit.blade.php                ← Halaman profil per unit (TKIT, SDIT, SMPIT, SMAIT)
│   └── admin/                            ← Tampilan dashboard & pengelolaan 23 modul
├── sdm-robbani-mobile/                   ← Source code aplikasi mobile React Native Expo SDK 52
├── database/                             ← Migrations, seeders, & SQLite dev
├── public/                               ← Assets web, icons, & build Vite terkompilasi
└── pesonaas_db_sitrobbani.sql            ← Database snapshot produksi
```

---

## 📄 Lisensi & Hak Cipta

Dikembangkan khusus untuk **[SIT Robbani Ogan Ilir](https://sitrobbani.sch.id)** oleh **[Beranda Teknologi Digital](https://berandadigital.net)**.  
© 2026 SmartEdu SIT Robbani. Hak Cipta Dilindungi Undang-Undang.
