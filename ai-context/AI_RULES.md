# SmartEdu SIT Robbani — AI & Developer Rules (AI_RULES.md)

> **Pedoman Wajib bagi AI Agent, Developer, dan Kontributor Kode Sistem SmartEdu**
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 📌 1. Prinsip Utama Multi-Tenancy Scoping

1. **Aturan Isolasi Data Unit:**
   - Setiap query yang mengambil data siswa, karyawan, kelas, tagihan, persuratan, atau CMS unit **WAJIB** menerapkan pengecekan `school_id`:
     ```php
     if ($user->school_id !== null) {
         $query->where('school_id', $user->school_id);
     }
     ```
   - Pengguna dengan peran `STAFF_TU` atau `HEADMASTER` tidak boleh dapat mengakses data unit lain melalui manipulasi parameter URL (`ID tampering`).
2. **Akun Yayasan & Super Admin:**
   - Hanya `SUPER_ADMIN` dan `YAYASAN_CHAIRMAN` yang memiliki `user->school_id == null` dan berhak melihat data konsolidasi 4 unit.

---

## 🔤 2. Konvensi Terminologi & Data Kepemimpinan

1. **Terminologi Wajib:**
   - Selalu gunakan **"siswa"** (DILARANG menggunakan kata "santri" untuk peserta didik).
   - Istilah "wali murid" atau "wali siswa" (bukan "wali santri").

2. **Data Kepemimpinan Real (JANGAN DIUBAH):**
   - **Ketua Yayasan:** Sughesti Wulandari, S.Pd
   - **Kepala KB/TKIT Robbani:** Ani Oktar Yansi, S.Pd.I
   - **Kepala SDIT Robbani:** Nur Amalia, S.Pd
   - **Kepala SMPIT Robbani:** Tia Wulandari, S.Pd., Gr.
   - **Wakil Kepala SDIT:** Dian Kemala Astuti, S.Pd

3. **Sumber Data Guru:**
   - Nama dan jabatan guru **WAJIB** diambil dari file XML backup WordPress di `public/uploads/xml/`.
   - Field jabatan: `<category domain="jab">` dari file XML.
   - Foto: file dengan prefix `gtk_sd_`, `gtk_tk_`, `gtk_smp_` di `public/uploads/wp_assets/`.

---

## 🎨 3. Standar UI/UX, Dark Mode & Tipografi

1. **Sistem Dark Mode:**
   - Background Utama Mode Gelap: `#061107` (Deep Obsidian Emerald).
   - Card Surface: `#0e2010` / `#0d1e0f` dengan border `#1a381c`.
   - Warna Aksen Utama: `#c6f634` (Electric Lemon / Neon Lime).
   - **Kaidah Kontras Teks (WCAG AAA):**
     - Pada latar belakang neon lime (`bg-[#c6f634]` atau `bg-amber-500`), teks **WAJIB** berwarna gelap pekat (`text-[#061107]` atau `text-slate-950 font-black`), **DILARANG KERAS** menggunakan teks warna putih.
2. **Dashboard Admin — 5 Pilihan Tema Warna Global:**
   - Tema warna dashboard dipilih dari 5 opsi via pengaturan global (bukan hardcode per komponen).
   - Pastikan kontras teks vs background cukup (rasio minimum 4.5:1 WCAG AA).
3. **Animasi & Interaktivitas:**
   - Gunakan kelas `.reveal-fade-up` untuk animasi scroll cepat (0.4s).
   - Jangan gunakan library JS berat jika interaktivitas dapat ditangani oleh **Alpine.js**.

---

## 🛡️ 4. Keamanan Siber & Validasi (*Cybersecurity Hardening*)

1. **Anti SQL Injection:**
   - Dilarang membuat raw concatenation pada SQL query (`DB::raw("... WHERE id = $id")`).
   - Wajib menggunakan Eloquent ORM atau parameterized binding (`DB::select("... WHERE id = ?", [$id])`).
   - `DB::raw()` **hanya boleh** untuk aggregate (SUM, COUNT) dengan kolom statis, bukan input user.
2. **API Authentication — WAJIB Sanctum:**
   - Semua endpoint `/api/v1/mobile/*` kecuali `/auth/login` **WAJIB** di-protect dengan `middleware('auth:sanctum')`.
   - Jangan pernah melepas middleware auth dari route yang mengembalikan data sensitif (payroll, presensi, profil).
3. **Keamanan Persuratan TTE:**
   - Setiap surat yang disetujui harus menghasilkan hash digital SHA-256 dan token UUID unik untuk verifikasi scan QR publik.
4. **Security Headers Middleware:**
   - Pertahankan middleware `SecurityHeaders` pada global pipeline untuk mencegah clickjacking dan MIME-sniffing.
   - Header yang wajib ada: `X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`.
5. **Upload File:**
   - Validasi tipe MIME dan ekstensi file yang diizinkan (hanya `.jpg`, `.jpeg`, `.png`, `.pdf`).
   - Simpan file upload di `storage/app/public/` (bukan di `public/` langsung).
   - Jangan eksekusi PHP dari folder upload.

---

## 🤖 5. Standar Pembelajaran AI Chatbot & Knowledge Base RAG

1. **Ekstraksi Dokumen PDF:**
   - Semua SOP, Brosur SPMB, dan Panduan Sekolah baru wajib dimasukkan ke tabel `ai_knowledge_bases` melalui `AiRagEngine::ingestDocument()`.
2. **Anti-Halusinasi:**
   - Chatbot AI harus memprioritaskan cuplikan dokumen asli dan data realtime sekolah (Tahun Ajaran aktif, unit, kontak) sebelum memberikan jawaban kepada wali murid.
3. **UX Chatbot:**
   - Respon AI harus ditampilkan dengan efek **typing animation** karakter per karakter, bukan langsung muncul semua.
   - Jawaban harus relevan dan ringkas, bukan template panjang.

---

## 📝 6. Standar Blade Templating & Scripting

1. **JSON-LD Schema.org Gotcha:**
   - Blade parser Laravel menganggap simbol `@` sebagai directive. **DILARANG** menulis `@context` atau `@type` secara mentah di Blade.
   - Wajib di-encode via PHP:
     ```blade
     {!! json_encode([...], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
     ```
2. **Notifikasi Alert:**
   - Gunakan **SweetAlert2** untuk semua respon user (sukses simpan, error validasi, konfirmasi hapus) dengan auto-timer 2.5 detik.

---

## 🧪 7. Pedoman Pengujian Otomatis & Mocking Layanan Berbayar

1. **Framework Pengujian:**
   - Proyek mendukung **PHPUnit** / **Pest PHP** serta skrip mandiri (*Self-Contained CLI Test Suite*) berbasis artisan bootstrap.
2. **Aturan Wajib Feature Test:**
   - Setiap penambahan rute HTTP dan Controller baru **WAJIB** disertai skrip pengujian untuk memvalidasi:
     - Respons status HTTP (200 OK, 302 Redirect, 403 Forbidden untuk unauthorized role).
     - Isolasi data multi-tenancy (pastikan akun unit A ditolak saat mengakses data unit B).
     - Integritas data di basis data (`assertDatabaseHas` / `assertDatabaseMissing`).
3. **Mocking Layanan Berbayar & Pihak Ketiga (*Zero-Cost Testing Rule*):**
   - **Google Gemini API:** **DILARANG KERAS** memanggil API live Google Gemini berulang kali saat automated test berjalan untuk menghemat kuota dan biaya.
     ```php
     Http::fake([
         'generativelanguage.googleapis.com/*' => Http::response([
             'candidates' => [
                 ['content' => ['parts' => [['text' => 'Jawaban AI Ter-Mocking']]]]
             ]
         ], 200)
     ]);
     ```
   - **Payment Gateway (Midtrans/Xendit):** Gunakan mock webhook payload dengan SHA512 signature valid lokal untuk menguji alur pelunasan faktur tanpa transaksi nyata.
   - **WhatsApp Gateway:** Mock pemanggilan HTTP outbound ke endpoint WA API.

---

## 📦 8. Konvensi Git Commit & Deployment

1. **Bahasa Commit:**
   - Selalu tulis pesan commit dalam **Bahasa Indonesia** yang jelas dan deskriptif.
2. **Format Standar Prefix:**
   - `feat:` (Fitur baru)
   - `fix:` (Perbaikan bug)
   - `refactor:` (Penyempurnaan arsitektur/kode)
   - `docs:` (Pembaruan dokumentasi)
   - `style:` (Penataan CSS / UI tampilan)
   - `test:` (Penambahan / eksekusi skrip tes)
   - `security:` (Perbaikan keamanan / vulnerability)
3. **Pre-Deployment Checklist:**
   - `npm run build` dijalankan lokal sebelum push (hasil `public/build/` ikut di-push).
   - `APP_DEBUG=false` di `.env` produksi.
   - Database MySQL aktif di cPanel (bukan SQLite).
   - `php artisan config:cache && php artisan route:cache && php artisan storage:link` dijalankan setelah deploy.

---

## 🚀 9. Deployment cPanel

1. **PHP Version:** Gunakan `/usr/local/php84/bin/php` eksplisit di terminal cPanel (bukan `php` default yang bisa 8.1).
2. **DocumentRoot:** Arahkan domain ke `/home/namauser/bigdata/public` (bukan root project).
3. **Database:** MySQL cPanel — import dari file `scratch/mysql_FINAL_sitrobbani.sql`.
4. **Deploy Script:** Gunakan `bash deploy.sh` untuk maintenance mode, migrate, cache, optimize.
