# SmartEdu SIT Robbani — UI/UX Design System

> *Token Desain, Komponen, & Panduan Tampilan Terpadu*  
> *Terakhir diperbarui: 18 Agustus 2026*

---

## 🎨 1. Color Palette (Light & Dark Mode)

### Light Mode (Default)
```css
/* Primary & Accent */
--color-primary: #004532;          /* Emerald Deep Green — header, buttons */
--color-primary-hover: #065f46;    /* Emerald-700 */
--color-accent: #ea580c;           /* Orange-600 — CTA, badge highlights */
--color-accent-hover: #c2410c;     /* Orange-700 */

/* Background */
--color-bg: #f8fafc;               /* Slate-50 */
--color-surface: #ffffff;          /* White cards */
--color-border: #e2e8f0;           /* Slate-200 */

/* Text */
--color-text: #0f172a;             /* Slate-900 */
--color-muted: #64748b;            /* Slate-500 */
```

### Dark Mode (Obsidian Emerald + Neon Lime)
```css
/* Dark Mode Palette */
--bg-dark: #040d06;               /* Obsidian Emerald — main background */
--surface-dark: #07170a;          /* Dark Green surface */
--border-dark: #1a381c;           /* Dark border */
--neon: #c6f634;                  /* Neon Lime — primary accent dark */
--neon-bright: #a3e635;           /* Lime-400 hover */

/* Dark Text */
--text-dark: #f0fdf4;             /* Emerald-50 */
--text-muted-dark: #86efac;       /* Emerald-300 */
```

### Unit Color Coding
| Unit | Badge Color | Tailwind |
|------|-------------|----------|
| KB/TKIT | Emerald | `bg-emerald-100 text-emerald-800` |
| SDIT | Orange | `bg-orange-100 text-orange-800` |
| SMPIT | Blue | `bg-blue-100 text-blue-800` |
| SMAIT | Purple | `bg-purple-100 text-purple-800` |
| Yayasan | Slate | `bg-slate-100 text-slate-800` |

---

## ✍️ 2. Tipografi

| Elemen | Font | Weight | Size |
|--------|------|--------|------|
| **Heading H1** | Plus Jakarta Sans | Black (900) | 3xl–6xl |
| **Heading H2** | Plus Jakarta Sans | ExtraBold (800) | 2xl–4xl |
| **Body Text** | Plus Jakarta Sans | Medium (500) | sm–base |
| **Admin UI** | Plus Jakarta Sans | SemiBold (600) | xs–sm |
| **Badge/Label** | Plus Jakarta Sans | Black (900) | 2xs–xs |

```html
<!-- Google Fonts load -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
```

---

## 🧱 3. Komponen UI Standar

### Kartu (Card)
```html
<!-- Standard Card -->
<div class="bg-white dark:bg-[#07170a] border border-slate-200 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all">
  <!-- content -->
</div>
```

### Tombol Aksi
```html
<!-- Tombol Utama (CTA) -->
<button class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 dark:bg-[#c6f634] dark:hover:bg-[#a3e635] text-white dark:text-[#040d06] font-black text-xs shadow-md transition-transform hover:scale-105">
  Daftar PPDB →
</button>

<!-- Tombol Bahaya -->
<button class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs">
  Hapus
</button>

<!-- Tombol Secondary -->
<button class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200">
  Batal
</button>
```

### Badge Unit
```html
<span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#0d1e0f] text-emerald-800 dark:text-[#c6f634] font-black text-xs">TKIT</span>
<span class="px-3 py-1 rounded-full bg-orange-100 text-orange-800 font-black text-xs">SDIT</span>
<span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-xs">SMPIT</span>
<span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-xs">SMAIT</span>
```

### Input Form
```html
<input type="text" 
  class="w-full px-4 py-2.5 bg-slate-50 dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500 dark:text-white">
```

---

## 🌙 4. Dark Mode Implementation

Dark mode menggunakan Alpine.js + Tailwind `dark:` variant:

```html
<!-- x-data di elemen <html> atau <body> -->
<html x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">

<!-- Toggle button -->
<button @click="darkMode = !darkMode">
  <span x-show="!darkMode">🌙 Mode Malam</span>
  <span x-show="darkMode" x-cloak>☀️ Mode Terang</span>
</button>

<!-- Gunakan Tailwind dark: prefix -->
<div class="bg-white dark:bg-[#07170a] text-slate-900 dark:text-[#f0fdf4]">
```

---

## 🎭 5. Animasi & Micro-interactions

### Animasi Keyframe (Tailwind Custom Config)
```javascript
// tailwind.config.js
keyframes: {
  'pulse-slow': {
    '0%, 100%': { opacity: '0.4', transform: 'scale(1)' },
    '50%': { opacity: '0.8', transform: 'scale(1.05)' }
  },
  'float': {
    '0%, 100%': { transform: 'translateY(0px)' },
    '50%': { transform: 'translateY(-8px)' }
  },
  'slide-up': {
    '0%': { opacity: '0', transform: 'translateY(20px)' },
    '100%': { opacity: '1', transform: 'translateY(0)' }
  }
}
```

### Hover Effects Standar
```css
/* Card hover lift */
.card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

/* Button press */
.btn:hover { transform: scale(1.05); }

/* Icon group hover */
.group:hover .group-hover-icon { transform: scale(1.1); transition: transform 0.3s; }
```

---

## 📐 6. Layout Grid

### Website Publik
- **Max Width**: `max-w-7xl mx-auto px-4 sm:px-6`
- **Hero Section**: Full-width dengan gradient overlay
- **Section Spacing**: `py-14 sm:py-20`
- **Gap Between Cards**: `gap-6`

### Admin Dashboard
- **Sidebar**: Fixed 256px, collapsible mobile
- **Content Area**: `flex-1 overflow-auto p-6`
- **Dashboard Cards**: Grid `grid-cols-2 md:grid-cols-4 gap-4`
- **Table**: `overflow-x-auto` + `min-w-[640px]`

---

## 🖼️ 7. Gambar & Media

### Standar Ukuran Gambar
| Jenis | Ukuran | Format | Max Size |
|-------|--------|--------|----------|
| Thumbnail Berita | 1200×628px | WebP | 50 KB |
| Foto Guru/Kepsek | 300×400px | WebP/JPEG | 50 KB |
| Galeri Unit | 800×600px | WebP | 50 KB |
| Logo Sekolah | 200×200px | PNG | 30 KB |
| Avatar User | 150×150px | WebP | 20 KB |

### Fallback Avatar
```html
<!-- Orang abu-abu default untuk testimoni/guru tanpa foto -->
<img src="/images/avatar-gray-person.svg" alt="Foto tidak tersedia">
```

---

## 📱 8. Responsive Breakpoints

```css
/* Tailwind defaults digunakan */
sm:  640px   /* Mobile landscape */
md:  768px   /* Tablet */
lg:  1024px  /* Desktop */
xl:  1280px  /* Large desktop */
2xl: 1536px  /* Ultra-wide */
```

Semua halaman dirancang **mobile-first**: layout 1 kolom di mobile, grid multi-kolom di tablet/desktop.
