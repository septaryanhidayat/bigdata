# SmartEdu SIT Robbani — Technology Stack (TECH_STACK.md)

> **Dokumentasi Lengkap Pustaka, Framework, dan Infrastruktur Teknologi**
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 🛠️ 1. Backend & Server Framework

| Lapisan / Komponen | Teknologi Terpilih | Versi / Spesifikasi | Alasan Pemilihan & Penggunaan |
| :--- | :--- | :--- | :--- |
| **Bahasa Pemrograman** | **PHP** | `8.2+ / 8.4 (produksi)` | Ekosistem stabil, typed properties, performa JIT, penanganan multi-tenancy cepat. |
| **Framework Utama** | **Laravel** | `13.x` | Arsitektur MVC, Eloquent ORM, Blade Templating, Middleware Pipeline, Seeding. |
| **Asset Bundler** | **Vite** | `^6.x` | Build CSS/JS produksi — hasil di `public/build/` harus di-commit ke GitHub. |
| **PDF Generation** | **Barryvdh DomPDF** | `^3.0` | Cetak Kuitansi SPP ber-KOP, Kartu Ujian CBT, Rapor Siswa, dan Surat Resmi TTE. |
| **QR Code Generator** | **Simple QrCode** | `^4.2` | Membuat kode QR verifikasi TTE, presensi siswa, dan validasi kuitansi publik. |
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
| **DBMS Lokal (Dev)** | **SQLite** | Digunakan di lingkungan development lokal, file: `database/database.sqlite` (±20MB, 57 tabel). |
| **DBMS Produksi (cPanel)** | **MySQL 5.7+ / MariaDB 10.3+** | InnoDB engine, foreign key constraints, UTF-8 MB4 charset. Import dari `scratch/mysql_FINAL_sitrobbani.sql`. |
| **ORM** | **Laravel Eloquent** | Relasi `hasMany`, `belongsTo`, `belongsToMany` dengan global scope multi-tenancy `school_id`. |
| **Migrasi & Seeders** | **Laravel Migration Pipeline** | 11+ migration file terstruktur dan seeder master otomatis. |

> ⚠️ **PENTING:** Di `.env` produksi, `DB_CONNECTION=mysql`. Di lokal, `DB_CONNECTION=sqlite`.

---

## 📱 4. Aplikasi Mobile (SDM SIT Robbani)

| Komponen | Teknologi | Detail |
| :--- | :--- | :--- |
| **Framework** | **React Native (Expo SDK 52)** | Cross-platform Android & iOS dari folder `sdm-robbani-mobile/`. |
| **Distribusi** | **EAS Build (Expo Application Services)** | APK Android via `eas build --platform android`. |
| **Auth** | **Laravel Sanctum Token** | Semua endpoint `/api/v1/mobile/*` kecuali login dilindungi `auth:sanctum`. |
| **Fitur** | Presensi GPS/Face Recognition, Payroll, BPI Mutabaah, Kantin Digital, KPI | |

---

## 🧠 5. Mesin AI & Knowledge Base RAG

```
[User Input] 
     │
     ▼
[App\Services\AiRagEngine]
     ├── 1. Semantic Ingestion (AiKnowledgeBase::findRelevantKnowledge)
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

## 🔒 6. Keamanan & Optimasi Jaringan

- **Middleware Kustom:** `App\Http\Middleware\SecurityHeaders` (global, terpasang di `bootstrap/app.php`)
  - `X-Content-Type-Options: nosniff`
  - `X-Frame-Options: SAMEORIGIN`
  - `X-XSS-Protection: 1; mode=block`
  - `Referrer-Policy: strict-origin-when-cross-origin`
  - `Permissions-Policy: camera=(), microphone=(), geolocation=()`
- **Enkripsi & Hash:** SHA-256 untuk TTE Digital Surat Resmi, `bcrypt` untuk password pengguna.
- **Validasi Permintaan:** Laravel Form Request Validation & CSRF Protection Token.
- **API Auth:** Laravel Sanctum token untuk seluruh endpoint mobile (kecuali login).

---

## 🌐 7. Infrastruktur Produksi — cPanel Hosting

| Komponen | Spesifikasi | Keterangan |
| :--- | :--- | :--- |
| **Hosting** | **cPanel (Shared/VPS)** | Deployment via Git Version Control cPanel |
| **PHP CLI Produksi** | `/usr/local/php84/bin/php` | Gunakan path eksplisit, bukan `php` default (bisa 8.1) |
| **Web Server** | **Apache + .htaccess** | DocumentRoot diarahkan ke `/public` folder Laravel |
| **Database** | **MySQL cPanel** | Import dari `scratch/mysql_FINAL_sitrobbani.sql` |
| **Assets** | **Vite Build (pre-built)** | `public/build/` ter-commit di GitHub, tidak perlu Node.js di server |
| **Storage** | `storage/app/public` symlink ke `public/storage` | Via `php artisan storage:link` |
| **Deploy Script** | `bash deploy.sh` | Otomatis maintenance mode, migrate, cache, optimize |

> **Catatan:** Untuk production VPS mandiri (masa depan): Nginx + PHP-FPM 8.4 + Redis + Supervisor
