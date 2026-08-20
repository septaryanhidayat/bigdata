# SmartEdu SIT Robbani — Project Overview

> **Platform Ekosistem Digital Pendidikan Islam Terpadu & Tata Kelola Sekolah Terintegrasi (23+ Modul Digital)**  
> **Yayasan Generasi Robbani Ogan Ilir, Sumatera Selatan**  
> *Versi Rilis: 3.0 — Final Pre-Production (Tahun Ajaran 2026/2027)*  
> *Terakhir diperbarui: 18 Agustus 2026*

---

## 🌟 1. Visi & Misi Produk

**SmartEdu SIT Robbani** adalah platform manajemen sekolah terpadu (*All-in-One Educational ERP & Public Web Portal*) yang menggabungkan:

1. **Website Publik & Branding Modern:** Portal resmi yayasan dan 4 unit pendidikan dengan desain modern, responsive mobile-first, dark mode Obsidian Emerald + Neon Lime, jadwal sholat realtime, kalender Hijriyah, integrasi berita WordPress asli (ratusan artikel diimpor), video YouTube resmi, galeri per unit, dan mesin SEO Google otomatis (sitemap.xml, robots.txt, meta OG).
2. **Dashboard Administrasi Sekolah Terpadu (15 Peran RBAC):** Mengatur seluruh operasional akademik, keuangan, kepegawaian, sarana prasarana, kesiswaan, perpustakaan, hingga bimbingan konseling di bawah 1 payung database multi-tenancy dengan 58 tabel MySQL terstruktur.
3. **Smart AI Assistant & Knowledge Base RAG (Modul 23):** Asisten cerdas 24/7 berbasis Retrieval-Augmented Generation yang membaca dokumen PDF resmi & data live SmartEdu untuk melayani calon wali murid tanpa halusinasi.
4. **Aplikasi Mobile SDM (React Native Expo SDK 52):** Aplikasi `sdm-robbani-mobile/` untuk manajemen SDM: presensi GPS/face recognition, payroll, BPI mutabaah, kantin digital, pengajuan cuti.

---

## 🏛️ 2. Struktur Organisasi Multi-Tenancy (4 Unit + Yayasan)

| Unit | Kode | school_id | Kepala |
|------|------|-----------|--------|
| Yayasan Generasi Robbani Sumatera Selatan | YAYASAN | null | Sughesti Wulandari, S.Pd (Ketua Yayasan) |
| KB/TKIT Robbani | TKIT | 1 | Ani Oktar Yansi, S.Pd.I |
| SDIT Robbani | SDIT | 2 | Nur Amalia, S.Pd |
| SMPIT Robbani | SMPIT | 3 | Tia Wulandari, S.Pd., Gr. |
| SMAIT Robbani | SMAIT | 4 | (Dalam Persiapan Program Sains & IT) |

Setiap unit memiliki isolasi data yang ketat (*Multi-Tenancy Unit Scoping*): akun Kepala Sekolah & Staf TU hanya mengelola data unitnya sendiri. Super Admin & Ketua Yayasan mengakses semua unit.

---

## 📦 3. Ekosistem 23+ Modul Digital Terpadu

| No | Modul | Status Saat Ini |
|----|-------|-----------------|
| 1 | Website Profil & CMS 4 Unit Terpadu | ✅ Live |
| 2 | SPMB Online & Verifikasi Berkas Digital | ✅ Live |
| 3 | CBT Ujian Masuk & Seleksi Siswa Baru | ✅ Live |
| 4 | Master Data Multi-Unit (Siswa, Guru, Kelas) | ✅ Live |
| 5 | E-SPP, Billing Otomatis & Kuitansi QR PDF | ✅ Live |
| 6 | Kasir POS & Dompet Digital Siswa (RFID Ready) | ✅ Live |
| 7 | Buku Tabungan & Simpanan Siswa Realtime | ✅ Live |
| 8 | Presensi QR Code, RFID & Geo-Location | ✅ Live |
| 9 | Jurnal Mengajar, Silabus & Jadwal Pelajaran | ✅ Live |
| 10 | E-Learning (LMS) & Bank Soal CBT Siswa | ✅ Live |
| 11 | Rapor Digital & Rekap Nilai Kurikulum Merdeka | ✅ Live |
| 12 | Bina Pribadi Islam (BPI) & Mutabaah Yaumiyah | ✅ Live |
| 13 | HRIS, Database SDM & Penggajian (Payroll) | ✅ Live |
| 14 | Sarana Prasarana (Sarpras) & Barcode Aset | ✅ Live |
| 15 | E-Library & Sirkulasi Buku Perpustakaan | ✅ Live |
| 16 | Bimbingan Konseling (BK Online) & Poin Siswa | ✅ Live |
| 17 | Persuratan Digital, Disposisi & QR TTE Resmi | ✅ Live |
| 18 | PPDB Manager & Rekap Pendaftaran | ✅ Live |
| 19 | Portal Eksekutif Yayasan (Dashboard Konsolidasi) | ✅ Live |
| 20 | AI Trainer & Knowledge Base RAG | ✅ Live |
| 21 | Aplikasi Mobile SDM (Expo React Native) | ✅ Live |
| 22 | CMS Profil Yayasan (Tab Baru - Bisa Diedit) | ✅ Live |
| 23 | Notifikasi WhatsApp Gateway Terpadu | 🔧 Coming Soon |

---

## 🎯 4. Target Pengguna (Stakeholders)

- **Calon Wali Murid & Publik:** Pendaftaran SPMB, konsultasi chatbot AI, cek pengumuman & berita.
- **Wali Murid Aktif:** Cek tagihan E-SPP, pantau hafalan Tahfidz, mutabaah, rapor, dan presensi anak.
- **Guru & Wali Kelas:** Input nilai rapor, buat tugas LMS, absensi kelas, jurnal mengajar.
- **Staf Tata Usaha (TU):** Kelola persuratan, buku agenda, CMS berita/profil unit.
- **Bendahara Keuangan:** Kelola pos tagihan SPP, kuitansi PDF ber-QR, rekap kas harian.
- **Kepala Sekolah:** Monitoring capaian akademik, disposisi surat masuk, persetujuan TTE.
- **Ketua Yayasan & Super Admin:** Akses penuh semua data 4 unit + yayasan, audit keuangan & SDM multi-unit.
- **Pegawai/Guru (Mobile):** Presensi GPS, pengajuan cuti, slip gaji, mutabaah via smartphone.

---

## 📚 5. Indeks Dokumen Master di `ai-context/`

| Dokumen | Deskripsi |
| :--- | :--- |
| `PROJECT_OVERVIEW.md` | Visi, cakupan sistem, hierarki 4 unit, dan stakeholder |
| `PRD.md` | Kebutuhan fungsional 23 modul, 15 peran RBAC, dan NFR |
| `TECH_STACK.md` | Spesifikasi teknologi PHP 8.4, Laravel 13, MySQL, Vite 6, Expo SDK 52 |
| `ARCHITECTURE.md` | Diagram sistem, multi-tenancy, siklus TTE, deployment cPanel |
| `DATABASE_SCHEMA.md` | Skema lengkap 58 tabel aktual + key multi-tenancy |
| `API_CONTRACT.md` | Kontrak API mobile (Sanctum), endpoint HRIS Mobile, format respons JSON |
| `AI_RULES.md` | Aturan pengembangan, anti kebocoran unit, terminologi, konvensi commit |
| `UI_UX_DESIGN.md` | Token desain, dark mode Obsidian/Neon Lime, layout mobile-first |
| `ROADMAP.md` | Riwayat rilis Fase 1–8 dan rencana masa depan |
