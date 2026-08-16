# SmartEdu SIT Robbani — Technology Stack (TECH_STACK.md)

> **Dokumentasi Lengkap Pustaka, Framework, dan Infrastruktur Teknologi**

---

## 🛠️ 1. Backend & Server Framework

| Lapisan / Komponen | Teknologi Terpilih | Versi / Spesifikasi | Alasan Pemilihan & Penggunaan |
| :--- | :--- | :--- | :--- |
| **Bahasa Pemrograman** | **PHP** | `8.4+` | Ekosistem stabil, typed properties, performa JIT, penanganan multi-tenancy cepat. |
| **Framework Utama** | **Laravel** | `11.x / 12.x` | Arsitektur MVC, Eloquent ORM, Blade Templating, Middleware Pipeline, Seeding. |
| **PDF Generation** | **Barryvdh DomPDF** | `^3.0` | Cetak Kuitansi SPP ber-KOP, Kartu Ujian CBT, Rapor Siswa, dan Surat Resmi TTE. |
| **QR Code Generator** | **Simple QrCode** | `^4.2` | Membuat kode QR verifikasi TTE, presensi santri, dan validasi kuitansi publik. |
| **AI LLM API** | **Google Gemini API** | `gemini-1.5-flash` | Pemrosesan bahasa alami (NLP) chatbot dengan penalaran dokumen cepat dan hemat latensi. |

---

## 🎨 2. Frontend & User Interface Architecture

| Komponen | Teknologi | Keterangan Implementasi |
| :--- | :--- | :--- |
| **CSS Utility Framework** | **Tailwind CSS (v3/v4 CDN)** | Responsif fluid, grid bento hub, utility styling tanpa overhead build JS berat. |
| **JavaScript Framework** | **Alpine.js (v3.x)** | State management ringan (`x-data`, `x-show`, `x-model`, `x-cloak`) untuk modal, dark mode, tab filter, dan live clock. |
| **Typography & Fonts** | **Google Fonts (Montserrat & Inter)** | `Montserrat` untuk headline resmi berwibawa, `Inter` untuk konten keterbacaan tinggi. |
| **Icon System** | **Material Symbols Outlined + Authentic SVGs** | Ikon standar Google dengan variasi bobot `wght 700` dan SVG logo resmi medsos. |
| **Notifikasi Alert** | **SweetAlert2** | Alert modal modern dengan auto-timer 2.5 detik untuk feedback aksi user konsisten. |
| **Dark Mode System** | **Pure Custom CSS Obsidian & Neon Lime** | Kombinasi background `#061107` (Deep Obsidian Emerald) dan accent `#c6f634` (Electric Lemon) dengan rasio kontras WCAG AAA. |

---

## 🗄️ 3. Basis Data & Model Relasional

| Aspek | Spesifikasi | Detail |
| :--- | :--- | :--- |
| **DBMS Utama** | **MySQL / MariaDB** (atau SQLite untuk local test) | InnoDB engine, foreign key constraints, UTF-8 MB4 charset. |
| **ORM** | **Laravel Eloquent** | Relasi `hasMany`, `belongsTo`, `belongsToMany` dengan global scope multi-tenancy `school_id`. |
| **Migrasi & Seeders** | **Laravel Migration Pipeline** | 11+ migration file terstruktur dan seeder master otomatis (`UserSeeder`, `SchoolSeeder`, `AiKnowledgeSeeder`). |

---

## 🧠 4. Mesin AI & Knowledge Base RAG (Retrieval-Augmented Generation)

```
[User Input] 
     │
     ▼
[App\Services\AiRagEngine]
     ├── 1. Semantic Ingestion (`App\Models\AiKnowledgeBase::findRelevantKnowledge`)
     │        └── Mencocokkan kata kunci & cuplikan dokumen PDF yang diunggah
     ├── 2. Live SmartEdu Data Extraction
     │        └── Mengambil TA aktif, data unit sekolah, statistik SPMB, kontak
     ├── 3. Contextual Prompt Assembly
     │        └── Menggabungkan System Prompt + Cuplikan Dokumen + Live Data + Pertanyaan
     └── 4. Inference Engine
              ├── Mode Online: Google Gemini 1.5 Flash API
              └── Mode Fallback / Offline: Smart Local Synthesizer with Document Citation
```

---

## 🔒 5. Keamanan & Optimasi Jaringan

- **Middleware Kustom:** `App\Http\Middleware\SecurityHeaders`
  - `X-Frame-Options: SAMEORIGIN`
  - `X-Content-Type-Options: nosniff`
  - `X-XSS-Protection: 1; mode=block`
  - `Referrer-Policy: strict-origin-when-cross-origin`
- **Enkripsi & Hash:** SHA-256 untuk TTE Digital Surat Resmi, `bcrypt` untuk password pengguna.
- **Validasi Permintaan:** Laravel Form Request Validation & CSRF Protection Token.
