# SmartEdu SIT Robbani — AI & Developer Rules (AI_RULES.md)

> **Pedoman Wajib bagi AI Agent, Developer, dan Kontributor Kode Sistem SmartEdu**

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

## 🎨 2. Standar UI/UX, Dark Mode & Tipografi

1. **Sistem Dark Mode:**
   - Background Utama Mode Gelap: `#061107` (Deep Obsidian Emerald).
   - Card Surface: `#0e2010` / `#0d1e0f` dengan border `#1a381c`.
   - Warna Aksen Utama: `#c6f634` (Electric Lemon / Neon Lime).
   - **Kaidah Kontras Teks (WCAG AAA):**
     - Pada latar belakang neon lime (`bg-[#c6f634]` atau `bg-amber-500`), teks **WAJIB** berwarna gelap pekat (`text-[#061107]` atau `text-slate-950 font-black`), **DILARANG KERAS** menggunakan teks warna putih.
2. **Animasi & Interaktivitas:**
   - Gunakan kelas `.reveal-fade-up` untuk animasi scroll cepat (0.4s).
   - Jangan gunakan library JS berat jika interaktivitas dapat ditangani oleh **Alpine.js**.

---

## 🛡️ 3. Keamanan Siber & Validasi (*Cybersecurity Hardening*)

1. **Anti SQL Injection:**
   - Dilarang membuat raw concatenation pada SQL query (`DB::raw("... WHERE id = $id")`).
   - Wajib menggunakan Eloquent ORM atau parameterized binding (`DB::select("... WHERE id = ?", [$id])`).
2. **Keamanan Persuratan TTE:**
   - Setiap surat yang disetujui harus menghasilkan hash digital SHA-256 dan token UUID unik untuk verifikasi scan QR publik.
3. **Security Headers Middleware:**
   - Pertahankan middleware `SecurityHeaders` pada global pipeline untuk mencegah clickjacking dan MIME-sniffing.

---

## 🤖 4. Standar Pembelajaran AI Chatbot & Knowledge Base RAG

1. **Ekstraksi Dokumen PDF:**
   - Semua SOP, Brosur SPMB, dan Panduan Sekolah baru wajib dimasukkan ke tabel `ai_knowledge_bases` melalui `AiRagEngine::ingestDocument()`.
2. **Anti-Halusinasi:**
   - Chatbot AI harus memprioritaskan cuplikan dokumen asli dan data realtime sekolah (Tahun Ajaran aktif, unit, kontak) sebelum memberikan jawaban kepada wali santri.

---

## 📝 5. Standar Blade Templating & Scripting

1. **JSON-LD Schema.org Gotcha:**
   - Blade parser Laravel menganggap simbol `@` sebagai directive. **DILARANG** menulis `@context` atau `@type` secara mentah di Blade.
   - Wajib di-encode via PHP:
     ```blade
     {!! json_encode([...], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
     ```
2. **Notifikasi Alert:**
   - Gunakan **SweetAlert2** untuk semua respon user (sukses simpan, error validasi, konfirmasi hapus) dengan auto-timer 2.5 detik.

---

## 📦 6. Konvensi Git Commit & Deployment

1. **Bahasa Commit:**
   - Selalu tulis pesan commit dalam **Bahasa Indonesia** yang jelas dan deskriptif.
2. **Format Standar Prefix:**
   - `feat:` (Fitur baru)
   - `fix:` (Perbaikan bug)
   - `refactor:` (Penyempurnaan arsitektur/kode)
   - `docs:` (Pembaruan dokumentasi)
   - `style:` (Penataan CSS / UI tampilan)
   - `test:` (Penambahan / eksekusi skrip tes)
3. **Eksekusi Test Suite:**
   - Sebelum melakukan commit dan push, jalankan test suite otomatis:
     ```bash
     php scratch/test_all_features.php
     php scratch/test_ai_rag_chatbot.php
     ```
   - Push langsung ke branch `origin main`.
