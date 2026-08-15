# 🏫 SmartEdu - Platform Ekosistem Digital & Sistem Informasi Manajemen Sekolah Islam Terpadu

![SmartEdu Banner](public/images/og_share_image.png)

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Security Status](https://img.shields.io/badge/Security-7--Layer%20Protected-emerald?style=for-the-badge)](#-keamanan--audit-sistem)

**SmartEdu** adalah platform ekosistem digital terpadu dan sistem informasi manajemen sekolah yang dirancang khusus untuk **Sekolah Islam Terpadu (SIT Robbani Ogan Ilir)**. Platform ini mengintegrasikan **21 Modul Digital Terpadu** yang menghubungkan tata kelola akademik, keuangan E-SPP, kurikulum Merdeka & JSIT, pembentukan karakter Islami (BPI Mutabaah), portal SPMB Online integratif, hingga sistem perlindungan keamanan data 7-lapis.

---

## 🌟 Fitur Utama & 21 Modul Digital Terpadu

SmartEdu mencakup 21 modul operasional yang saling terhubung secara *real-time*:

### 📚 1. Akademik, CBT & Kurikulum Adaptif
1. **Modul 1: Presensi RFID Real-Time (Siswa & Guru)**: Realtime Tap RFID, pencatatan jam masuk & keluar, rekapitulasi presensi bulanan.
2. **Modul 4: E-Rapor Kurikulum Merdeka & JSIT**: Penilaian Formatif/Sumatif, Capaian Proyek P5, & Karakter JSIT dengan cetak Rapor PDF Resmi.
3. **Modul 5: CBT Online (Ujian & Asesmen Digital)**: Pembuat Soal Pilihan Ganda & Essay, Timer Ujian, Acak Soal, Nilai Otomatis, & Analisis Butir Soal.
4. **Modul 10: Perpustakaan Digital (E-Library & QR Sirkulasi)**: Katalog ISBN, pinjam/kembali buku via QR-Code, denda keterlambatan, & PDF e-book reader.
5. **Modul 11: E-Learning LMS**: Modul materi (Video/PDF), pengumpulan tugas siswa, forum diskusi KBM, & link Live Class.
6. **Modul 13: Jurnal Mengajar & Absensi Guru**: Pengisian jurnal KBM harian, topik pembelajaran, & absensi jam mengajar.

### 💰 2. Keuangan, POS & Cashless School
7. **Modul 2: E-SPP & Keuangan Sekolah**: Penagihan SPP bulanan otomatis, cetak kuitansi PDF, Akuntansi COA Kas & Bank, & Laporan Jurnal Keuangan.
8. **Modul 3: Tabungan Siswa & Kantin Cashless (SmartCard)**: Setor/Tarik tabungan siswa, top-up saldo SmartCard, & transaksi kantin tanpa uang tunai (potong saldo RFID).
9. **Modul 15: Penggajian & HRD Guru/Staf (Payroll)**: Perhitungan gaji pokok, tunjangan jabatan, potongan absensi, & Slip Gaji PDF.

### 🌙 3. Character Building, BK & Layanan Sekolah
10. **Modul 7: Bina Pribadi Islami (BPI Mutabaah Yaumiyah)**: Tracking ibadah harian (Sholat 5 Waktu, Tilawah, Dhuha, Puasa Sunnah) & skor nilai BPI.
11. **Modul 8: Bimbingan Konseling (BK Online)**: Recording poin pelanggaran & prestasi siswa, booking sesi konseling guru BK, & log foto home visit.
12. **Modul 9: Sarana Prasarana (Sarpras Barcode & Floorplan)**: Pencatatan aset sekolah, barcode generator aset, mutasi ruang, & status fisik barang.
13. **Modul 14: Manajemen Ekstrakurikuler & Prestasi**: Pendaftaran ekskul, absensi ekskul, input prestasi lomba (Juara 1/2/3), & sertifikat digital.
14. **Modul 19: Inventaris Alat Laboratorium**: Pencatatan alat praktikum IPA/TIK & status kelayakan pakai.
15. **Modul 21: Layanan Sewa Fasilitas & Kunjungan Tamu**: Buku tamu digital & permohonan pinjam/sewa aula & lapangan olahraga.

### 🚀 4. SPMB Online, Parent Portal & Gateway Integration
16. **Modul 6: Portal SPMB Online Integratif**: 
    - **Multi-Step Stepper Wizard**: 5 Langkah pendaftaran interaktif dengan indikator persentase & auto-save draft (`localStorage`).
    - **Upload File Berkas Persyaratan**: Upload Pas Foto, KTP Ortu, Kartu Keluarga (KK), & Bukti Transfer Pembayaran.
    - **Ringkasan Pratinjau Final**: Step 5 summary grid untuk pemeriksaan data sebelum submit.
    - **QR Code Dinamis & Re-Download PDF (`/spmb/verify/{regNumber}`)**: Scan QR Code untuk verifikasi & download ulang dokumen PDF kapan saja.
    - **Integrasi Akun Wali (Sibling Linkage)**: Menghubungkan pendaftaran ananda baru ke 1 akun Wali Murid (Parent Portal).
    - **Strict Input Regex Validation**: Format nama (huruf), NIK (16 digit), WA (10-15 digit), Email, & Biaya Pendaftaran Otomatis per unit (TKIT: 200k, SDIT: 250k, SMPIT: 300k, SMAIT: 350k).
17. **Modul 12: Portal Wali Murid (Parent Mobile App Simulator)**: Pemantauan multi-anak (sibling linkage), laporan nilai, presensi, & pembayaran SPP.
18. **Modul 16: Pengumuman & Broadcast WhatsApp Gateway**: Kirim pengumuman massal & notifikasi SPP/SPMB ke WhatsApp Orang Tua.
19. **Modul 20: Portal Alumni & Tracer Study**: Direktori kelulusan alumni, jejaring PTN, & dudi.

### ⚙️ 5. Manajemen Yayasan, RBAC & Security Audit
20. **Modul 17: Pengaturan Hak Akses (RBAC & Multi-Role)**: Manajemen akun Admin, Kepsek, Guru, Bendahara, BK, & Ortu.
21. **Modul 18: Executive Summary & Audit Logs**: Dashboard eksekutif statistik yayasan, log perubahan data, & otomatisasi penanganan error log (`SystemErrorLog`).

---

## 🔄 Otomatisasi Alur Kerja Cross-Module

Saat Panitia SPMB mengubah status pendaftar menjadi **`LULUS` (`PASSED`)** pada Admin Portal (`/admin/ppdb-admin`):
1. **Otomatisasi Master Data Siswa**: Menerbitkan data `Student` baru (NIS, NISN, Tag RFID, Saldo Awal SmartCard Rp 100.000).
2. **Otomatisasi Parent Portal**: Menghubungkan akun Wali Murid (`ParentModel`) sesuai nomor HP/Email pendaftar.
3. **Otomatisasi Keuangan E-SPP**: Menerbitkan Tagihan SPP Awal (`SppBill`) bulan berjalan secara otomatis di Modul Keuangan.

---

## 🛠️ Spesifikasi Teknologi (Tech Stack)

* **Framework Core**: Laravel 13.x
* **Bahasa Pemrograman**: PHP 8.4+ / PHP 8.3
* **Frontend UI/UX**: Vanilla HTML5, TailwindCSS, Alpine.js (Light Mode High-Contrast & Obsidian Neon Lime Dark Mode)
* **Asset Bundler**: Vite
* **Database**: MySQL 8.0+ / MariaDB / SQLite
* **Branding Assets**: Dynamic Dual-Logo (`logo_light` & `logo_dark`) tanpa terpotong (`object-contain`).

---

## 🛡️ Keamanan & Audit Sistem

Sistem diproteksi oleh **7 Lapisan Keamanan (Security Guard)**:
1. **Auth & RBAC Guard**: Proteksi middleware `auth` pada seluruh rute administratif `/admin/*`.
2. **SQL Injection Guard**: Parameter binding PDO via Eloquent ORM & Query Builder.
3. **Cross-Site Scripting (XSS) Guard**: Encoding entitas HTML Blade `{{ }}` & regex sanitization input.
4. **CSRF Protection**: Token `@csrf` & middleware `ValidateCsrfToken` aktif di seluruh formulir.
5. **File Upload Security**: Pembatasan MIME (`jpg,jpeg,png,pdf`), Max Size 5MB, & Random Filename.
6. **IDOR Security**: String acak unik pendaftaran (`SPMB-2026-SDIT-XXXXX`) pada QR Code & PDF.
7. **System Error Mitigation**: Capturing log error terotomatisasi (`SystemErrorLog`).

---

## 🚀 Panduan Instalasi Lokal (Development)

1. **Clone Repository**:
   ```bash
   git clone https://github.com/username/smartedu.git
   cd smartedu
   ```

2. **Install Dependensi Composer & NPM**:
   ```bash
   composer install
   npm install
   ```

3. **Pengaturan File `.env`**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seed Database**:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Aset & Jalankan Server**:
   ```bash
   npm run build
   php artisan serve
   ```

---

## 🔑 Kredensial Default Portal Admin CMS

* **URL Login**: `http://localhost:8000/admin/login` *(atau `https://domainanda.com/admin/login`)*
* **Username / Email**: `admin` *(atau `admin@smartedu.test`)*
* **Password**: `p4l3mb4ng`

---

## 📄 Lisensi & Pengembang

Didukung dan Dikembangkan untuk **[SIT Robbani Ogan Ilir](https://sitrobbani.sch.id)** oleh **[Beranda Teknologi Digital](https://berandadigital.net)**.
© 2026 SmartEdu. Hak Cipta Dilindungi Undang-Undang.
