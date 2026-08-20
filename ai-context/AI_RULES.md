# SmartEdu SIT Robbani — AI & Development Rules

> *Panduan Wajib untuk AI Coding Assistant & Developer*  
> *Terakhir diperbarui: 18 Agustus 2026*

---

## 🧠 1. Identitas Sistem

- **Nama Platform**: SmartEdu SIT Robbani
- **Pemilik**: Yayasan Generasi Robbani Sumatera Selatan
- **Pengembang**: Beranda Teknologi Digital
- **Repository GitHub**: `https://github.com/septaryanhidayat/bigdata`
- **Domain Produksi**: `https://sitrobbani.sch.id`
- **Bahasa Utama**: Bahasa Indonesia (UI, commit, komentar kode)
- **Framework**: Laravel 13.x / PHP 8.4 / SQLite (dev) / MySQL (prod)

---

## 📋 2. Konvensi Penamaan & Commit

### Git Commit (WAJIB Bahasa Indonesia)
```bash
# Format: <type>: <deskripsi singkat dalam Bahasa Indonesia>

# Jenis commit:
feat:    # Fitur baru
fix:     # Perbaikan bug
refactor: # Refaktor kode (tanpa mengubah perilaku)
chore:   # Update dependencies, config, dokumentasi
style:   # Perubahan tampilan/CSS tanpa logika
security: # Perbaikan keamanan

# Contoh commit yang benar:
git commit -m "feat: Tambahkan tab pengaturan Profil Yayasan di CMS Admin"
git commit -m "fix: Perbaiki bug tampilan galeri foto di halaman beranda"
git commit -m "security: Tambahkan rate limiter pada endpoint chat AI publik"
```

### Konvensi Kode
- **Blade variables**: `{{ $var }}` (auto-escape XSS) — JANGAN gunakan `{!! $var !!}` kecuali untuk konten HTML yang sudah disanitasi
- **Controller methods**: camelCase, Bahasa Inggris
- **Route names**: kebab-case dengan prefix unit (`admin.cms.content`, `school.berita.show`)
- **Database columns**: snake_case
- **Config keys**: dot notation (`site_settings.school_name`)

---

## 🏫 3. Terminologi Wajib

| Istilah Benar | JANGAN Gunakan |
|---------------|----------------|
| Yayasan Generasi Robbani | Robbani Foundation |
| KB/TKIT Robbani | TK Robbani |
| SDIT Robbani | SD Islam Robbani |
| SMPIT Robbani | SMP IT Robbani |
| SMAIT Robbani | SMA IT Robbani |
| Mutabaah Yaumiyah | Daily Checklist |
| Tahfidz Al-Qur'an | Hafalan Quran |
| BPI (Bina Pribadi Islam) | Karakter |
| JSIT | Jaringan Sekolah Islam Terpadu |
| SPMB Online | PSB / PPDB |
| TTE (Tanda Tangan Elektronik) | E-Signature / Digital Signature |
| Portal Yayasan | Website Yayasan |
| Kepala Sekolah | Kepsek |
| Staf TU | Admin Sekolah |

---

## 🔐 4. Aturan Keamanan WAJIB

### Multi-Tenancy Scoping
```php
// ✅ BENAR: Semua query data per-unit HARUS menggunakan school_id
$students = Student::where('school_id', auth()->user()->school_id)->get();

// ✅ Atau lebih baik gunakan scope:
$students = Student::forSchool(auth()->user()->school_id)->get();

// ❌ SALAH: Query tanpa filter school_id (kebocoran data antar-unit!)
$students = Student::all(); // DILARANG kecuali Super Admin
```

### Input Sanitization
```php
// ✅ BENAR: Gunakan Eloquent/validated data
$title = $request->validated()['title'];

// ✅ Blade auto-escape untuk output
{{ $news['title'] }}

// ❌ SALAH: Raw output tanpa escape
{!! $userInput !!} // HANYA untuk HTML yang sudah dipercaya
```

### API Security
```php
// ✅ Semua endpoint API protected HARUS menggunakan middleware
Route::middleware('auth:sanctum')->group(function () {
    // endpoint di sini
});

// ❌ JANGAN expose endpoint sensitif tanpa auth
Route::get('/api/employees', ...); // DILARANG tanpa Sanctum
```

---

## 🎨 5. Standar UI/UX

### Warna Tema
```css
/* Light Mode */
--primary: #004532;    /* Emerald Deep Green */
--accent: #ea580c;     /* Orange-600 */

/* Dark Mode Obsidian */
--bg-dark: #040d06;    /* Obsidian Emerald */
--neon: #c6f634;       /* Neon Lime */
```

### Komponen UI Standar
- **Tombol Aksi Utama**: `bg-emerald-600 hover:bg-emerald-700 text-white font-black`
- **Tombol Bahaya/Hapus**: `bg-rose-600 hover:bg-rose-700 text-white`
- **Badge Unit TKIT**: `bg-emerald-100 text-emerald-800`
- **Badge Unit SDIT**: `bg-orange-100 text-orange-800`
- **Badge Unit SMPIT**: `bg-blue-100 text-blue-800`
- **Badge Unit SMAIT**: `bg-purple-100 text-purple-800`
- **Konfirmasi Hapus**: Wajib menggunakan SweetAlert2 (`confirmDeleteSingle()`)

---

## 🚫 6. Larangan Konten

Filter otomatis AKTIF untuk:
- Judol (judi online), pinjol (pinjaman online)
- SARA (Suku, Agama, Ras, Antargolongan)
- Kekerasan, pornografi, konten dewasa
- LGBT / konten menyimpang
- Barang haram, miras, narkoba
- Konten provokatif / hoaks / berita palsu

Konten yang terdeteksi akan **otomatis dihapus** dari tampilan publik.

---

## 📁 7. Struktur File Penting

```
bigdata/
├── app/Http/Controllers/
│   ├── SchoolWebsiteController.php   ← 1584 baris, controller web publik utama
│   ├── Admin/CmsController.php       ← 1895 baris, dashboard admin
│   ├── Admin/HrisMobileApiController ← 54KB, semua endpoint API mobile
│   └── Api/HrisMobileApiController.php
├── resources/views/
│   ├── school/home.blade.php         ← Beranda utama (200KB)
│   ├── school/unit.blade.php         ← Profil 4 unit (94KB)
│   ├── school/profil.blade.php       ← Profil Yayasan
│   ├── school/ppdb.blade.php         ← SPMB Online (64KB)
│   └── admin/cms/content.blade.php   ← CMS Dashboard
├── database/
│   ├── migrations/                   ← 27 file migration
│   └── seeders/                      ← 7 seeder
├── ai-context/                       ← Dokumentasi master sistem
├── sdm-robbani-mobile/               ← Aplikasi React Native Expo
└── smartedu_FINAL_sitrobbani.sql     ← Database MySQL produksi (2.14 MB)
```

---

## 📤 8. Export & Deployment

### Export MySQL Produksi
```bash
# Jalankan script export penuh (SQLite → MySQL):
php scratch/export_full_to_mysql.php
# Output: smartedu_FINAL_sitrobbani.sql (2.14 MB, 58 tabel)
```

### Deploy ke cPanel
```bash
# 1. Git pull di server:
git pull origin main

# 2. Install/update composer:
composer install --no-dev --optimize-autoloader

# 3. Optimize:
php artisan optimize:clear
php artisan optimize
php artisan storage:link

# 4. Set permissions:
chmod -R 755 storage bootstrap/cache
```
