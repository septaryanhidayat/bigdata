# SmartEdu SIT Robbani — Product Requirements Document (PRD)

> **Document Version:** 3.0  
> **Status:** Pre-Production — Deployment cPanel Pending  
> **Scope:** Web Portal, Mobile Web, Admin ERP, Mobile App API, Multi-Tenancy Subsystems, AI Engine  
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 🎯 1. Tujuan Produk (*Product Goals*)
1. **Mengintegrasikan 4 Unit Sekolah:** Menghilangkan silo data antara TKIT, SDIT, SMPIT, dan SMAIT dalam satu naungan database terpadu.
2. **Transformasi Layanan Publik:** Memberikan pengalaman modern, cepat, dan terpercaya bagi calon wali murid melalui website responsif, registrasi SPMB instan, dan asisten AI 24/7.
3. **Efisiensi Administrasi 100% Digital:** Mengotomatiskan persuratan ber-KOP resmi, Tanda Tangan Elektronik (TTE) ber-QR publik, penagihan E-SPP, kuitansi digital, dan rapor kurikulum merdeka.
4. **Keamanan & Kedaulatan Data:** Perlindungan dari ancaman siber (SQL Injection, CSRF, XSS, Clickjacking) dan penguncian data multi-tenancy.

---

## 👥 2. Matriks Pengguna & Role-Based Access Control (15 Peran)

| Role Code | Nama Peran | Hak Akses & Tanggung Jawab Utama |
| :--- | :--- | :--- |
| `SUPER_ADMIN` | Super Admin IT | Seluruh menu & modul sistem, kelola user, CMS yayasan, database backup, setting global. |
| `YAYASAN_CHAIRMAN` | Ketua Yayasan | Dashboard eksekutif konsolidasi 4 unit, persetujuan TTE yayasan, monitoring keuangan global. |
| `HEADMASTER` (TKIT) | Kepala Sekolah TKIT | Manajemen akademik, guru, siswa, penilaian, persuratan & TTE unit TKIT. |
| `HEADMASTER` (SDIT) | Kepala Sekolah SDIT | Manajemen akademik, guru, siswa, penilaian, persuratan & TTE unit SDIT. |
| `HEADMASTER` (SMPIT) | Kepala Sekolah SMPIT | Manajemen akademik, guru, siswa, asrama boarding, penilaian, TTE unit SMPIT. |
| `HEADMASTER` (SMAIT) | Kepala Sekolah SMAIT | Manajemen akademik, guru, siswa, asrama boarding, program sains/IT, TTE unit SMAIT. |
| `STAFF_TU` | Tata Usaha (TU) | Manajemen data siswa/guru, agenda surat masuk/keluar, draf TTE, **CMS Profil & Berita Unit**. |
| `STAFF_KEUANGAN` | Bendahara / Keuangan | Pembuatan invoice tagihan SPP bulanan/tahunan, kasir POS kas keluar-masuk, cetak kuitansi PDF. |
| `GURU` | Dewan Guru | Absensi kelas, input nilai rapor, materi e-learning (LMS), tugas & bank soal. |
| `GURU_BK` | Guru Bimbingan Konseling | Catatan konseling pribadi siswa, rekap poin pelanggaran dan poin prestasi santri. |
| `MUSYRIF` | Pembina Asrama / BPI | Mutabaah yaumiyah (sholat, tilawah), monitoring halaqah tahfidz asrama, perizinan santri. |
| `PUSTAKAWAN` | Pustakawan | Katalog buku E-Library, sirkulasi peminjaman/pengembalian RFID, denda keterlambatan. |
| `KASIR_KANTIN` | Kasir Kantin RFID | Transaksi POS kantin non-tunai, pengecekan saldo dompet digital siswa. |
| `PANITIA_PPDB` | Panitia PPDB & CBT | Verifikasi berkas pendaftar baru, jadwal tes CBT, pengumuman hasil seleksi online. |
| `SARPRAS` | Petugas Sarpras & Aset | Inventarisasi aset ruangan, jadwal pemeliharaan barang, permohonan sewa fasilitas. |

---

## 🛠️ 3. Kebutuhan Fungsional per Modul (*Functional Requirements*)

### FR-01: Website Publik & CMS 4 Unit
- Homepage interaktif dengan dark/light mode toggle (warna mode gelap: `#061107` Obsidian Green dan `#c6f634` Neon Lime).
- Widget Jadwal Sholat Realtime untuk 16 Kecamatan Ogan Ilir & seluruh provinsi Indonesia dengan kompas kiblat dan waktu otomatis.
- Tampilan detail berita 2-kolom desktop (konten lebar di kiri, widget pencarian, kategori, arsip, dan unit switcher di kanan) dan mobile 1-kolom rapi.
- Halaman profil unit (`/unit/tkit`, `/unit/sdit`, `/unit/smpit`, `/unit/smait`) yang menampilkan berita riil khusus unit tersebut.

### FR-02: SPMB Online & CBT Masuk
- Formulir pendaftaran multi-step online dengan upload berkas (KK, Akta, Pas Foto).
- Pembuatan nomor pendaftaran unik otomatis.
- CBT tes potensi akademik dan baca Qur'an terintegrasi dengan kalkulasi skor otomatis.

### FR-03: Keuangan E-SPP & Kuitansi PDF
- Tagihan multi-pos (SPP, Uang Gedung, Uang Makan, Kegiatan).
- Cetak Kuitansi Resmi PDF dengan barcode/QR verifikasi status lunas.
- Integrasi riwayat pembayaran untuk wali murid.

### FR-04: Persuratan Resmi & Tanda Tangan Elektronik (TTE)
- Pembuatan draf surat keluar ber-KOP resmi unit sekolah / yayasan.
- Alur disposisi dan verifikasi pimpinan.
- Penandatanganan digital dengan pembentukan SHA-256 secure hash dan token UUID publik (`/verifikasi-surat/{token}`).

### FR-05: API Mobile SDM (Sanctum Auth)
- Endpoint `/api/v1/mobile/auth/login` untuk autentikasi pegawai dengan token Sanctum.
- Semua endpoint non-login di-protect `auth:sanctum` middleware.
- Fitur: presensi GPS/face, payroll, BPI mutabaah, kantin, KPI, pengumuman.
- Response format JSON konsisten dengan field `success`, `data`, `message`.

### FR-06: Smart AI Chatbot RAG (Modul 23)
- Ekstraksi teks dari file PDF (Brosur, SOP, Kurikulum) ke tabel `ai_knowledge_bases`.
- Algoritma pencarian semantik (*Retrieval-Augmented Generation*) untuk menyertakan cuplikan dokumen asli saat menjawab.
- Integrasi data live database SmartEdu (Tahun Ajaran, Unit, kontak admin).
- Widget chat melayang dengan quick suggestion chips.
- Respon AI ditampilkan dengan typing animation karakter per karakter.

---

## 🔒 4. Kebutuhan Non-Fungsional (*Non-Functional Requirements*)

1. **Keamanan (*Cybersecurity*):**
   - Perlindungan SQL Injection via Eloquent Parameterized Query / PDO Prepared Statements.
   - Global Security Headers (`X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection`, `Referrer-Policy`).
   - Proteksi CSRF pada semua form dan endpoint state-changing.
   - **API Mobile:** Semua endpoint `/api/v1/mobile/*` (kecuali `/auth/login`) dilindungi `auth:sanctum` middleware.
   - Upload file: validasi tipe MIME dan ukuran, simpan di `storage/app/public/`.
2. **SEO & Kemudahan Indeks Google:**
   - Dynamic XML Sitemap (`/sitemap.xml`) dengan tag Google Image, lastmod, dan priority.
   - Dynamic `robots.txt` (`/robots.txt`).
   - 301 Permanent Redirect Handler untuk URL warisan WordPress (`/{year}/{month}/{day}/{slug}`, `/category/{cat}`, `/tag/{tag}`).
   - Structured data Schema.org JSON-LD (`NewsArticle`, `EducationalOrganization`, `WebSite`).
3. **Performa & Animasi:**
   - Snappy Fast Fade-Up Scroll Animation (durasi 0.4s) dengan IntersectionObserver responsif.
   - Kompresi aset gambar (<100KB per aset).
4. **Mobile First:**
   - 100% responsif pada layar smartphone (360px - 480px), tablet, dan desktop tanpa layout overflow/stacked bug.
