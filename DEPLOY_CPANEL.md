# 🚀 Panduan Lengkap Deployment & Konfigurasi Multi-Subdomain cPanel

> **SmartEdu SIT Robbani v3.0 Final**  
> *Panduan Resmi Deployment & Pengaturan Subdomain Multi-Unit di cPanel*

---

## 🎯 Konsep Utama Subdomain Multi-Unit

Sistem SmartEdu SIT Robbani dibangun dengan arsitektur **Single Codebase Multi-Tenancy**. Artinya, seluruh web utama (`sitrobbani.sch.id`) dan web unit (`tk`, `sd`, `smp`, `sma`, `spmb`) **menggunakan 1 folder kode Laravel dan 1 database MySQL yang sama**.

Laravel secara otomatis mendeteksi domain/subdomain yang sedang diakses pengunjung lewat routing `Route::domain()` di `routes/web.php`:
- `sitrobbani.sch.id` $\rightarrow$ Halaman Beranda Utama Yayasan
- `tk.sitrobbani.sch.id` atau `tkit.sitrobbani.sch.id` $\rightarrow$ Langsung tampilkan Profil TKIT
- `sd.sitrobbani.sch.id` atau `sdit.sitrobbani.sch.id` $\rightarrow$ Langsung tampilkan Profil SDIT
- `smp.sitrobbani.sch.id` atau `smpit.sitrobbani.sch.id` $\rightarrow$ Langsung tampilkan Profil SMPIT
- `sma.sitrobbani.sch.id` atau `smait.sitrobbani.sch.id` $\rightarrow$ Langsung tampilkan Profil SMAIT
- `spmb.sitrobbani.sch.id` $\rightarrow$ Langsung tampilkan Formulir Pendaftaran SPMB

---

## 🛠️ Langkah-Langkah Setting di cPanel

### LANGKAH 1: Upload / Git Clone Project ke cPanel

1. Buka cPanel $\rightarrow$ Buka **Terminal** (atau SSH).
2. Clone repository ke folder `~/bigdata`:
   ```bash
   git clone https://github.com/septaryanhidayat/bigdata.git ~/bigdata
   ```
3. Masuk ke folder project:
   ```bash
   cd ~/bigdata
   ```
4. Salin file `.env.cpanel` menjadi `.env`:
   ```bash
   cp .env.cpanel .env
   ```
5. Install dependencies & generate key:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan storage:link
   ```

---

### LANGKAH 2: Konfigurasi Subdomain di cPanel (KUNCI UTAMA 🔑)

Agar semua subdomain mengarah ke aplikasi yang sama, **Document Root semua subdomain HARUS diarahkan ke folder `public` yang sama dengan Domain Utama**.

1. Masuk ke cPanel $\rightarrow$ cari dan klik menu **Domains** (atau **Subdomains**).
2. Klik tombol **Create A New Domain** (atau **Add Subdomain**).
3. Buat subdomain satu per satu dengan pengisian berikut:

#### 1. Subdomain TKIT:
* **Domain / Subdomain**: `tk.sitrobbani.sch.id`
* **Document Root**: `bigdata/public` (atau `public_html` jika `public_html` diarahkan ke `public` Laravel)
* *Uncheck* pilihan "Share document root" jika diminta, lalu ketik manual jalan folder ke `bigdata/public`.

#### 2. Subdomain SDIT:
* **Domain / Subdomain**: `sd.sitrobbani.sch.id`
* **Document Root**: `bigdata/public`

#### 3. Subdomain SMPIT:
* **Domain / Subdomain**: `smp.sitrobbani.sch.id`
* **Document Root**: `bigdata/public`

#### 4. Subdomain SMAIT:
* **Domain / Subdomain**: `sma.sitrobbani.sch.id`
* **Document Root**: `bigdata/public`

#### 5. Subdomain SPMB Online:
* **Domain / Subdomain**: `spmb.sitrobbani.sch.id`
* **Document Root**: `bigdata/public`

> ⚠️ **Penting**: Pastikan **Document Root** untuk `sitrobbani.sch.id` dan KELIMA subdomain di atas **PERSIS SAMA**, yaitu menuju folder `public` Laravel (contoh: `bigdata/public` atau `public_html`). Jangan biarkan cPanel membuat folder terpisah seperti `public_html/tk`!

---

### LANGKAH 3: Setting `.env` Produksi untuk Subdomain

Di file `.env` di server cPanel (`~/bigdata/.env`), pastikan variabel berikut terisi:

```env
APP_NAME="SIT Robbani SmartEdu"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sitrobbani.sch.id

# PENTING: Tanda titik (.) diawal domain agar Session & Cookie berlaku untuk semua subdomain
SESSION_DRIVER=database
SESSION_DOMAIN=.sitrobbani.sch.id

# Database MySQL cPanel
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=namauser_sitrobbani
DB_USERNAME=namauser_sitrobbani
DB_PASSWORD=PASSWORD_MYSQL_CPANEL_ANDA
```

---

### LANGKAH 4: Import Database MySQL

1. Masuk ke cPanel $\rightarrow$ **MySQL Databases** $\rightarrow$ Buat database baru (misal: `user_sitrobbani`).
2. Buat user database & hubungkan user ke database dengan checklist **ALL PRIVILEGES**.
3. Buka **phpMyAdmin** di cPanel $\rightarrow$ Pilih database yang baru dibuat.
4. Klik tab **Import** $\rightarrow$ Pilih file **`smartedu_FINAL_sitrobbani.sql`** dari folder project $\rightarrow$ Klik **Go**.

---

### LANGKAH 5: Aktivasi SSL (HTTPS) Semua Subdomain

1. Di cPanel, buka menu **SSL/TLS Status** (atau **AutoSSL**).
2. Centang semua domain & subdomain (`sitrobbani.sch.id`, `tk.sitrobbani.sch.id`, `sd.sitrobbani.sch.id`, `smp.sitrobbani.sch.id`, `sma.sitrobbani.sch.id`, `spmb.sitrobbani.sch.id`).
3. Klik tombol **Run AutoSSL**.
4. Tunggu beberapa menit hingga sertifikat SSL hijau terpasang untuk seluruh subdomain.

---

### LANGKAH 6: Cache Optimization

Jalankan perintah berikut di Terminal cPanel:

```bash
cd ~/bigdata
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Verifikasi Hasil

| URL | Hasil yang Diharapkan |
| :--- | :--- |
| `https://sitrobbani.sch.id` | Halaman Utama / Portal Yayasan |
| `https://tk.sitrobbani.sch.id` | Profil KB/TKIT Robbani |
| `https://sd.sitrobbani.sch.id` | Profil SDIT Robbani |
| `https://smp.sitrobbani.sch.id` | Profil SMPIT Robbani |
| `https://sma.sitrobbani.sch.id` | Profil SMAIT Robbani |
| `https://spmb.sitrobbani.sch.id` | Formulir SPMB Online Pendaftaran |
| `https://sitrobbani.sch.id/admin/login` | Portal Login Admin |
