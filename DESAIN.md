---
name: Modern Islamic School Design System
colors:
  surface: '#ffffff'
  surface-dim: '#f8fafc'
  surface-bright: '#ffffff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f8fafc'
  surface-container: '#f1f5f9'
  surface-container-high: '#e2e8f0'
  surface-container-highest: '#cbd5e1'
  on-surface: '#0f172a'
  on-surface-variant: '#475569'
  outline: '#94a3b8'
  outline-variant: '#cbd5e1'
  primary: '#4338ca'
  on-primary: '#ffffff'
  primary-container: '#312e81'
  on-primary-container: '#e0e7ff'
  secondary: '#f59e0b'
  on-secondary: '#0f172a'
  secondary-container: '#fbbf24'
  on-secondary-container: '#78350f'
  tertiary: '#2563eb'
  on-tertiary: '#ffffff'
  tertiary-container: '#1d4ed8'
  on-tertiary-container: '#dbeafe'
  dark-surface: '#0f172a'
  dark-container: '#1e1b4b'
  background: '#ffffff'
  on-background: '#0f172a'
typography:
  display-lg:
    fontFamily: Poppins
    fontSize: 48px
    fontWeight: '900'
    lineHeight: 56px
    letterSpacing: -0.025em
  headline-lg:
    fontFamily: Poppins
    fontSize: 32px
    fontWeight: '800'
    lineHeight: 40px
  headline-md:
    fontFamily: Poppins
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-sm:
    fontFamily: Poppins
    fontSize: 18px
    fontWeight: '700'
    lineHeight: 26px
  body-lg:
    fontFamily: Poppins
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Poppins
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 24px
  label-bold:
    fontFamily: Poppins
    fontSize: 12px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.05em
  button:
    fontFamily: Poppins
    fontSize: 14px
    fontWeight: '800'
    lineHeight: 18px
rounded:
  sm: 0.5rem
  DEFAULT: 0.75rem
  md: 1rem
  lg: 1.5rem
  xl: 2rem
  full: 9999px
spacing:
  base: 4px
  container-max: 1280px
  gutter: 16px
---

# 🏛️ BLUEPRINT DESAIN & DOKUMENTASI UI/UX LENGKAP
## Website Sekolah Islam Terpadu Modern (Case Study: SMPS IT Ishlahul Ummah Prabumulih)

> **Dokumen Panduan & Referensi Desain Resmi**  
> Dokumen ini memuat seluruh spesifikasi desain visual, arsitektur tata letak (layout), komponen antarmuka (UI), sistem palet warna, tipografi, serta interaksi pengguna (UX) dari website **SMPS IT Ishlahul Ummah Prabumulih**. Dokumen ini dirancang sebagai standar acuan (blueprint) untuk pengembangan dan replikasi website sekolah-sekolah unggulan lainnya.

---

## 📑 DAFTAR ISI
1. [Filosofi & Prinsip Desain](#1-filosofi--prinsip-desain)
2. [Design Tokens & Fondasi Sistem](#2-design-tokens--fondasi-sistem)
   - [2.1 Sistem Palet Warna (Color System)](#21-sistem-palet-warna-color-system)
   - [2.2 Hierarki Tipografi (Typography)](#22-hierarki-tipografi-typography)
   - [2.3 Sudut Lengkung & Sistem Elevasi (Radii & Shadows)](#23-sudut-lengkung--sistem-elevasi-radii--shadows)
   - [2.4 Micro-Interactions & Sistem Animasi](#24-micro-interactions--sistem-animasi)
3. [Arsitektur Tata Letak Global (Global Layouts)](#3-arsitektur-tata-letak-global-global-layouts)
   - [3.1 Top Notification Mini Bar](#31-top-notification-mini-bar)
   - [3.2 Sticky Main Navigation (Header)](#32-sticky-main-navigation-header)
   - [3.3 Mobile Navigation Drawer](#33-mobile-navigation-drawer)
   - [3.4 Floating Widgets (Bahasa & Back-to-Top)](#34-floating-widgets-bahasa--back-to-top)
   - [3.5 Institutional Mega Footer](#35-institutional-mega-footer)
4. [Katalog Desain Halaman Utama (Homepage - 17 Sesi Strategis)](#4-katalog-desain-halaman-utama-homepage---17-sesi-strategis)
5. [Katalog Desain Modul & Halaman Khusus](#5-katalog-desain-modul--halaman-khusus)
   - [5.1 Modul SPMB / PPDB Online (Landing, Form, Sukses)](#51-modul-spmb--ppdb-online)
   - [5.2 Modul Profil Sekolah & Kelembagaan](#52-modul-profil-sekolah--kelembagaan)
   - [5.3 Modul Berita, Prestasi & Artikel](#53-modul-berita-prestasi--artikel)
   - [5.4 Modul Galeri Foto, Video YouTube & Dokumentasi](#54-modul-galeri-foto-video-youtube--dokumentasi)
   - [5.5 Modul Download Center, E-Library & Mars JSIT](#55-modul-download-center-e-library--mars-jsit)
   - [5.6 Modul Portal Layanan Terpadu & Interaksi Publik](#56-modul-portal-layanan-terpadu--interaksi-publik)
   - [5.7 Modul Kontak & Infaq Beasiswa](#57-modul-kontak--infaq-beasiswa)
6. [Katalog Desain Panel Administrasi (CMS Backend)](#6-katalog-desain-panel-administrasi-cms-backend)
7. [Panduan Replikasi untuk Sekolah Lain (Replication Checklist)](#7-panduan-replikasi-untuk-sekolah-lain-replication-checklist)

---

## 1. FILOSOFI & PRINSIP DESAIN

Desain website ini dibangun di atas konsep **"Modern Islamic Institutional Excellence"**, yang menyatukan 4 pilar utama:

1. **Prestisius & Terpercaya (Institutional Prestige)**:  
   Menampilkan citra sekolah yang mapan, terakreditasi, dan profesional melalui penggunaan warna biru navy (*Royal Indigo*) dan aksen emas (*Radiant Gold*), bukan warna polos biasa.
2. **Qur'ani & Berkarakter (Islamic Value Reflection)**:  
   Menonjolkan nilai-nilai keislaman melalui terminologi santri, program tahfidz mutqin, kutipan doa/hadits, serta integrasi visual kurikulum JSIT Indonesia.
3. **Konversi Tinggi untuk Pendaftaran (High-Conversion SPMB UX)**:  
   Setiap halaman strategis memiliki *Call-to-Action* (CTA) yang mencolok (tombol SPMB emas mengkilap, hotline WhatsApp satu klik, dan banner kuota terbatas).
4. **Kecepatan & Responsivitas Maksimal (Snappy & Accessible)**:  
   Dibangun dengan Tailwind CSS v4, font Poppins modern, efek *glassmorphism* elegan, animasi *scroll-reveal* ringan tanpa *lag*, serta optimalisasi gambar dalam format Next-Gen WebP.

---

## 2. DESIGN TOKENS & FONDASI SISTEM

### 2.1 Sistem Palet Warna (Color System)

| Token Warna | Nilai HEX | Peran & Penggunaan |
| :--- | :--- | :--- |
| **School Primary (Royal Indigo)** | `#4338ca` | Warna identitas utama brand, tombol navigasi aktif, border fokus, ikon utama |
| **School Primary Dark** | `#312e81` | Background gradasi navbar, hover state tombol utama, header kartu gelap |
| **School Primary Light** | `#6366f1` | Aksen hover, border kartu saat aktif, badge kurikulum |
| **Electric Blue** | `#2563eb` | Warna transisi gradasi, tautan teks, ikon teknologi & sains |
| **Radiant Gold (Amber)** | `#f59e0b` | **Warna konversi utama**: Tombol "Daftar SPMB", badge akreditasi, ikon prestasi, bintang rating |
| **Radiant Gold Light** | `#fbbf24` | Teks highlight pada background gelap, border bercahaya, efek kover buku |
| **Deep Dark Slate (Midnight)** | `#0f172a` | Top mini bar, background section video/galeri, kontras tinggi |
| **Dark Indigo Surface** | `#1e1b4b` | Kartu container sistem, kotak status server cPanel, modal dialog |
| **Soft Surface Gray** | `#f8fafc` | Background halaman konten bergantian, kartu pengumuman |
| **Border Neutral** | `#e2e8f0` | Pembatas kartu, garis tabel, pemisah navigasi |
| **Success Emerald** | `#22c55e` | Status pendaftaran diterima, indikator aktif, verifikasi server |
| **Alert Crimson** | `#ef4444` | Notifikasi kuota menipis, peringatan form, badge status belum selesai |

```css
/* Definisi CSS Theme Token */
@theme {
    --font-sans: 'Poppins', ui-sans-serif, system-ui, sans-serif;
    --color-school-primary: #4338ca;
    --color-school-primary-dark: #312e81;
    --color-school-primary-light: #6366f1;
    --color-school-indigo: #4f46e5;
    --color-school-blue: #2563eb;
    --color-school-gold: #f59e0b;
    --color-school-gold-light: #fbbf24;
    --color-school-dark: #0f172a;
    --color-school-gray: #f8fafc;
}
```

---

### 2.2 Hierarki Tipografi (Typography)

* **Font Utama**: `'Poppins', sans-serif` (Google Fonts: 300, 400, 500, 600, 700, 800, 900).
* **Display Titles (Hero)**: Ukuran `2.25rem` s/d `3.75rem` (`36px - 60px`), `font-weight: 900 (Black)`, `letter-spacing: -0.025em`, `leading: 1.15`.
* **Section Headings (H2)**: Ukuran `1.5rem` s/d `2.25rem` (`24px - 36px`), `font-weight: 800 (ExtraBold)`, dengan garis aksen emas di bawahnya.
* **Card Titles (H3/H4)**: Ukuran `0.875rem` s/d `1.125rem` (`14px - 18px`), `font-weight: 700 (Bold)`.
* **Body Text**: Ukuran `0.8125rem` s/d `0.9375rem` (`13px - 15px`), `font-weight: 400 (Regular)`, `line-height: 1.8`, warna `#374151` (teks abu gelap tidak menyilaukan).
* **Badges & Micro-Copy**: Ukuran `0.6875rem` s/d `0.75rem` (`11px - 12px`), `font-weight: 800 (ExtraBold)`, uppercase dengan `tracking-wider`.

---

### 2.3 Sudut Lengkung & Sistem Elevasi (Radii & Shadows)

* **Rounded Radii**:
  * Tombol CTA: `rounded-full` (Pill style - ramah dan menarik diklik).
  * Kartu Menu & Artikel: `rounded-2xl` (16px) hingga `rounded-3xl` (24px - 32px) untuk kartu jumbo.
  * Input Form: `rounded-xl` (12px).
* **Drop Shadows & Glow**:
  * `shadow-sm`: Kartu statis di background putih.
  * `shadow-md` ke `shadow-xl`: Efek *hover state* pada kartu berita dan menu.
  * `shadow-2xl shadow-indigo-900/30`: Kontainer utama hero banner.
  * `shadow-lg shadow-amber-500/25`: Khusus tombol CTA emas agar terlihat bersinar (*radiant glow*).

---

### 2.4 Micro-Interactions & Sistem Animasi

1. **Snappy Fast Scroll-Triggered Fade Up**:
   Komponen memanfaatkan class kustom `.reveal-fade-up` dengan kurva beziér akselerasi cepat:
   ```css
   .reveal-fade-up {
       opacity: 0;
       transform: translateY(24px);
       transition: opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1), 
                   transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
       will-change: opacity, transform;
   }
   .reveal-fade-up.is-revealed {
       opacity: 1 !important;
       transform: translateY(0) !important;
   }
   ```
2. **Stagger Delays**: Menggunakan class utilitas `.delay-1` (60ms) sampai `.delay-8` (480ms) agar elemen dalam satu baris muncul berurutan secara dinamis.
3. **Card Elevate on Hover**: `transform hover:-translate-y-1 hover:scale-102 transition duration-300`.
4. **Grace-Period Navigation Dropdown**: Dilengkapi jembatan hover transparan (*safe hover bridge*) dengan jeda waktu 150ms sehingga kursor pengguna tidak mudah terlepas saat mengarahkan ke sub-menu.

---

## 3. ARSITEKTUR TATA LETAK GLOBAL (GLOBAL LAYOUTS)

```
+-----------------------------------------------------------------------------------+
|  TOP MINI BAR (Hotline Telp | Email Resmi | Lokasi Sekolah)                       |
+-----------------------------------------------------------------------------------+
|  STICKY NAVBAR (Logo Resmi | Nav Links + Dropdown | CTA DAFTAR SPMB | Login Admin)|
+-----------------------------------------------------------------------------------+
|                                                                                   |
|  MAIN VIEWPORT CONTENT (Hero Slider / Subpage Hero / Dynamic Page Components)     |
|                                                                                   |
+-----------------------------------------------------------------------------------+
|  INSTITUTIONAL FOOTER (Profil, Alamat, Maps Pin, Menu Navigasi, Medsos, Hak Cipta)|
+-----------------------------------------------------------------------------------+
|  [Floating Multibahasa: Kiri Bawah]             [Floating Back-to-Top: Kanan Bawah]|
+-----------------------------------------------------------------------------------+
```

### 3.1 Top Notification Mini Bar
* **Background**: Dark Midnight (`#0f172a`) dengan border tipis bawah indigo (`border-indigo-900/60`).
* **Komponen**:
  * Ikon telepon + nomor hotline sekolah (`tel:0852-6990-8696`).
  * Ikon amplop + email resmi (`smpitishlahulummah.2015@yahoo.com`).
  * Lokasi kota ringkas (`Prabumulih Timur, Sumatera Selatan`).
* **Tujuan UX**: Memberikan rasa aman instan bagi calon wali murid yang memerlukan kontak darurat cepat tanpa harus *scroll* ke bawah.

### 3.2 Sticky Main Navigation (Header)
* **Background**: Gradasi Royal Indigo Glassmorphic (`from-indigo-950 via-indigo-900 to-blue-950 backdrop-blur-md`).
* **Logo**: Logo resmi sekolah di sisi kiri dengan transisi pembesaran halus saat disentuh kursor.
* **Menu Desktop**:
  1. **Beranda** (Home)
  2. **Profil** *(Dropdown: Sambutan Kepala Sekolah, Profil Singkat, Visi Misi, Sejarah, Dewan Guru & GTK, Struktur Organisasi, Fasilitas Sarana, Program Unggulan)*
  3. **Kabar & Galeri** *(Dropdown: Berita & Prestasi Santri, Galeri Foto, Video Kegiatan YouTube, Agenda Akademik, Pengumuman, Testimoni)*
  4. **Download** *(Dropdown: Semua Berkas Publik, E-Book Modul, Mars JSIT, Logo Sekolah)*
  5. **Layanan** *(Dropdown: Portal Terpadu, Izin Kunjungan, Permohonan Kerja Sama, Sewa Sarana)*
  6. **Kontak**
* **Action CTAs**:
  * **Tombol "Daftar SPMB"**: Desain pill dengan gradasi emas amber (`from-amber-400 via-amber-500 to-amber-600`), teks hitam tebal kontras, ikon topi toga kelulusan.
  * **Tombol "Login"**: Teks putih halus dengan ikon gembok untuk akses cepat guru & admin ke CMS.

### 3.3 Mobile Navigation Drawer
* Desain drawer slide-down dengan border atas 4px indigo.
* Dilengkapi kotak pencarian instan artikel & agenda.
* Daftar menu disusun vertikal dengan *touch target* minimal 44px agar nyaman dioperasikan satu tangan pada perangkat *smartphone*.

### 3.4 Floating Widgets
1. **Multi-Bahasa (Pojok Kiri Bawah)**:  
   Menggunakan integrasi GTranslate widget mengambang dengan pilihan bendera 3D bahasa:
   * 🇮🇩 Bahasa Indonesia (Utama)
   * 🇸🇦 Bahasa Arab (Menonjolkan identitas sekolah Islam)
   * 🇬🇧 Bahasa Inggris (Wawasan global)
2. **Back-to-Top Button (Pojok Kanan Bawah)**:  
   Tombol bulat berlatar indigo (`bg-indigo-600`) dengan cincin aksen emas (`ring-2 ring-amber-400/40`), otomatis muncul setelah pengguna melakukan scroll sejauh 300px ke bawah.

### 3.5 Institutional Mega Footer
* **Kolom 1 (Identitas Sekolah)**: Logo resmi sekolah berukuran jelas, deskripsi visi misi singkat, badge NPSN (`69787455`), Akreditasi BAN-SM (`Akreditasi B`), dan tautan media sosial lengkap (Facebook, Instagram, YouTube, TikTok).
* **Kolom 2 (Tautan Cepat)**: Menu profil, kurikulum, dewan guru, dan informasi penerimaan santri baru.
* **Kolom 3 (Layanan & Unduhan)**: Akses modul ajar, izin sekolah, permohonan kerjasama, dan donasi beasiswa.
* **Kolom 4 (Alamat & Peta Interaktif)**: Alamat lengkap fisik sekolah, nomor telepon, email, serta link peta Google Maps.
* **Bottom Bar**: Pernyataan hak cipta resmi dan tautan ke kebijakan privasi (*Privacy Policy*).

---

## 4. KATALOG DESAIN HALAMAN UTAMA (HOMEPAGE - 17 SESI STRATEGIS)

Halaman depan dirancang menggunakan prinsip **Storytelling & Conversion Funnel** yang memandu calon wali murid dari perkenalan awal hingga formulir pendaftaran:

| No | Nama Sesi (Section) | Deskripsi Tata Letak & Komponen Visual | Warna & Aksen Utama |
| :---: | :--- | :--- | :--- |
| **1** | **Hero Slider Banner** | Carousel multi-slide otomatis (durasi 6,5 detik). Dilengkapi badge emas "SMPS IT Unggulan • Terakreditasi B", judul display tebal, deskripsi, dan tombol ganda ("Jelajahi" & "Info SPMB"). | Background gelap Midnight Navy + overlay foto resolusi tinggi |
| **2** | **Floating Quick Action Hub** | Kontainer mengambang (*negative margin*) berisi 8 kartu ikon akses cepat (SPMB Online, Profil, Guru, Fasilitas, Unggulan, Prestasi, Ekskul, Kabar). Termasuk tombol cepat "Download Berkas" yang memicu modal popup. | Putih dengan border lembut indigo, kartu putih dengan ikon berlatar biru lembut |
| **3** | **Highlight SPMB Exclusive & Event** | Kartu *featured banner* lebar. Sisi kiri berupa flyer 3:4 dengan border glow bercahaya; sisi kanan informasi gelombang pendaftaran, 3 kartu benefit (Kuota 24 Santri, Cashback 1 Juta, Class Meeting), dan nomor WhatsApp panitia. | Gradasi Royal Indigo ke Deep Blue dengan glow emas & biru elektrik |
| **4** | **Sambutan Kepala Sekolah** | Tata letak asimetris 5:7. Foto formal Kepala Sekolah dalam bingkai melengkung modern dengan tanda kutip raksasa transparan, pesan sambutan pembinaan santri, dan tombol baca lengkap. | Putih bersih dengan aksen garis indigo |
| **5** | **Artikel & Kabar Kampus** | 1 Berita Utama jumbo di kiri (foto besar, tanggal, jumlah views, kategori) + 3 Berita sampingan horizontal di kanan dengan thumbnail kompak. | Background abu-abu lembut (`#f8fafc`) |
| **6** | **Prestasi Santri** | Grid 4 kolom kartu prestasi santri di bidang Tahfidz, Sains, Bahasa, dan Olahraga. Tiap kartu memiliki badge piala (*trophy*) emas dan tanggal kegiatan. | Putih dengan badge hitam-emas |
| **7** | **Kurikulum & Karakter Santri** | Format 2 kolom komparatif: Kolom Kiri memuat "Akademik & Kurikulum Terpadu (Merdeka + JSIT)"; Kolom Kanan memuat "Kesiswaan & 10 Karakter Muwashofat Santri". | Kartu putih ganda dengan badge warna berbeda (Indigo & Oranye) |
| **8** | **Program Unggulan** | Grid 4 kolom menonjolkan 4 program khas: Tahfidz 2 Juz Mutqin, Bilingual Arabic-English, Bina Prestasi Sains, dan Kepemimpinan Karakter Qur'ani. | Putih dengan highlight garis emas |
| **9** | **Dewan Guru & GTK Showcase** | Grid 4 kolom (Desktop) dan 2 kolom (Mobile) menampilkan foto potret para asatidz/asatidzah berlatar abu bersih, nama lengkap dengan gelar, dan mata pelajaran yang diampu. | Putih dengan bayangan melayang saat disentuh |
| **10** | **Galeri Video YouTube Resmi** | Background hitam gelap mewah. Menampilkan 3 kartu video embed responsif (YouTube no-cookie) dan tombol merah besar untuk *Subscribe* channel resmi sekolah. | Deep Slate Dark (`#020617`) dengan tombol Merah YouTube |
| **11** | **Pengumuman & Agenda Akademik** | 2 Kolom berdampingan: Kolom Pengumuman (notifikasi dinas & sekolah); Kolom Agenda Akademik (badge tanggal digital kotak kalender biru-putih). | Abu-abu lembut dengan aksen kalender indigo |
| **12** | **Galeri Foto Santri Multi-Row** | 2 Baris slider foto otomatis yang bergerak berlawanan dengan kecepatan halus. Dilengkapi overlay judul saat disentuh dan tombol navigasi panah samping. | Gelap Midnight dengan foto kegiatan santri |
| **13** | **Call-to-Action High Conversion** | Banner horizontal penuh berisi pesan ajakan pendaftaran mendesak (*scarcity urgency*: "Kuota Terbatas 24 Kursi per Kelas") dan tombol daftar emas. | Gradasi Royal Indigo ke Electric Blue |
| **14** | **E-Library & Modul Pembelajaran** | Container dark slate berisi slider cover buku 3D vertikal (Modul Tahfidz, Buku Kurikulum, Modul Siswa) yang dapat diunduh gratis oleh santri dan wali murid. | Dark Slate (`#0f172a`) dengan tombol unduh emas |
| **15** | **Testimoni Wali Santri & Alumni** | Grid 4 kartu kutipan berbingkai halus berisi cerita kepuasan wali santri, foto avatar bulat, nama wali, dan profesi. | Abu-abu muda dengan tanda kutip oranye |
| **16** | **Bottom Quick Action Cards** | 3 Kartu aksi di atas footer: Pendaftaran SPMB Online, Chat WhatsApp Hotline, dan Layanan Infaq/Beasiswa Santri Berprestasi. | Kartu putih dengan border atas tebal warna-warni (Indigo, Amber, Biru) |
| **17** | **Auto-Popup Promo SPMB Modal** | Modal jendela muncul otomatis setelah 600ms (dilengkapi *session storage* agar tidak mengganggu jika sudah ditutup). Menampilkan flyer promosi dan tombol langsung daftar. | Gelap backdrop blur dengan kartu putih border emas |

---

## 5. KATALOG DESAIN MODUL & HALAMAN KHUSUS

### 5.1 Modul SPMB / PPDB Online
* **Landing Page (`/spmb`, `/ppdb`)**:
  * Header brand dengan logo sekolah dan badge *"Pendaftaran Santri Baru Telah Dibuka"*.
  * Embed video profil sekolah YouTube resmi.
  * Kotak info jam operasional & rincian nomor rekening transfer pendaftaran (BSI / Bank Syariah Indonesia).
  * Panduan alur pendaftaran 5 langkah (Pendaftaran Akun -> Pembayaran -> Tes Baca Al-Qur'an & Wawancara -> Pengumuman Kelulusan -> Daftar Ulang).
  * Rincian biaya pendidikan transparan dan unduh brosur PDF.
* **Formulir Pendaftaran Online (`/form-ppdb`)**:
  * Desain multi-section: Jalur Pendaftaran (Reguler, Tahfidz, Prestasi), Data Calon Santri (Nama, NISN, TTL, Asal SD/MI), Data Orang Tua / Wali (Nama, Pekerjaan, No WhatsApp Aktif), dan Unggah Berkas (Kartu Keluarga, Akta Kelahiran, Rapor).
  * Validasi *real-time* di sisi browser dengan pesan error yang jelas dan ramah.
* **Halaman Sukses (`/ppdb/sukses`)**:
  * Ikon centang hijau besar beranimasi.
  * Kode unik pendaftaran (misal: `PPDB-2026-XXXX`).
  * Tombol Cetak Bukti PDF formulir.
  * Tombol langsung *"Konfirmasi WhatsApp ke Panitia"* yang otomatis mengisi template pesan teks dengan data calon santri.

### 5.2 Modul Profil Sekolah & Kelembagaan
* **Sambutan Kepala Sekolah (`/sambutan-kepala-sekolah`)**: Layout editorial seperti majalah dengan tipografi nyaman dibaca dan foto resmi kepala sekolah.
* **Tentang Kami (`/tentang-kami`)**: Rangkuman profil institusi, sertifikat akreditasi BAN-SM, legalitas SK pendirian, filosofi nama "Ishlahul Ummah", dan sarana prasarana.
* **Visi & Misi (`/visi-dan-misi`)**: Desain kartu bernomor rapi, memuat target lulusan (Hafal minimal 2 Juz Al-Qur'an mutqin, berakhlak mulia, mampu berkomunikasi bahasa Arab & Inggris dasar).
* **Sejarah (`/sejarah`)**: Desain linimasa vertikal (*vertical timeline*) yang menceritakan tonggak sejarah pendirian sekolah dari awal berdirinya hingga berkembang pesat.
* **Struktur Organisasi (`/struktur-organisasi`)**: Bagan hirarki manajemen mulai dari Yayasan, Kepala Sekolah, Komite, Wakil Kepala Bidang (Kurikulum, Kesiswaan, Sarpras, Humas), Guru hingga Staf Tata Usaha.
* **Dewan Guru & GTK (`/dewan-guru`)**: Katalog foto seluruh dewan asatidz dengan filter kategori bidang studi.
* **Fasilitas (`/fasilitas`, `/bidang/{slug}`)**: Galeri sarana prasarana (Ruang Kelas Ber-AC, Laboratorium Komputer, Masjid Sekolah, Lapangan Olahraga, Asrama Santri, Perpustakaan).

### 5.3 Modul Berita, Prestasi & Artikel
* **Indeks Berita (`/artikel`)**:
  * Fitur pencarian kata kunci dengan *instant response*.
  * Filter kategori dinamis (Akademik, Kesiswaan, Prestasi, Tahfidz, Event).
  * Tag cloud interaktif dan artikel terpopuler di *sidebar*.
  * Paginasi bersih berdesain angka modern.
* **Detail Berita (`/artikel/{slug}`)**:
  * Navigasi remah roti (*Breadcrumbs*): `Beranda > Berita > Judul Artikel`.
  * Foto utama resolusi tinggi dengan teks deskripsi (*caption*).
  * Informasi penulis, tanggal tayang, estimasi waktu baca, dan jumlah pengunjung.
  * Kotak tombol share cepat ke WhatsApp, Facebook, Twitter, dan Salin Tautan.
  * Artikel terkait (*Related Posts*) di bawah artikel.

### 5.4 Modul Galeri Foto, Video YouTube & Dokumentasi
* **Galeri Foto (`/galeri`)**: Format kisi foto (*masonry grid*) dengan efek zoom halus dan modal *lightbox* pratinjau resolusi penuh.
* **Galeri Video (`/video`)**: Grid kartu video YouTube terintegrasi langsung dengan judul dan durasi kegiatan.

### 5.5 Modul Download Center, E-Library & Mars JSIT
* **Pusat Unduhan (`/download`)**: Tabel dan kartu berkas publik dengan filter kategori (Brosur, Formulir, Kalender Akademik, Dokumen Tata Tertib). Disertai label ekstensi file (PDF, DOCX, XLSX) dan ukuran berkas.
* **E-Book & Modul Siswa (`/e-book`)**: Rak buku digital dengan cover visual yang memudahkan santri belajar mandiri di rumah.
* **Mars JSIT & Hymne (`/hymne-mars`)**: Lirik resmi penyemangat perjuangan pendidikan Islam terpadu beserta pemutar audio MP3 langsung di browser.
* **Identitas & Logo Resmi (`/logo`)**: Panduan penggunaan logo resmi sekolah, format resolusi tinggi PNG transparan dan vektor SVG.

### 5.6 Modul Portal Layanan Terpadu & Interaksi Publik
* **Portal Layanan Terpadu (`/layanan-terpadu`)**:
  * **Permohonan Izin Kunjungan / Studi Banding (`/izin-sekolah`)**: Formulir pengajuan kunjungan dari institusi luar dengan upload surat resmi.
  * **Permohonan Kerja Sama / Kemitraan (`/permohonan-kerja-sama`)**: Formulir kemitraan program, sponsor, atau beasiswa.
  * **Permohonan Sewa Sarana & Gedung (`/sewa-barang`)**: Formulir peminjaman sarana prasarana sekolah untuk kegiatan masyarakat umum.

### 5.7 Modul Kontak & Infaq Beasiswa
* **Hubungi Kami (`/hubungi`)**: Formulir kotak aspirasi dan pertanyaan terhubung ke database admin, nomor hotline, email, dan peta Google Maps interaktif.
* **Infaq & Beasiswa Santri (`/donasi`)**: Program dukungan santri yatim dan dhuafa berprestasi, menyertakan nomor rekening resmi yayasan (Bank Syariah Indonesia) dan transparansi penyaluran donasi.

---

## 6. KATALOG DESAIN PANEL ADMINISTRASI (CMS BACKEND)

Panel admin dirancang agar pengelola sekolah (guru piket, staf TU, kepala sekolah) dapat mengupdate konten tanpa perlu keahlian teknis:

1. **Halaman Login Admin (`/login`)**:
   * Desain kartu bersih di tengah layar bergradasi lembut.
   * Dilengkapi proteksi keamanan CSRF, *rate limiting*, dan validasi sandi.
2. **Dashboard Overview (`/admin`)**:
   * Widget ringkasan metrik: Total Pendaftar SPMB, Artikel Aktif, Galeri Foto, dan Pengunjung Hari Ini.
   * Grafik tren pengunjung website mingguan.
   * Pendaftar SPMB terbaru yang memerlukan verifikasi.
3. **Word-like WYSIWYG Editor (Quill.js)**:
   * Toolbar kustom menyerupai pita (*Ribbon*) Microsoft Word.
   * Tombol format: Bold, Italic, Underline, Align (Rata Kiri, Tengah, Kanan, Justify), Header 1-3, List angka/titik, Sisip Gambar, dan Tautan URL.
4. **Manajemen PPDB (Full-Featured)**:
   * Tabel interaktif dengan filter status pendaftaran (Menunggu Verifikasi, Lulus Berkas, Lulus Wawancara, Diterima, Ditolak).
   * Fitur ekspor data pendaftar ke **Excel (.xlsx)** dan **PDF**.
   * Fitur cetak formulir kartu pendaftaran santri perorangan.
   * Pembuat bidang formulir dinamis (*Dynamic Form Builder*) untuk menambah pertanyaan form tanpa coding.
5. **Pengaturan Website & SEO (`/admin/settings`)**:
   * Form pengaturan nama sekolah, tagline, deskripsi meta, kata kunci SEO, nomor telepon, WhatsApp, email, dan media sosial.
   * Upload logo sekolah, logo favicon, dan banner open graph.

---

## 7. PANDUAN REPLIKASI UNTUK SEKOLAH LAIN (REPLICATION CHECKLIST)

Bagi pengembang atau pihak yayasan yang ingin mengadaptasi desain ini untuk sekolah lain:

### Langkah 1: Kustomisasi Identitas & Variabel Brand
Ubah nilai dasar di file konfigurasi atau admin settings:
* **Nama Sekolah**: Ganti di `.env` (`APP_NAME="Nama Sekolah Anda"`) dan Admin Settings.
* **Logo**: Ganti file gambar di folder `public/uploads/logo-ishum.png` dan `public/uploads/logo-ishum-square.png`.
* **Favicon**: Ganti di `public/uploads/logo-ishum-square.png`.

### Langkah 2: Menyesuaikan Skema Warna (Jika Berbeda)
Jika sekolah target memiliki warna khas lain (misalnya Hijau Pesantren `#059669` atau Biru Langit `#0284c7`), sesuaikan token di `resources/css/app.css`:
```css
@theme {
    /* Contoh Adaptasi Warna Hijau Pesantren */
    --color-school-primary: #059669;
    --color-school-primary-dark: #064e3b;
    --color-school-primary-light: #10b981;
    --color-school-gold: #f59e0b; /* Pertahankan emas untuk konversi SPMB */
}
```

### Langkah 3: Mengganti Aset Gambar Utama
Ganti gambar berikut dengan foto asli sekolah target (gunakan format WebP agar loading cepat):
1. `flyer-spmb-smpit-ishum.png` -> Brosur/flyer penerimaan santri baru tahun ajaran berjalan.
2. `dewan/kepala-sekolah.webp` -> Foto resmi kepala sekolah.
3. `campus-smpit-ishum.webp` -> Foto gedung / gerbang kampus utama.
4. `activities-smpit-ishum.webp` -> Foto santri berprestasi / kegiatan belajar mengajar.

### Langkah 4: Konfigurasi Rekening & Hotline WhatsApp
* Perbarui nomor rekening di halaman `/spmb` pada view `resources/views/frontend/ppdb/index.blade.php`.
* Pastikan nomor WhatsApp panitia menggunakan format internasional (`628xxxxxxxxxx`) agar tautan chat langsung berfungsi di Android, iPhone, dan Desktop.

---

*Dokumen ini dibuat secara komprehensif sebagai dokumentasi arsitektur UI/UX sistem website SMPS IT Ishlahul Ummah Prabumulih dan referensi desain portal sekolah berstandar tinggi.*
