# SmartEdu SIT Robbani — System Architecture (ARCHITECTURE.md)

> **Dokumentasi Arsitektur Sistem, Multi-Tenancy, Alur TTE, dan Topologi Deployment**
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 🏗️ 1. Arsitektur Monolitik Multi-Modul

SmartEdu menggunakan arsitektur **Laravel Monolith** yang mencakup tiga lapisan aplikasi dalam satu codebase:

```
┌─────────────────────────────────────────────────────────────┐
│                   sitrobbani.sch.id                         │
│   ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐ │
│   │  Website     │  │  Dashboard   │  │   API Mobile     │ │
│   │  Publik      │  │  Admin       │  │   /api/v1/       │ │
│   │  /           │  │  /admin/     │  │   (Sanctum Auth) │ │
│   └──────────────┘  └──────────────┘  └──────────────────┘ │
│              │              │                  │             │
│              └──────────────┴──────────────────┘            │
│                             │                               │
│              ┌──────────────▼──────────────┐               │
│              │   Laravel Application Core   │               │
│              │   Controllers / Services     │               │
│              │   Eloquent ORM / Models      │               │
│              └──────────────┬──────────────┘               │
│                             │                               │
│              ┌──────────────▼──────────────┐               │
│              │  Database (SQLite/MySQL)     │               │
│              │  57 Tabel, Multi-Tenancy     │               │
│              └─────────────────────────────┘               │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔐 2. Arsitektur Multi-Tenancy (school_id Scoping)

```
User Login → CheckRole Middleware
     │
     ├── school_id: null → SUPER_ADMIN / YAYASAN_CHAIRMAN
     │       └── Akses semua unit (TKIT + SDIT + SMPIT + SMAIT)
     │
     ├── school_id: 1 → Akun TKIT Robbani
     │       └── Hanya akses data school_id = 1
     │
     ├── school_id: 2 → Akun SDIT Robbani
     │       └── Hanya akses data school_id = 2
     │
     ├── school_id: 3 → Akun SMPIT Robbani
     │       └── Hanya akses data school_id = 3
     │
     └── school_id: 4 → Akun SMAIT Robbani
             └── Hanya akses data school_id = 4
```

**Implementasi Scoping:**
```php
// Di setiap Controller yang sensitif
$user = auth()->user();
$query = Model::query();
if ($user->school_id !== null) {
    $query->where('school_id', $user->school_id);
}
```

---

## ✍️ 3. Alur Persuratan Digital & TTE (Tanda Tangan Elektronik)

```
[Draft Surat] → [Pengiriman ke Kepala / Yayasan]
      │
      ▼
[Verifikasi & Persetujuan Pimpinan]
      │
      ▼
[Generate SHA-256 Hash + UUID Token]
      │                    │
      ▼                    ▼
[Simpan ke DB]    [Generate QR Code]
      │                    │
      └──────────┬─────────┘
                 ▼
        [Surat PDF ber-KOP + QR TTE]
                 │
                 ▼
  [Publik scan QR → /verifikasi-surat/{token}]
  [Verifikasi hash & autentisitas dokumen]
```

---

## 🤖 4. Arsitektur AI RAG (Retrieval-Augmented Generation)

```
Dokumen PDF (Brosur SPMB, SOP)
     │
     ▼ AiRagEngine::ingestDocument()
[ai_knowledge_bases table]
     │ fulltext / keyword search
     ▼
[User Query via Chatbot]
     │
     ▼ AiKnowledgeBase::findRelevantKnowledge($query)
[Cuplikan Dokumen Relevan]
     │
     ├── + Live Data SmartEdu (TA aktif, kontak, unit)
     ▼
[Contextual Prompt Assembly]
     │
     ├── Mode Online: Google Gemini 1.5 Flash API
     └── Mode Fallback: Local Synthesizer
           │
           ▼
[Streaming Response + Typing Animation]
```

---

## 🚀 5. Arsitektur Deployment cPanel

```
[Developer Lokal]
     │
     ├── npm run build → public/build/
     ├── git add -A && git commit -m "..."
     └── git push origin main
              │
              ▼
        [GitHub Repository]
        septaryanhidayat/bigdata
              │
              ▼ git pull / cPanel Git Version Control
        [cPanel Server]
        ~/bigdata/
              │
              ├── DocumentRoot → ~/bigdata/public/
              ├── PHP: /usr/local/php84/bin/php
              ├── DB: MySQL cPanel (namauser_sitrobbani)
              └── bash deploy.sh
                    │
                    ├── php artisan down (maintenance)
                    ├── git pull origin main
                    ├── composer install --no-dev
                    ├── php artisan migrate --force
                    ├── php artisan config:cache
                    ├── php artisan route:cache
                    ├── php artisan storage:link
                    └── php artisan up
```

---

## 📁 6. Struktur Direktori Kunci

```
bigdata/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # 20 controller dashboard admin
│   │   │   ├── Api/            # API mobile (Sanctum protected)
│   │   │   └── SchoolWebsiteController.php  # Website publik
│   │   └── Middleware/
│   │       ├── SecurityHeaders.php   # Global security headers
│   │       └── CheckRole.php         # RBAC middleware
│   └── Services/
│       └── AiRagEngine.php     # AI chatbot service
├── public/
│   ├── build/                  # Vite compiled assets (di-commit ke Git)
│   ├── uploads/
│   │   ├── wp_assets/          # Foto guru & aset dari WordPress
│   │   └── xml/                # Backup XML WordPress per unit
│   └── index.php               # Entry point Laravel
├── resources/views/
│   ├── school/                 # Template website publik
│   └── admin/                  # Template dashboard admin
├── routes/
│   ├── web.php                 # 196 web routes
│   └── api.php                 # API mobile routes (Sanctum auth)
├── ai-context/                 # Dokumentasi sistem untuk AI agents
├── scratch/
│   └── mysql_FINAL_sitrobbani.sql  # Database export untuk cPanel
├── deploy.sh                   # Script deploy otomatis
├── cpanel_setup.php            # Script setup pertama kali
└── .env.cpanel                 # Template .env produksi
```
