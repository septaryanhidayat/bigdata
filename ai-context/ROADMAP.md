# SmartEdu SIT Robbani — Product Roadmap

> *Riwayat Rilis & Rencana Pengembangan*  
> *Terakhir diperbarui: 18 Agustus 2026*

---

## ✅ FASE 1: Fondasi Awal (Agustus 2026, Minggu 1–2)

- [x] Laravel 13 + MySQL 58 tabel + setup multi-tenancy 4 unit
- [x] Autentikasi Laravel + 15 Peran RBAC
- [x] Dashboard Admin dengan statistik dasar
- [x] Master Data: Siswa, Guru, Kelas (CRUD + Excel import/export)
- [x] Modul Keuangan: E-SPP, Billing otomatis, Kuitansi QR PDF
- [x] Modul Tabungan Siswa & Kantin POS RFID
- [x] Presensi QR Code + RFID Gate + izin siswa
- [x] Akademik: Jadwal, Nilai, Rapor Digital Kurikulum Merdeka
- [x] E-Learning LMS + Jurnal KBM
- [x] BPI Mutabaah Yaumiyah siswa + pegawai
- [x] CBT Ujian Digital (bank soal, timer, penilaian otomatis)
- [x] Sarpras Inventaris Barcode + Library E-Catalog
- [x] BK Online (poin prestasi & pelanggaran siswa)
- [x] Payroll & HRIS: Slip Gaji PDF, data dossier pegawai
- [x] Persuratan Digital TTE SHA-256 + Disposisi + Verifikasi QR Publik
- [x] AI Knowledge Base RAG + Chatbot Gemini 1.5 Flash

---

## ✅ FASE 2: Website Publik & CMS (Agustus 2026, Minggu 2–3)

- [x] Website beranda utama yayasan (home.blade.php, 200KB)
- [x] Profil 4 Unit Sekolah (unit.blade.php, 94KB)
- [x] Halaman Berita & Artikel (index + single detail)
- [x] Halaman Fasilitas Sekolah per unit
- [x] SPMB Online Multi-Step (ppdb.blade.php, 64KB)
- [x] Kartu Ujian PDF + Verifikasi QR SPMB
- [x] Portal E-SPP Publik (`/e-spp`)
- [x] Chatbot AI Widget Publik
- [x] SEO: sitemap.xml, robots.txt, meta OG
- [x] Redirect 301 WordPress Legacy URLs

---

## ✅ FASE 3: Import Data Otentik WordPress (Agustus 2026, Minggu 3)

- [x] Import ratusan berita & artikel dari 4 backup XML WordPress
- [x] Auto-kategorisasi konten ke unit masing-masing (TKIT, SDIT, SMPIT, SMAIT, Yayasan)
- [x] Import 108 data guru dari backup XML (foto, gelar, jabatan)
- [x] Import galeri foto otentik per unit dari XML
- [x] Download & optimasi gambar ke WebP ≤50KB

---

## ✅ FASE 4: Aplikasi Mobile SDM (Agustus 2026, Minggu 3)

- [x] Expo React Native SDK 52 setup (`sdm-robbani-mobile/`)
- [x] Autentikasi Laravel Sanctum Bearer Token
- [x] Dashboard mobile: statistik pegawai, kehadiran, payroll
- [x] Presensi GPS + anti-fake geofence
- [x] Face recognition biometrik (Expo Camera)
- [x] Pengajuan izin & cuti
- [x] Slip Gaji & Payroll History
- [x] BPI Mutabaah mobile
- [x] Kantin Digital mobile
- [x] 20+ REST API endpoint `auth:sanctum`

---

## ✅ FASE 5: Keamanan & Hardening (Agustus 2026, Minggu 3–4)

- [x] Security Headers middleware (X-Frame, X-XSS, X-Content-Type)
- [x] CSRF protection (exception untuk import WordPress)
- [x] Multi-tenancy scoping strict di semua controller
- [x] Auto error logging ke `system_error_logs` + auto-mitigation
- [x] Filter konten terlarang (judol, pinjol, SARA, pornografi, dll)
- [x] `.gitignore` menutup `.env`, `*.sqlite`, `scratch/`, `node_modules`

---

## ✅ FASE 6: UX Polish & Dark Mode (Agustus 2026, Minggu 4)

- [x] Dark mode Obsidian (#040d06) + Neon Lime (#c6f634) di semua halaman publik
- [x] Alpine.js pagination CMS berita (10 per halaman)
- [x] Filter unit berita di CMS Admin (pill buttons)
- [x] Tombol tambah berita high-contrast readable
- [x] Share berita 8 platform sosmed dengan icon SVG
- [x] Copy link SVG icon (bukan font Material Symbols yang buggy)
- [x] Animasi micro-interaction: float, pulse-glow, hover lift

---

## ✅ FASE 7: Profil Yayasan & CMS Tab Baru (18 Agustus 2026)

- [x] Halaman profil yayasan dirombak ulang: layout vertikal (tidak pakai tab)
- [x] Seksi: Hero → Sambutan Ketua → Visi Misi → 5 Pilar → Struktur (Ketua saja) → 4 Unit
- [x] Tab CMS Admin "🏛️ Profil Yayasan" — form edit penuh semua konten
- [x] `updateFoundationProfile()` di CmsController (route POST)
- [x] Struktur pengurus hanya menampilkan Ketua Yayasan (Sughesti Wulandari, S.Pd)
- [x] Upgrade gambar berita ke HD 1200px WebP tajam
- [x] Export penuh SQLite → MySQL: `smartedu_FINAL_sitrobbani.sql` (2.14MB, 58 tabel)

---

## 🔧 FASE 8: Deployment cPanel (Target: Agustus–September 2026)

- [ ] Import `smartedu_FINAL_sitrobbani.sql` ke MySQL cPanel
- [ ] Setup `.env` produksi (MySQL credentials, MAIL SMTP)
- [ ] `php artisan key:generate` + optimize
- [ ] Set DocumentRoot ke `~/bigdata/public`
- [ ] Setup subdomain: `spmb.`, `tk.`, `sd.`, `smp.`, `sma.sitrobbani.sch.id`
- [ ] SSL/TLS certificate (cPanel AutoSSL)
- [ ] Smoke test semua modul di produksi

---

## 🚀 FASE 9: Coming Soon (2026 Q4)

- [ ] **Notifikasi WhatsApp Gateway** (Fonnte/WA Cloud API) — tagihan SPP, presensi, pengumuman
- [ ] **Portal Orang Tua** (web/mobile view) — cek nilai, presensi, SPP anak
- [ ] **Tracer Study Alumni** — direktori alumni, tracking kampus
- [ ] **E-Voting** — pemilihan pengurus OSIS, ketua kelas
- [ ] **Inventaris Asrama** — manajemen kamar santri boarding
- [ ] **UKS & Rekam Medis** — riwayat kesehatan siswa
- [ ] **Push Notification** (Expo Notifications) — pengumuman penting ke mobile
- [ ] **Payment Gateway** — integrasi Midtrans/Xendit untuk bayar SPP online
