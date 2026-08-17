# SmartEdu SIT Robbani — Project Overview

> **Platform Ekosistem Digital Pendidikan Islam Terpadu & Tata Kelola Sekolah Terintegrasi (23+ Modul Digital Terpadu)**  
> **Yayasan Generasi Robbani Ogan Ilir, Sumatera Selatan**  
> *Versi Rilis: 3.0 — Pre-Production (Tahun Ajaran 2026/2027)*  
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 🌟 1. Visi & Misi Produk

**SmartEdu SIT Robbani** adalah platform manajemen sekolah terpadu (*All-in-One Educational ERP & Public Web Portal*) yang menggabungkan:
1. **Website Publik & Branding Modern:** Portal resmi yayasan dan 4 unit pendidikan dengan desain modern, responsive mobile-first, dark mode (Obsidian Emerald + Electric Lemon), jadwal sholat realtime, kalender Hijriyah, integrasi berita WordPress asli, video YouTube resmi, dan mesin SEO Google otomatis.
2. **Dashboard Administrasi Sekolah Terpadu (15 Peran):** Mengatur seluruh operasional akademik, keuangan, kepegawaian, sarana prasarana, kesiswaan, perpustakaan, hingga bimbingan konseling di bawah 1 payung database multi-tenancy.
3. **Smart AI Assistant & Knowledge Base RAG (Modul 23):** Asisten cerdas 24/7 berbasis Retrieval-Augmented Generation yang mampu membaca dokumen PDF resmi (Brosur SPMB, SOP, Kurikulum Tahfidz) dan data live SmartEdu untuk melayani calon wali murid tanpa halusinasi.
4. **Aplikasi Mobile SDM (React Native Expo):** Aplikasi `sdm-robbani-mobile` untuk manajemen SDM: presensi GPS/face recognition, payroll, BPI mutabaah, kantin digital.

---

## 🏛️ 2. Struktur Organisasi Multi-Tenancy (4 Unit + Yayasan)

| Unit | Kode | school_id | Kepala |
|------|------|-----------|--------|
| Yayasan Generasi Robbani | YAYASAN | null | Sughesti Wulandari, S.Pd (Ketua Yayasan) |
| KB/TKIT Robbani | TKIT | 1 | Ani Oktar Yansi, S.Pd.I |
| SDIT Robbani | SDIT | 2 | Nur Amalia, S.Pd |
| SMPIT Robbani | SMPIT | 3 | Tia Wulandari, S.Pd., Gr. |
| SMAIT Robbani | SMAIT | 4 | (Dalam Persiapan) |

Setiap unit memiliki isolasi data yang ketat (*Multi-Tenancy Unit Scoping*), di mana akun staf TU atau Kepala Sekolah hanya dapat mengelola data unitnya sendiri tanpa kebocoran data antar-unit.

---

## 📦 3. Ringkasan Ekosistem 23+ Modul Digital

| No | Modul | Status |
|----|-------|--------|
| 1 | Website Profil & CMS 4 Unit Terpadu | ✅ Live |
| 2 | SPMB Online & Verifikasi Berkas Digital | ✅ Live |
| 3 | CBT Ujian Masuk & Seleksi Siswa Baru | ✅ Live |
| 4 | Master Data Multi-Unit (Siswa, Guru, Kelas) | ✅ Live |
| 5 | E-SPP, Billing Otomatis & Gateway Pembayaran | ✅ Live |
| 6 | Kasir POS & Dompet Digital Siswa (RFID Ready) | ✅ Live |
| 7 | Buku Tabungan & Simpanan Siswa Realtime | ✅ Live |
| 8 | Presensi QR Code, RFID & Geo-Location | ✅ Live |
| 9 | Jurnal Mengajar, Silabus & Jadwal Pelajaran | ✅ Live |
| 10 | E-Learning (LMS) & Bank Soal CBT Siswa | ✅ Live |
| 11 | Rapor Digital & Rekap Nilai Kurikulum Merdeka | ✅ Live |
| 12 | Bina Pribadi Islam (BPI) & Mutabaah Yaumiyah | ✅ Live |
| 13 | Tahfidz Tracker (Halaqah, Ziyadah & Murajaah) | ✅ Live |
| 14 | Bimbingan Konseling (BK), Prestasi & Pelanggaran | ✅ Live |
| 15 | E-Library & Sirkulasi Buku Otomatis | ✅ Live |
| 16 | Manajemen Asrama & Kamar Siswa Boarding | ✅ Live |
| 17 | Klinik UKS & Rekam Medis Kesehatan Siswa | ✅ Live |
| 18 | HRIS, Data Pegawai & Penggajian (Payroll) | ✅ Live |
| 19 | Sarana Prasarana (Sarpras) & Booking Fasilitas | ✅ Live |
| 20 | Persuratan Digital, Disposisi & QR TTE Resmi | ✅ Live |
| 21 | Portal Eksekutif Yayasan (Dashboard Konsolidasi) | ✅ Live |
| 22 | Notifikasi WhatsApp Gateway Terpadu | 🔧 Coming Soon |
| 23 | Smart AI Chatbot & Knowledge Base RAG | ✅ Live |

---

## 🎯 4. Target Pengguna (Stakeholders)
- **Calon Wali Murid & Publik:** Pendaftaran SPMB, konsultasi chatbot AI, cek pengumuman & berita.
- **Wali Murid Aktif:** Cek tagihan E-SPP, pantau hafalan Tahfidz, mutabaah, rapor, dan presensi anak.
- **Guru & Wali Kelas:** Input nilai rapor, buat tugas LMS, absensi kelas, jurnal mengajar.
- **Staf Tata Usaha (TU):** Kelola persuratan, buku agenda, CMS berita/profil unit.
- **Bendahara Keuangan:** Kelola pos tagihan SPP, kuitansi PDF ber-QR, rekap kas harian.
- **Kepala Sekolah & Ketua Yayasan:** Monitoring capaian akademik, disposisi surat masuk, persetujuan TTE, dan audit keuangan multi-unit.

---

## 📚 5. Indeks Dokumen Master di `ai-context/`

| Dokumen | Tautan | Deskripsi |
| :--- | :--- | :--- |
| **Project Overview** | [`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md) | Visi, cakupan sistem, hierarki 4 unit, dan stakeholder |
| **Product Requirements** | [`PRD.md`](./PRD.md) | Kebutuhan fungsional 23 modul, 15 peran RBAC, dan NFR |
| **Tech Stack** | [`TECH_STACK.md`](./TECH_STACK.md) | Spesifikasi teknologi PHP 8.4, Laravel 13, MySQL, Vite, Expo |
| **System Architecture** | [`ARCHITECTURE.md`](./ARCHITECTURE.md) | Diagram sistem, multi-tenancy, siklus TTE, deployment cPanel |
| **Database Schema** | [`DATABASE_SCHEMA.md`](./DATABASE_SCHEMA.md) | Skema lengkap 57 tabel aktual (Tahfidz, LMS, Library, UKS, Asrama, dll) |
| **API Contract** | [`API_CONTRACT.md`](./API_CONTRACT.md) | Kontrak API mobile (Sanctum), Payment Gateway, WA API |
| **AI & Dev Rules** | [`AI_RULES.md`](./AI_RULES.md) | Aturan anti kebocoran unit, terminologi, keamanan API, commit BI |
| **UI/UX Design** | [`UI_UX_DESIGN.md`](./UI_UX_DESIGN.md) | Desain token, mode gelap Obsidian/Lime, layout mobile-first |
| **Roadmap** | [`ROADMAP.md`](./ROADMAP.md) | Riwayat rilis Fase 1-7 dan rencana masa depan |
