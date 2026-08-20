# 🚀 Panduan Master Deployment & Multi-Subdomain cPanel (Langkah Demi Langkah dari Awal)

> **SmartEdu SIT Robbani v3.0 Final**  
> *Panduan Lengkap Deployment, Pengaturan Subdomain Multi-Unit, dan Pengamanan SIABS Lama*

---

## 📋 Ringkasan Ketentuan & Arsitektur

1. **Single Codebase Multi-Tenancy**: Seluruh website (`sitrobbani.sch.id`, `tk`, `sd`, `smp`, `sma`, `spmb`) berjalan di **1 folder project Laravel dan 1 database MySQL yang sama**.
2. **Aplikasi SIABS Lama Tetap Aktif**: Aplikasi presensi lama per unit tetap bisa diakses tanpa mengubah URL sama sekali (`sd.sitrobbani.sch.id/siabs`, `tk.sitrobbani.sch.id/siabs`, `smp.sitrobbani.sch.id/siabs`) via mekanisme *Silent Rewrite* di `.htaccess`.
3. **Dokumen Root Terpusat**: Semua subdomain diarahkan ke Document Root `sitrobbani.sch.id/public`.

---

## 🛠️ LANGKAH 1: Amankan Aplikasi Absensi SIABS Lama Per Unit

Sebelum menghapus folder-folder cPanel lama, amankan folder `siabs` masing-masing unit:

1. Buka cPanel $\rightarrow$ **File Manager**.
2. Pindahkan folder `siabs` dari folder fisik unit lama ke dalam folder `sitrobbani.sch.id/public/` dengan nama khusus:
   - Folder `/sd.sitrobbani.sch.id/siabs` $\rightarrow$ Pindahkan ke: `/sitrobbani.sch.id/public/siabs-sd`
   - Folder `/tk.sitrobbani.sch.id/siabs` $\rightarrow$ Pindahkan ke: `/sitrobbani.sch.id/public/siabs-tk`
   - Folder `/smp.sitrobbani.sch.id/siabs` $\rightarrow$ Pindahkan ke: `/sitrobbani.sch.id/public/siabs-smp`

*(Jangan khawatir, pengunjung yang membuka link lama `sd.sitrobbani.sch.id/siabs` akan otomatis dipanggilkan `siabs-sd` oleh `.htaccess` secara transparan tanpa mengubah URL di browser!)*

---

## 🛠️ LANGKAH 2: Deployment Kode Web Baru di Folder `sitrobbani.sch.id`

1. Di File Manager cPanel, bersihkan sisa file web lama di dalam folder `sitrobbani.sch.id` *(pastikan folder `public/siabs-sd`, `public/siabs-tk`, `public/siabs-smp` yang dibuat di Langkah 1 tidak terhapus)*.
2. Buka **Terminal** cPanel (atau via SSH) dan jalankan perintah:
   ```bash
   cd /home/pesonaas/sitrobbani.sch.id
   git clone https://github.com/septaryanhidayat/bigdata.git .
   ```
3. Salin file konfigurasi `.env`:
   ```bash
   cp .env.cpanel .env
   ```
4. Install dependency composer & generate app key:
   ```bash
   composer install --no-dev --optimize-autoloader --ignore-platform-req=php
   php artisan key:generate
   php artisan storage:link
   ```

---

## 🛠️ LANGKAH 3: Import Database MySQL Produksi

1. Buka cPanel $\rightarrow$ **MySQL Databases**.
2. Buat database MySQL baru (misal: `pesonaas_sitrobbani`).
3. Buat user MySQL baru & hubungkan ke database dengan centang **ALL PRIVILEGES**.
4. Buka **phpMyAdmin** di cPanel $\rightarrow$ pilih database `pesonaas_sitrobbani`.
5. Klik tab **Import** $\rightarrow$ upload file **`smartedu_FINAL_sitrobbani.sql`** yang ada di folder project (`/sitrobbani.sch.id/smartedu_FINAL_sitrobbani.sql`) $\rightarrow$ klik **Go**.

---

## 🛠️ LANGKAH 4: Konfigurasi File `.env` Produksi

Edit file `.env` di `/sitrobbani.sch.id/.env`:

```env
APP_NAME="SIT Robbani SmartEdu"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sitrobbani.sch.id

# PENTING: Tanda titik (.) diawal domain agar session login berlaku untuk semua subdomain
SESSION_DRIVER=database
SESSION_DOMAIN=.sitrobbani.sch.id

# Database MySQL cPanel
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pesonaas_sitrobbani
DB_USERNAME=pesonaas_user
DB_PASSWORD=PASSWORD_MYSQL_ANDA

# AI Chatbot Key
GEMINI_API_KEY=KEY_GEMINI_ANDA
```

---

## 🛠️ LANGKAH 5: Atur Document Root Domain & Subdomain di cPanel

1. Buka cPanel $\rightarrow$ menu **Domains**.
2. Ubah **New Document Root** domain utama `sitrobbani.sch.id` menjadi:
   ```
   sitrobbani.sch.id/public
   ```
3. Ubah **New Document Root** semua subdomain unit:
   - `sd.sitrobbani.sch.id` $\rightarrow$ `sitrobbani.sch.id/public`
   - `tk.sitrobbani.sch.id` $\rightarrow$ `sitrobbani.sch.id/public`
   - `smp.sitrobbani.sch.id` $\rightarrow$ `sitrobbani.sch.id/public`
   - `sma.sitrobbani.sch.id` $\rightarrow$ `sitrobbani.sch.id/public`
   - `spmb.sitrobbani.sch.id` $\rightarrow$ `sitrobbani.sch.id/public` *(hapus Redirect jika ada)*

---

## 🛠️ LANGKAH 6: Aktivasi SSL (HTTPS) & Cache Optimization

1. Di cPanel, buka menu **SSL/TLS Status** $\rightarrow$ centang semua domain & subdomain $\rightarrow$ klik **Run AutoSSL**.
2. Jalankan perintah optimasi di Terminal cPanel:
   ```bash
   cd /home/pesonaas/sitrobbani.sch.id
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🛠️ LANGKAH 7: Pembersihan Folder cPanel Lama

Folder-folder fisik lama di cPanel seperti `sd.sitrobbani.sch.id`, `smp.sitrobbani.sch.id`, `spmb.sitrobbani.sch.id`, `tk.sitrobbani.sch.id`, dll., kini sudah bisa dihapus (setelah di-backup) karena seluruh lalu lintas web sudah terlayani oleh folder `sitrobbani.sch.id/public`.

---

## 🌐 Verifikasi Pengujian Akhir

| URL yang Diakses | Hasil Tampilan |
| :--- | :--- |
| `https://sitrobbani.sch.id` | Portal Resmi Yayasan Generasi Robbani |
| `https://tk.sitrobbani.sch.id` | Website Profil KB/TKIT Robbani |
| `https://sd.sitrobbani.sch.id` | Website Profil SDIT Robbani |
| `https://smp.sitrobbani.sch.id` | Website Profil SMPIT Robbani |
| `https://sma.sitrobbani.sch.id` | Website Profil SMAIT Robbani |
| `https://spmb.sitrobbani.sch.id` | Portal SPMB Online Pendaftaran Siswa Baru |
| `https://sd.sitrobbani.sch.id/siabs` | Aplikasi Presensi SIABS Lama Unit SD |
| `https://tk.sitrobbani.sch.id/siabs` | Aplikasi Presensi SIABS Lama Unit TK |
| `https://smp.sitrobbani.sch.id/siabs` | Aplikasi Presensi SIABS Lama Unit SMP |
| `https://sitrobbani.sch.id/admin/login` | Portal Admin Dashboard (Email: `admin@smartedu.id`, Pass: `p4l3mb4ng`) |
