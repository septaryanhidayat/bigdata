# SmartEdu SIT Robbani — UI/UX Design System (UI_UX_DESIGN.md)

> **Panduan Standar Desain Visual, Skema Warna, Tipografi, Komponen, dan Responsivitas**

---

## 🎨 1. Palet Warna & Desain Token (*Color Tokens*)

### A. Skema Mode Terang (*Light Mode - Islamic Executive & Warm Sunset*)
| Token | Nilai Hex | Penggunaan Utama |
| :--- | :--- | :--- |
| `primary` | `#004532` | Hijau Botol Islami — Header, Brand Title, Badge Utama |
| `primary-container` | `#065f46` | Aksen Emerald Sedang — Hover menu, border card aktif |
| `secondary-container`| `#fd761a` | Oranye Sunset Hangat — Tombol CTA, pendaftaran SPMB |
| `accent-orange` | `#f97316` | Aksen Tagihan E-SPP, Highlight Pengumuman |
| `background` | `#f8fafc` | Latar Belakang Dasar Halaman (Crisp Slate 50) |
| `surface` | `#ffffff` | Permukaan Kartu Konten, Modal Box |
| `on-surface` | `#0f172a` | Teks Konten Utama (Slate 900) |

---

### B. Skema Mode Gelap (*Dark Mode - Deep Obsidian Emerald & Electric Lemon*)
| Token | Nilai Hex | Penggunaan Utama |
| :--- | :--- | :--- |
| `dark-bg-base` | `#061107` | Latar Belakang Gelap Pekat (Obsidian Forest) |
| `dark-surface` | `#0e2010` | Permukaan Kartu Konten (Deep Moss Emerald) |
| `dark-surface-elevated`| `#153018`| Panel Dalam, Input Field, Dropdown Menu |
| `dark-border` | `#1a381c` | Garis Batas Kartu & Section Divider |
| `dark-accent-lime` | `#c6f634` | **Electric Lemon / Neon Lime** — Aksen Aktif, Tombol CTA Utama |
| `dark-text-primary` | `#f7fee7` | Teks Utama Keterbacaan Tinggi di Mode Gelap |
| `dark-text-on-lime` | `#061107` | **Wajib Hitam Pekat** di atas latar belakang Neon Lime / Amber |

---

## ✍️ 2. Sistem Tipografi & Font Hierarchy

1. **Headline Font:** `Montserrat` (Weights: 700 Bold, 800 ExtraBold, 900 Black)
   - Digunakan untuk: Judul Halaman (`h1`), Judul Modul (`h2`), Nama Unit Pendidikan, Nomor Statistik.
2. **Body Font:** `Inter` (Weights: 400 Regular, 500 Medium, 600 SemiBold)
   - Digunakan untuk: Paragraf Berita, Deskripsi Layanan, Form Input, Tabel Data.
3. **Monospace / Clock:** `JetBrains Mono` / Font Monospace Default
   - Digunakan untuk: Jam Realtime, Hash TTE Digital, Kode Pendaftaran.

---

## 📱 3. Kaidah Responsivitas Mobile-First (*Mobile Layout Rules*)

1. **Header Mobile:**
   - Single-row layout bersih dengan Logo di kiri, tombol ringkas *"← Berita"* dan toggle dark mode di kanan (tanpa wrapping/clutter).
2. **Widget Waktu Sholat:**
   - 5 waktu sholat (Subuh, Dzuhur, Ashar, Maghrib, Isya) tersusun simetris dalam 1 baris grid 5-kolom dengan angka jam `whitespace-nowrap`.
3. **Menu Akses Cepat:**
   - Grid responsif `grid-cols-3 sm:grid-cols-5 lg:grid-cols-9` dengan kartu berukuran proporsional.
4. **4 Unit Sekolah:**
   - Grid 2x2 (*2 unit atas, 2 unit bawah*) di smartphone dengan foto kepala sekolah melingkar dan tombol aksi proporsional.
5. **Detail Berita:**
   - Desktop: 2-kolom (sisi kiri berita lebar 8-kolom, sisi kanan widget 4-kolom).
   - Mobile: 1-kolom terpadu dengan teks paragraf rata kiri alami (`text-align: left !important`).

---

## ⚡ 4. Sistem Animasi & Interaktivitas

- **Snappy Fast Fade-Up Scroll Animation:**
  ```css
  .reveal-fade-up {
      opacity: 0;
      transform: translateY(20px);
      transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease-out;
      will-change: transform, opacity;
  }
  .reveal-fade-up.is-visible {
      opacity: 1;
      transform: translateY(0);
  }
  ```
- **Micro-Interactions:**
  - Hover efek kartu naik 4px (`transform hover:-translate-y-1 hover:shadow-xl`).
  - Pulsing indicator pada badge live status.
  - SweetAlert2 auto-timer 2.5 detik untuk notifikasi aksi instan.
