# 🏫 SmartEdu SIT Robbani — Ekosistem Digital & SIM Sekolah Islam Terpadu

> **Platform Tata Kelola Pendidikan Terpadu, Web Portal Multi-Unit, Aplikasi Mobile SDM & Smart AI RAG Assistant**  
> **Yayasan Generasi Robbani Ogan Ilir, Sumatera Selatan**  
> *Versi: 3.0 — Pre-Production (Tahun Ajaran 2026/2027)*

---

## 🌟 Tentang SmartEdu SIT Robbani

**SmartEdu SIT Robbani** adalah platform ekosistem digital terpadu (*All-in-One Educational ERP, Multi-Unit Web Portal & Mobile SDM App*) yang dirancang khusus untuk memenuhi standar mutu **Jaringan Sekolah Islam Terpadu (JSIT)** dan **Kurikulum Merdeka**.

Platform ini mengintegrasikan **23+ Modul Digital Terpadu** yang menghubungkan seluruh tata kelola akademik, keuangan E-SPP, persuratan digital ber-TTE resmi, pembentukan karakter Islami (BPI Mutabaah), portal SPMB Online integratif, aplikasi mobile SDM (React Native Expo), dan Chatbot AI cerdas berbasis Retrieval-Augmented Generation (RAG).

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
1. **Master Data Multi-Unit**: Pengelolaan data Siswa, Guru, Kelas, dan Rombongan Belajar (Rombel).
2. **E-Rapor Kurikulum Merdeka & JSIT**: Penilaian Formatif/Sumatif, Capaian P5, & Cetak Rapor PDF Resmi.
3. **CBT Ujian & Asesmen Digital**: Pembuat Soal Pilihan Ganda & Essay, Timer, Acak Soal, dan Penilaian Otomatis.
4. **E-Learning LMS**: Materi pelajaran (Video/PDF), tugas siswa, & forum diskusi KBM.
5. **Jurnal Mengajar & Absensi Kelas**: Pengisian jurnal KBM harian guru & rekapitulasi kehadiran siswa.
6. **Tahfidz Tracker**: Monitoring halaqah, ziyadah, & murajaah Al-Qur'an siswa.

### 💰 2. Keuangan, POS & Cashless School
7. **E-SPP & Billing Otomatis**: Penagihan SPP bulanan otomatis, cetak kuitansi PDF resmi ber-QR, & akuntansi COA.
8. **Tabungan Siswa & Kantin Digital**: Setor/tarik tabungan siswa & transaksi non-tunai kantin sekolah.
9. **Penggajian & HRIS SDM (Payroll)**: Perhitungan gaji pokok, tunjangan, potongan absensi, & cetak Slip Gaji PDF.

### 🌙 3. Pembentukan Karakter & Layanan Sekolah
10. **Bina Pribadi Islam (BPI Mutabaah Yaumiyah)**: Pencatatan ibadah harian (Sholat 5 Waktu, Tilawah, Dhuha, Tahajjud).
11. **Bimbingan Konseling (BK Online)**: Pencatatan poin prestasi & pelanggaran siswa, booking konseling.
12. **Sarana Prasarana (Sarpras Barcode)**: Inventarisasi aset ruangan, barcode generator, & pemeliharaan barang.
13. **E-Library & Sirkulasi QR**: Katalog buku perpustakaan & peminjaman/pengembalian buku via QR.
14. **Asrama & Kepesantrenan**: Manajemen kamar santri boarding, perizinan keluar, & monitoring asrama.
15. **Klinik UKS & Rekam Medis**: Pencatatan riwayat kesehatan & penanganan medis siswa.
16. **Layanan Sewa Fasilitas & Kerjasama**: Formulir permohonan kunjungan & sewa gedung/lapangan.

### 🚀 4. Portal Publik, SPMB Online & Persuratan TTE
17. **Website Publik & Profil 4 Unit**: Portal resmi dengan dual logo, dark mode Obsidian/Neon Lime, jadwal sholat 16 kecamatan, & berita asli.
18. **Portal SPMB Online Integratif**: Formulir pendaftaran multi-step wizard, upload berkas, kartu ujian, & verifikasi QR.
19. **Persuratan Digital & QR TTE**: Draf surat keluar KOP resmi, disposisi pimpinan, hash SHA-256 & verifikasi publik (`/verifikasi-surat/{token}`).
20. **Portal Alumni & Tracer Study**: Direktori kelulusan alumni dan jejaring kampus.
21. **Portal Eksekutif Yayasan**: Dashboard konsolidasi metrik statistik 4 unit sekolah secara terpusat.

### 🤖 5. Layanan Cerdas & Mobile SDM
22. **Smart AI Assistant & Knowledge Base RAG (Modul 23)**: Chatbot AI cerdas 24/7 dengan Retrieval-Augmented Generation dari dokumen PDF resmi & live database SmartEdu.
23. **Aplikasi Mobile SDM SIT Robbani (Expo React Native)**: Presensi GPS & biometrik wajah, pengajuan cuti, slip gaji mobile, mutabaah SDM, & autentikasi aman Laravel Sanctum.

---

## 🛠️ Spesifikasi Teknologi (Tech Stack)

| Komponen | Spesifikasi / Pustaka | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 13.x** | PHP 8.4 (cPanel) / PHP 8.2+ (Lokal) |
| **Frontend Styling** | **Tailwind CSS & Vanilla CSS** | Mode Gelap Obsidian Emerald (`#061107`) & Neon Lime (`#c6f634`) |
| **Interaktivitas UI** | **Alpine.js 3.x & SweetAlert2** | State management reaktif tanpa library JS berat |
| **Asset Bundler** | **Vite 6.x** | Pre-built di `public/build/` siap produksi |
| **Basis Data** | **MySQL 5.7+ / MariaDB 10.3+** | 58 Tabel terstruktur InnoDB UTF-8 MB4 |
| **Mobile App** | **React Native (Expo SDK 52)** | Folder `sdm-robbani-mobile/` |
| **REST API Security** | **Laravel Sanctum Token** | Perlindungan Bearer Token pada seluruh endpoint `/api/v1/mobile/*` |
| **AI LLM Engine** | **Google Gemini 1.5 Flash API** | Mesin RAG dengan semantic document retrieval |
| **PDF & QR Engine** | **DomPDF & Simple QrCode** | Cetak Kuitansi SPP, Slip Gaji, Kartu Ujian, & Surat TTE |

---

## 🛡️ 7 Lapisan Keamanan Sistem (Cybersecurity Hardening)

1. **Auth & RBAC Guard**: Proteksi middleware `auth` dan pemisahan 15 hak akses pengguna.
2. **REST API Sanctum Guard**: Semua endpoint API mobile diproteksi `auth:sanctum` (kecuali login publik).
3. **Multi-Tenancy Scoping**: Strict isolation `school_id` mencegah akses silang data antar unit.
4. **SQL Injection Defense**: Parameter binding PDO via Eloquent ORM pada seluruh query.
5. **Cross-Site Scripting (XSS) & CSRF Defense**: Blade escaping, sanitasi input, & token CSRF wajib.
6. **Global Security Headers**: `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection`, `Referrer-Policy`.
7. **TTE Cryptographic Integrity**: Hash digital SHA-256 dan token UUID publik untuk verifikasi keaslian surat.

---

## 🚀 Panduan Deployment ke cPanel

Panduan lengkap deployment ke server cPanel tersedia pada dokumen:
📖 **[`DEPLOY_CPANEL.md`](./DEPLOY_CPANEL.md)**

### Ringkasan Langkah Cepat:
1. **Export Database MySQL Final**:
   Gunakan file: **[`scratch/mysql_FINAL_sitrobbani.sql`](./scratch/mysql_FINAL_sitrobbani.sql)** (58 tabel lengkap).
2. **Import Database di cPanel**:
   Buat database MySQL baru di cPanel $\rightarrow$ Buka **phpMyAdmin** $\rightarrow$ **Import** file `mysql_FINAL_sitrobbani.sql`.
3. **Deploy via Git Version Control cPanel**:
   Clone repository `https://github.com/septaryanhidayat/bigdata.git` ke folder `~/bigdata`.
4. **Konfigurasi DocumentRoot**:
   Arahkan DocumentRoot domain utama `sitrobbani.sch.id` ke subfolder: `public_html/` atau `~/bigdata/public`.
5. **Konfigurasi `.env`**:
   Salin template `.env.cpanel` menjadi `.env`, isi koneksi database MySQL cPanel.
6. **Jalankan Skrip Deploy Otomatis**:
   ```bash
   bash deploy.sh
   ```

---

## 🧪 Pengujian Otomatis (Automated Test Suite)

Sebelum setiap rilis, jalankan test suite otomatis berikut:

```bash
# 1. Uji seluruh fungsionalitas 14 modul inti
php scratch/test_all_features.php

# 2. Uji mesin AI RAG & integrasi Chatbot
php scratch/test_ai_rag_chatbot.php
```

---

## 🔑 Kredensial Pengujian Awal

* **URL Login Admin**: `https://sitrobbani.sch.id/admin/login` *(atau `http://localhost:8000/admin/login`)*
* **Email Super Admin**: `admin@smartedu.id` *(atau `ryan@sitrobbani.sch.id`)*
* **Kata Sandi**: `p4l3mb4ng`

---

## 📄 Lisensi & Hak Cipta

Didukung dan dikembangkan untuk **[SIT Robbani Ogan Ilir](https://sitrobbani.sch.id)** oleh **[Beranda Teknologi Digital](https://berandadigital.net)**.  
© 2026 SmartEdu SIT Robbani. Hak Cipta Dilindungi Undang-Undang.
