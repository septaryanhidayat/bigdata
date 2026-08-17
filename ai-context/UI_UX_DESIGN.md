# SmartEdu SIT Robbani — UI/UX Design System (UI_UX_DESIGN.md)

> **Panduan Desain Token, Dark/Light Mode, Layout Mobile-First, dan Komponen UI**
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 🎨 1. Color System — Dark Mode (Obsidian Emerald)

| Token | Hex | Penggunaan |
|-------|-----|------------|
| `--bg-primary` | `#061107` | Background utama halaman dark mode |
| `--bg-card` | `#0e2010` | Surface card, panel, sidebar |
| `--bg-card-alt` | `#0d1e0f` | Card alternatif, input background |
| `--border-card` | `#1a381c` | Border card, divider, outline |
| `--accent-lime` | `#c6f634` | CTA button, badge aktif, highlight |
| `--accent-lime-dark` | `#a8d428` | Hover state CTA button |
| `--text-primary` | `#e8f5e9` | Teks utama konten |
| `--text-secondary` | `#a5d6a7` | Teks sekunder, caption, label |
| `--text-on-lime` | `#061107` | **WAJIB** pada background lime (kontras WCAG AAA) |

> ⚠️ **Aturan Wajib:** Pada `bg-[#c6f634]` (Electric Lemon/Neon Lime), teks **HARUS** `text-[#061107]` atau `text-slate-950`. DILARANG teks putih — kontras gagal WCAG.

---

## ☀️ 2. Color System — Light Mode

| Token | Hex | Penggunaan |
|-------|-----|------------|
| `--bg-primary` | `#ffffff` | Background halaman light mode |
| `--bg-card` | `#f8fffe` | Surface card light |
| `--border-card` | `#d1fae5` | Border card light |
| `--accent-green` | `#16a34a` | Primary CTA light mode |
| `--text-primary` | `#0f172a` | Teks utama light mode |
| `--text-secondary` | `#475569` | Teks sekunder light mode |

---

## 📱 3. Layout Mobile-First Rules

### Website Publik (unit.blade.php)
- **Header mobile:** Logo di kiri atas saja, tanpa tulisan di samping. Single-line, tidak overflow.
- **Hero Banner:** Padding disesuaikan mobile, badge tidak terpotong, animasi `animate-hero-float` dan `animate-pulse-glow`.
- **Guru Cards:** Grid 2 kolom mobile, nama dan jabatan rata tengah, tidak ada quote/bio.
- **Footer mobile:** Logo saja (tanpa teks di samping), semua konten rata tengah, tidak ada bullet list.
- **Utility ribbon header:** Single-line, tidak clipping di mobile.

### Dashboard Admin (responsive)
- Sidebar collapse di mobile menjadi hamburger menu.
- Tabel menggunakan scroll horizontal di mobile.
- Card statistik 2x2 grid di mobile (bukan 4 kolom).
- Chatbot AI panel: font terbaca, warna kontras.

---

## 🎭 4. Animasi & Interaksi

### Scroll Animations
```css
.reveal-fade-up {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.reveal-fade-up.is-visible {
    opacity: 1;
    transform: translateY(0);
}
```

### Hero Float Animation
```css
@keyframes hero-float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
.animate-hero-float { animation: hero-float 3s ease-in-out infinite; }
```

### Pulse Glow Animation
```css
@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 20px rgba(198, 246, 52, 0.3); }
    50% { box-shadow: 0 0 40px rgba(198, 246, 52, 0.7); }
}
.animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
```

### Chatbot Typing Animation
- Respon AI ditampilkan karakter per karakter (bukan langsung semua muncul).
- Delay antar karakter: ~30ms untuk efek natural.

---

## 🌗 5. Dark/Light Mode Toggle

```javascript
// Alpine.js implementation
x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
x-init="$watch('darkMode', v => {
    localStorage.setItem('darkMode', v);
    document.documentElement.classList.toggle('dark', v);
})"
```

```html
<!-- Toggle button -->
<button @click="darkMode = !darkMode" aria-label="Toggle dark mode">
    <span x-show="!darkMode">🌙</span>
    <span x-show="darkMode">☀️</span>
</button>
```

---

## 🖼️ 6. Foto Guru — Konvensi Penamaan

### Prefix file foto berdasarkan unit:
| Unit | Prefix File |
|------|-------------|
| TKIT Robbani | `gtk_tk_*.jpeg` atau `gtk_tk_*.jpg` |
| SDIT Robbani | `gtk_sd_*.png` |
| SMPIT Robbani | `gtk_smp_*.png` atau `whatsapp-image-2024-12-03-*.jpeg` |

**Lokasi:** `public/uploads/wp_assets/`

**Aturan tampil:**
- Foto ditampilkan dalam card dengan aspect-ratio 1:1, object-cover.
- Tidak ada quote/bio di bawah nama di halaman unit.
- Jabatan tampil di bawah nama (dari field `role`, bukan "Guru S1").

---

## 🔔 7. Notifikasi & Alert

**Selalu gunakan SweetAlert2** untuk:
- ✅ Simpan data berhasil → `Swal.fire({icon: 'success', timer: 2500})`
- ❌ Error validasi → `Swal.fire({icon: 'error'})`
- ⚠️ Konfirmasi hapus → `Swal.fire({icon: 'warning', showCancelButton: true})`
- ℹ️ Info umum → `Swal.fire({icon: 'info', timer: 3000})`

**Jangan gunakan** `alert()` atau `confirm()` browser default.

---

## 🎨 8. Dashboard Admin — 5 Tema Warna Global

Dashboard admin mendukung 5 pilihan warna tema yang bisa diseleksi:
1. **Obsidian Emerald** (default dark) — `#061107` + `#c6f634`
2. **Royal Navy** — `#0d1b2a` + `#4fc3f7`
3. **Deep Purple** — `#1a0533` + `#ce93d8`
4. **Slate Pro** — `#0f172a` + `#94a3b8`
5. **Warm Amber** — `#1c1008` + `#fbbf24`

Warna tema disimpan di localStorage dan diaplikasikan via CSS custom properties.
