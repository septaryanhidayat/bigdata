# SmartEdu SIT Robbani — Product Requirements Document (PRD)

> *Versi 3.0 Final — 18 Agustus 2026*

---

## 1. Ringkasan Eksekutif

SmartEdu SIT Robbani adalah platform ERP pendidikan Islam terpadu yang mencakup:
- **Website publik multi-unit** dengan CMS admin penuh
- **Dashboard administrasi** dengan 15 peran RBAC
- **Aplikasi mobile SDM** berbasis Expo React Native
- **Smart AI Chatbot** berbasis Gemini RAG
- **Database MySQL 58 tabel** dengan multi-tenancy ketat

---

## 2. Fitur Fungsional — 23 Modul

### 🌐 MODUL 1: Website Publik & CMS Multi-Unit

| Fitur | Detail | Status |
|-------|--------|--------|
| Halaman Beranda Yayasan | Hero, berita, video, galeri, testimoni, jadwal sholat | ✅ |
| Profil 4 Unit Sekolah | KB/TKIT, SDIT, SMPIT, SMAIT dengan konten berbeda | ✅ |
| Halaman Profil Yayasan | Sambutan ketua, visi misi, 5 pilar, struktur | ✅ |
| Berita & Artikel | Filter unit, pagination, single page, share sosmed 8 platform | ✅ |
| Galeri Foto | Carousel per unit, galeri gabungan web utama | ✅ |
| Video YouTube | Slider dengan filter per unit | ✅ |
| Dark Mode | Obsidian (#040d06) + Neon Lime (#c6f634) | ✅ |
| CMS Admin - Tab Profil Yayasan | Form edit nama, ketua, visi misi, sambutan | ✅ NEW |
| Filter Konten Terlarang | Auto-filter: judol, pinjol, SARA, kekerasan, pornografi | ✅ |
| SEO Lengkap | sitemap.xml, robots.txt, meta OG, title per halaman | ✅ |

### 📋 MODUL 2–4: SPMB Online, CBT, Master Data

| Fitur | Detail | Status |
|-------|--------|--------|
| SPMB Online Multi-Step | Formulir 4 langkah, upload berkas, kartu ujian PDF | ✅ |
| Verifikasi QR Surat/Kartu | `/spmb/verify/{regNumber}`, scan QR | ✅ |
| CBT Ujian Digital | Bank soal, timer, pengacakan, penilaian otomatis | ✅ |
| Master Data Siswa | CRUD + import Excel, NIS, foto, kelas | ✅ |
| Master Data Guru | CRUD + export, NUPTK, jabatan fungsional | ✅ |
| Multi-tenancy Kelas | Isolasi per unit sekolah (school_id) | ✅ |

### 💰 MODUL 5–7: Keuangan, Tabungan, Kantin

| Fitur | Detail | Status |
|-------|--------|--------|
| E-SPP & Billing | Generate tagihan otomatis, bayar, kuitansi QR PDF | ✅ |
| Cek Tagihan Publik | `/e-spp` tanpa login | ✅ |
| Tabungan Siswa | Setor/tarik, saldo realtime | ✅ |
| POS Kantin | Multi-outlet, produk, kasir, transaksi RFID | ✅ |

### 📚 MODUL 8–11: Akademik & E-Learning

| Fitur | Detail | Status |
|-------|--------|--------|
| Presensi QR & RFID | Tap RFID gate, QR siswa, rekap kehadiran | ✅ |
| Jurnal KBM Harian | Input guru per kelas/mapel | ✅ |
| Jadwal Pelajaran | CRUD per unit, per semester | ✅ |
| E-Learning LMS | Upload materi PDF/video, tugas, link | ✅ |
| Rapor Digital | Input nilai, rapor PDF per siswa, rekap KM | ✅ |

### 🕌 MODUL 12: BPI & Mutabaah

| Fitur | Detail | Status |
|-------|--------|--------|
| Mutabaah Yaumiyah Siswa | Sholat 5 waktu, tilawah, puasa, dhuha | ✅ |
| Mutabaah Pegawai (Mobile) | Halaqah BPI, meeting, mutabaah harian | ✅ |

### 👔 MODUL 13: HRIS, Payroll & Dossier Pegawai

| Fitur | Detail | Status |
|-------|--------|--------|
| Database Induk Pegawai | NIK, NUPTK, jabatan, foto, dokumen | ✅ |
| E-Berkas Dossier | CV, ijazah, SK, sertifikat digital | ✅ |
| Payroll & Slip Gaji | Hitung gaji, tunjangan, cetak PDF | ✅ |
| Absensi GPS (Mobile) | Check-in/out dengan anti-fake GPS | ✅ |
| Biometrik Wajah (Mobile) | Face enrollment, check-in face recognition | ✅ |

### 🏢 MODUL 14–16: Sarpras, Library, BK

| Fitur | Detail | Status |
|-------|--------|--------|
| Inventaris Sarpras | CRUD aset, barcode, kategori, kondisi | ✅ |
| E-Library | Katalog buku, sirkulasi QR pinjam/kembali | ✅ |
| BK Online | Poin prestasi/pelanggaran, booking konseling | ✅ |

### 📝 MODUL 17: Persuratan Digital & TTE

| Fitur | Detail | Status |
|-------|--------|--------|
| Surat Masuk & Disposisi | Agenda surat, disposisi antar pejabat | ✅ |
| Surat Keluar & Draft | Draft engine dengan KOP unit, template baku | ✅ |
| TTE Digital SHA-256 | Hash kriptografi, UUID token, QR verifikasi | ✅ |
| Verifikasi Publik | `/verifikasi-surat/{token}` scan QR tanpa login | ✅ |

### 🤖 MODUL 20–21: AI & Mobile

| Fitur | Detail | Status |
|-------|--------|--------|
| AI Knowledge Base | Upload PDF, training RAG, sync auto | ✅ |
| Chatbot AI Publik | Widget di website, context-aware, anti-halusinasi | ✅ |
| API Mobile Sanctum | 20+ endpoint Bearer Token, login, dashboard | ✅ |
| Aplikasi Expo React Native | Folder `sdm-robbani-mobile/` | ✅ |

---

## 3. Non-Functional Requirements (NFR)

| NFR | Spesifikasi |
|-----|-------------|
| **Keamanan** | 7 lapisan (Auth, Sanctum, Multi-Tenancy, ORM, XSS/CSRF, Security Headers, TTE SHA-256) |
| **Performa** | Halaman publik < 3 detik, API mobile < 500ms |
| **Kompatibilitas** | Chrome/Firefox/Safari terbaru, Android 8+, iOS 14+ |
| **Aksesibilitas** | Responsif mobile-first, font readable, kontras warna WCAG |
| **Backup** | Database SQLite dev (excluded git), MySQL prod (file SQL 2MB+) |
| **SEO** | sitemap.xml otomatis, meta OG lengkap, robots.txt benar |

---

## 4. 15 Peran RBAC (Role-Based Access Control)

| Peran | Kode | Akses Utama |
|-------|------|-------------|
| Super Admin | `SUPER_ADMIN` | Akses penuh semua unit |
| Ketua Yayasan | `YAYASAN_CHAIRMAN` | Dashboard konsolidasi, persetujuan TTE |
| Kepala Sekolah | `HEADMASTER` | Semua modul unit sendiri |
| Staf TU | `STAFF_TU` | CMS, persuratan, master data |
| Guru | `TEACHER` | Nilai, jurnal, LMS, BK |
| Guru BK | `GURU_BK` | BK, presensi |
| Guru Musyrif | `MUSYRIF_ASRAMA` | BPI, mutabaah |
| Bendahara | `STAFF_KEUANGAN` | SPP, tabungan, kantin, payroll |
| Petugas Sarpras | `PETUGAS_SARPRAS` | Sarpras |
| Petugas Perpustakaan | `PETUGAS_PERPUS` | Library |
| Petugas Kantin | `PETUGAS_KANTIN` | Kantin POS |
| Panitia PPDB | `PANITIA_PPDB` | PPDB, CBT |
| Wali Murid | `WALI_MURID` | *Coming Soon: portal ortu* |
| Siswa | `SISWA` | *Coming Soon: portal siswa* |
| Alumni | `ALUMNI` | *Coming Soon: tracer study* |
