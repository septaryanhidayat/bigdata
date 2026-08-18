# SmartEdu SIT Robbani — Tech Stack

> *Versi 3.0 Final — 18 Agustus 2026*

---

## 🖥️ Backend

| Komponen | Versi / Library | Keterangan |
| :--- | :--- | :--- |
| **PHP** | 8.4.x (cPanel) / 8.4.24 (Lokal Herd) | PHP 8.4 strict types, named args |
| **Laravel** | 13.24.x | Framework backend utama |
| **Database Dev** | SQLite 3 | `database/database.sqlite`, excluded dari git |
| **Database Prod** | MySQL 5.7+ / MariaDB 10.3+ | 58 tabel InnoDB, `smartedu_FINAL_sitrobbani.sql` |
| **ORM** | Eloquent ORM | Semua query wajib via Eloquent (PDO binding) |
| **Auth** | Laravel built-in + Sanctum | Web session + API Bearer Token |
| **Queue** | Database Queue | Job, failed_jobs, job_batches |
| **PDF** | DomPDF (`barryvdh/laravel-dompdf`) | Kuitansi SPP, Slip Gaji, Kartu Ujian |
| **QR Code** | `simplesoftwareio/simple-qrcode` | QR TTE surat, RFID, barcode sarpras |
| **AI/LLM** | Google Gemini 1.5 Flash API | Mesin RAG Chatbot, embedding retrieval |
| **HTTP Client** | Guzzle (via Laravel HTTP) | Panggilan API eksternal (Gemini, dll.) |

---

## 🎨 Frontend & Styling

| Komponen | Versi | Keterangan |
| :--- | :--- | :--- |
| **Tailwind CSS** | CDN v4 (web publik) + v3 Vite (admin) | Utility-first CSS |
| **Alpine.js** | 3.x (CDN) | State management reaktif frontend |
| **SweetAlert2** | Latest CDN | Dialog konfirmasi hapus, notifikasi |
| **Vite** | 6.x | Asset bundler admin dashboard |
| **Google Fonts** | Plus Jakarta Sans | Tipografi premium website & admin |
| **Font Awesome / SVG** | Inline SVG | Icon share sosmed, admin sidebar |
| **Chart.js** | CDN | Grafik statistik di dashboard |

---

## 🎨 Design Tokens

```css
/* Light Mode */
--primary: #004532;       /* Emerald Deep Green */
--accent: #ea580c;        /* Orange-600 */
--bg: #f8fafc;            /* Slate-50 */

/* Dark Mode (Obsidian + Neon Lime) */
--bg-dark: #040d06;       /* Obsidian Emerald */
--surface-dark: #07170a;  /* Dark Green Surface */
--neon: #c6f634;          /* Neon Lime Accent */
--neon-bright: #a3e635;   /* Lime-400 */
```

---

## 📱 Aplikasi Mobile

| Komponen | Versi | Keterangan |
| :--- | :--- | :--- |
| **Framework** | Expo SDK 52 + React Native | Folder `sdm-robbani-mobile/` |
| **Auth** | Laravel Sanctum Bearer Token | Login → token → simpan SecureStore |
| **Navigation** | Expo Router v3 | File-based routing |
| **State** | React Context API | Auth context, user profile |
| **Storage** | Expo SecureStore | Penyimpanan token aman |
| **Camera** | Expo Camera | Capture foto biometrik wajah |
| **Location** | Expo Location | GPS anti-fake presensi |
| **HTTP** | Axios | REST API client |

---

## 🗄️ Database

| Environment | Koneksi | File |
|-------------|---------|------|
| **Development (Lokal)** | SQLite 3 | `database/database.sqlite` (~20MB) |
| **Produksi (cPanel)** | MySQL / MariaDB | Import `smartedu_FINAL_sitrobbani.sql` (2MB+) |

### Konfigurasi `.env` Produksi
```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=namauser_sitrobbani
DB_USERNAME=namauser_sitrobbani
DB_PASSWORD=PASSWORD_MYSQL_CPANEL
```

---

## 🚀 Deployment (cPanel)

| Langkah | Perintah / File |
|---------|-----------------|
| 1. Clone Git | `git clone https://github.com/septaryanhidayat/bigdata.git ~/bigdata` |
| 2. Copy `.env` | Salin `.env.cpanel` → `.env`, isi password MySQL |
| 3. Install deps | `composer install --no-dev --optimize-autoloader` |
| 4. Generate key | `php artisan key:generate` |
| 5. Import SQL | phpMyAdmin → Import `smartedu_FINAL_sitrobbani.sql` |
| 6. Migrate (ops) | `php artisan migrate --force` (opsional jika sudah import SQL) |
| 7. Link storage | `php artisan storage:link` |
| 8. Optimize | `php artisan optimize` |
| 9. Set permissions | `chmod -R 755 storage bootstrap/cache` |

> **Catatan**: `public/build/` sengaja **di-commit ke Git** sehingga cPanel tidak memerlukan Node.js untuk build Vite.

---

## 🔧 Tools Pengembangan

| Tool | Versi | Keterangan |
|------|-------|------------|
| Laravel Herd | Windows | Dev server lokal PHP 8.4 |
| VS Code | Latest | IDE dengan Intelephense & Tailwind |
| Git | 2.x | Version control |
| GitHub | `septaryanhidayat/bigdata` | Repository utama |
| Postman | Latest | Testing REST API endpoint |
