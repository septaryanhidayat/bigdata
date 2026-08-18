# SmartEdu SIT Robbani — System Architecture

> *Versi 3.0 Final — 18 Agustus 2026*

---

## 🏗️ 1. Diagram Sistem Keseluruhan

```
┌───────────────────────────────────────────────────────────────────┐
│                    SMARTEDU SIT ROBBANI v3.0                      │
│              (All-in-One Educational ERP + Web Portal)             │
├─────────────────────┬─────────────────────┬───────────────────────┤
│   🌐 WEB PUBLIK     │   🛠️ DASHBOARD ADMIN │   📱 MOBILE APP       │
│   (SchoolWebsite-   │   (Admin Dashboard  │   (React Native Expo  │
│    Controller.php)  │    15 Peran RBAC)   │    SDK 52)            │
│   (100KB+ lines)    │   (20 Controllers)  │   (sdm-robbani-mobile)│
├─────────────────────┴─────────────────────┴───────────────────────┤
│                     LARAVEL 13.x (Bootstrap/App)                  │
│              Routing → Middleware → Controller → View             │
├────────────────────────────┬──────────────────────────────────────┤
│         SQLITE 3 (dev)     │    MYSQL / MARIADB (prod cPanel)     │
│   database/database.sqlite │    58 Tabel InnoDB utf8mb4           │
└────────────────────────────┴──────────────────────────────────────┘
```

---

## 🔄 2. Alur Request-Response

```
User Browser / Mobile App
         │
         ▼
[DNS / Domain sitrobbani.sch.id]
         │
         ▼
[cPanel Nginx/Apache → public/index.php]
         │
         ▼
[bootstrap/app.php → Kernel Pipeline]
     ┌───┴───────────────────────────────┐
     │ Middleware Stack:                 │
     │ 1. SecurityHeaders (X-Frame, CSP)│
     │ 2. ValidatePostSize (Custom)      │
     │ 3. CSRF Token Validation          │
     │ 4. Auth (Sanctum / Session)       │
     │ 5. CheckRole (RBAC 15 Peran)      │
     └───────────────────┬───────────────┘
                         ▼
               [Route Dispatcher]
          ┌─────────────┼──────────────┐
          ▼             ▼              ▼
    [Web Routes]  [API Routes]  [Admin Routes]
    public pages  /api/v1/mobile /admin/* RBAC
          │             │              │
          ▼             ▼              ▼
   [Controllers]  [API Controllers] [Admin Controllers]
   - SchoolWebsite  - HrisMobileApi  - CmsController
   - LandingPage    - AttendanceApi  - MasterData
   - LetterVerify                    - Finance, etc.
          │             │              │
          └─────────────┼──────────────┘
                         ▼
              [Eloquent ORM → SQLite/MySQL]
                    (58 Tabel)
```

---

## 🏢 3. Multi-Tenancy Architecture

Seluruh tabel yang mengandung data per-unit memiliki kolom `school_id`:

```php
// school_id = null  → Yayasan (data global)
// school_id = 1     → KB/TKIT Robbani
// school_id = 2     → SDIT Robbani
// school_id = 3     → SMPIT Robbani
// school_id = 4     → SMAIT Robbani

// Query wajib menggunakan scoping:
if (!$user->isSuperAdmin() && $user->school_id) {
    $query->where('school_id', $user->school_id);
}
```

### Tabel dengan Multi-Tenancy `school_id`:
`students`, `employees`, `classrooms`, `subjects`, `attendances`, `grades`, `kbm_journals`, `schedules`, `student_leaves`, `spp_bills`, `spp_payments`, `canteen_outlets`, `canteen_products`, `canteen_transactions`, `savings_transactions`, `bpi_mutabaahs`, `bk_records`, `sarpras_assets`, `library_books`, `lms_materials`, `cbt_exams`, `payroll_salaries`, `official_letters`, `letter_templates`, `ppdb_registrations`

---

## 📝 4. Siklus Persuratan & TTE Digital

```
[BUAT SURAT KELUAR]
     │ → Pilih template KOP unit
     │ → Editor teks surat
     │ → Preview PDF DomPDF
     ▼
[ANTRIAN TTE]
     │ → Pimpinan review surat
     │ → Klik "Tandatangani Resmi"
     ▼
[PROSES TTE]
     │ → Generate UUID token unik
     │ → Hash SHA-256 isi surat
     │ → Simpan ke digital_signatures + letter_audit_trails
     │ → Embed QR Code verifikasi ke PDF
     ▼
[DOKUMEN FINAL]
     │ → PDF ber-QR TTE dapat diunduh
     │ → Publik bisa verifikasi via /verifikasi-surat/{token}
```

---

## 🛡️ 5. Security Architecture (7 Lapisan)

```
L1: AUTH GUARD + SESSION
    ├── Laravel Auth Middleware (web session)
    └── Redirect ke /admin/login jika unauthenticated

L2: ROLE-BASED ACCESS CONTROL (RBAC)
    ├── CheckRole middleware: 15 peran, strict string match
    └── Super Admin bypass semua check

L3: MULTI-TENANCY SCOPING
    ├── school_id filter wajib pada semua query data unit
    └── Mencegah kebocoran data antar-unit

L4: SQL INJECTION DEFENSE
    ├── Eloquent ORM dengan PDO parameter binding
    └── Tidak ada raw query tanpa binding

L5: XSS + CSRF DEFENSE
    ├── Blade template auto-escape {{ $var }}
    ├── CSRF token wajib di semua form POST
    └── Exception CSRF: /cms/import-wordpress (file upload besar)

L6: SECURITY HEADERS
    ├── X-Content-Type-Options: nosniff
    ├── X-Frame-Options: SAMEORIGIN
    ├── X-XSS-Protection: 1; mode=block
    ├── Referrer-Policy: strict-origin-when-cross-origin
    └── Permissions-Policy: camera=(), microphone=(), geolocation=()

L7: TTE SHA-256 CRYPTOGRAPHY
    ├── Hash digital isi surat dengan SHA-256
    └── UUID publik unik untuk verifikasi keaslian dokumen

L8 (API): SANCTUM BEARER TOKEN
    ├── Semua endpoint /api/v1/mobile/* (kecuali login) require auth:sanctum
    └── Token di-expire saat logout
```

---

## 🌐 6. Website Publik — Arsitektur Halaman

| Route | View | Controller Method |
|-------|------|-------------------|
| `/` | `school/home.blade.php` (200KB) | `index()` |
| `/profil` | `school/profil.blade.php` | `profil()` |
| `/unit/{code}` | `school/unit.blade.php` (94KB) | `unitProfile()` |
| `/berita` | `school/berita/index.blade.php` | `beritaIndex()` |
| `/berita/{slug}` | `school/berita/show.blade.php` | `beritaShow()` |
| `/artikel` | `school/artikel/index.blade.php` | `artikelIndex()` |
| `/artikel/{slug}` | `school/artikel/show.blade.php` | `artikelShow()` |
| `/fasilitas` | `school/fasilitas.blade.php` | `fasilitas()` |
| `/ppdb` | `school/ppdb.blade.php` (64KB) | `ppdbForm()` |
| `/e-spp` | `school/espp.blade.php` | `eSppCheck()` |
| `/sitemap.xml` | (XML response) | `sitemapXml()` |
| `/robots.txt` | (TXT response) | `robotsTxt()` |

---

## 🚀 7. Deployment cPanel Architecture

```
sitrobbani.sch.id (Domain Utama)
├── DocumentRoot → ~/bigdata/public/
│   ├── index.php (Laravel entry point)
│   ├── build/ (Vite compiled assets, committed to git)
│   ├── uploads/ (User uploads, gambar, PDF)
│   └── .htaccess (URL rewrite rules)
│
~/bigdata/ (Laravel Root, di luar public/)
├── app/, config/, database/, routes/, resources/
├── vendor/ (Composer, tidak di-git)
├── .env (Konfigurasi produksi, tidak di-git)
└── smartedu_FINAL_sitrobbani.sql (Import MySQL)

Subdomain:
├── spmb.sitrobbani.sch.id → ppdbForm()
├── tk.sitrobbani.sch.id → unitProfile('tkit')
├── sd.sitrobbani.sch.id → unitProfile('sdit')
├── smp.sitrobbani.sch.id → unitProfile('smpit')
└── sma.sitrobbani.sch.id → unitProfile('smait')
```
