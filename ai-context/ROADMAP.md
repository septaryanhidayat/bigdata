# SmartEdu SIT Robbani — Roadmap & Milestones (ROADMAP.md)

> **Rencana Pengembangan, Status Rilis Fitur, dan Rencana Masa Depan Sistem SmartEdu**

---

## 📅 1. Riwayat Tahapan Rilis (*Completed Milestones*)

### ✅ Fase 1: Fondasi ERP & Multi-Tenancy Scoping
- Implementasi 15 Peran Pengguna (*Role-Based Access Control*).
- Isolasi data unit pendidikan (`school_id: 1..4` untuk TKIT, SDIT, SMPIT, SMAIT dan `school_id: null` untuk Yayasan).
- Modul Master Data Siswa, Guru, Kelas, dan Tahun Ajaran.
- Modul Keuangan E-SPP, Kasir POS, dan Cetak Kuitansi PDF.

### ✅ Fase 2: Integrasi Konten Asli & Multimedia
- Parser XML WordPress super cepat (247 postingan berita asli termuat dalam 0.1 detik).
- Integrasi video resmi YouTube Channel SIT Robbani dengan pemutar modal interaktif.
- Auto-kategorisasi berita ke masing-masing profil unit.

### ✅ Fase 3: Persuratan Digital & Tanda Tangan Elektronik (TTE)
- Pembuatan draf surat keluar dengan banner KOP unit resmi atau mode logo tunggal.
- Alur disposisi dan verifikasi pimpinan unit/yayasan.
- Penandatanganan digital ber-QR dengan enkripsi SHA-256 dan token UUID publik (`/verifikasi-surat/{token}`).

### ✅ Fase 4: Dark Mode Eksekutif (Obsidian Emerald & Electric Lemon)
- Transisi tema satu klik dengan Alpine.js state persistence (`darkMode: true/false`).
- Warna `#061107` (Deep Obsidian Emerald) dan `#c6f634` (Electric Lemon).
- Kepatuhan kontras WCAG AAA (teks hitam pekat di atas tombol neon lime).

### ✅ Fase 5: Redesain Berita 2-Kolom, Migrasi SEO 301 & Keamanan Siber
- Pembagian layout berita 2-kolom desktop (konten lebar di kiri, widget pencarian & navigasi di kanan).
- Dynamic XML Sitemap (`/sitemap.xml`) dengan Google Image tags & priority.
- Dynamic `robots.txt` (`/robots.txt`).
- Handler 301 Permanent Redirect untuk seluruh URL warisan WordPress (`/{year}/{month}/{day}/{slug}`, `/category/{cat}`, `/tag/{tag}`).
- Structured data Schema.org JSON-LD (`NewsArticle` dan `EducationalOrganization`).
- Global Security Headers Middleware (`X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`).

### ✅ Fase 6: Modul 23 AI Chatbot RAG, Perbaikan Mobile & Animasi Fast Fade-Up
- Penambahan Kategori 6: **Smart AI & RAG Dokumen** di showcase digital web utama.
- Ekstraksi otomatis teks dokumen PDF resmi (Brosur SPMB, SOP Santri, Kurikulum Tahfidz) ke tabel `ai_knowledge_bases`.
- RAG (Retrieval-Augmented Generation) terintegrasi data realtime database SmartEdu.
- Perbaikan layout mobile widget jadwal sholat 5-kolom simetris bebas tumpang-tindih.
- Animasi scroll cepat dan halus (`.reveal-fade-up` durasi 0.4s).

---

## 🔮 2. Rencana Pengembangan Selanjutnya (*Future Horizons*)

```mermaid
timeline
    title Peta Jalan Pengembangan Lanjutan SmartEdu SIT Robbani
    Q4 2026 : Otomasi WhatsApp Gateway Notifikasi Tagihan SPP : Integrasi Payment Gateway Midtrans / Xendit
    Q1 2027 : Peluncuran Mobile App Android / iOS (Flutter Portal Santri) : Presensi Geolocation & Face Recognition
    Q2 2027 : Smart Dashboard Business Intelligence (BI) Eksekutif : AI Analytics Prediksi Prestasi & Minat Santri
```

### Rincian Rencana:
1. **Otomasi Notifikasi Tagihan SPP via WhatsApp Gateway:**
   - Kirim pengingat tagihan bulanan otomatis ke nomor WhatsApp wali santri setiap tanggal 1.
2. **Integrasi Virtual Account & QRIS Payment Gateway:**
   - Pembayaran SPP instan via BCA, Mandiri, BSI, dan QRIS dengan notifikasi webhook lunas realtime.
3. **Mobile App Portal Santri & Wali (Flutter):**
   - Aplikasi mobile native untuk wali santri memantau mutabaah harian, presensi, hafalan tahfidz, dan saldo saku santri.
4. **AI Smart Assessment & Student Analytics:**
   - Rekomendasi program peningkatan minat bakat santri berdasarkan data mutabaah, rapor, dan catatan konseling BK.
