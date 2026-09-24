# 📖 Panduan Lengkap Migrasi Subdomain `spmb.sitrobbani.sch.id` (Aman & Data Lama Ter-backup)

Panduan teknis ini menjelaskan cara membackup website SPMB lama (file & database) agar **100% aman dan tidak hilang**, sekaligus mengalihkan subdomain **`spmb.sitrobbani.sch.id`** agar langsung menyajikan sistem pendaftaran baru **SmartEdu SIT Robbani** yang terintegrasi.

---

## 🎯 Ringkasan Konsep Teknis

| Parameter | Kondisi Lama | Kondisi Baru (SmartEdu) |
| :--- | :--- | :--- |
| **Subdomain** | `spmb.sitrobbani.sch.id` | Tetap sama: `https://spmb.sitrobbani.sch.id` |
| **Sertifikat SSL (HTTPS)** | Sudah aktif | **Tetap aktif otomatis** (gembok hijau aman) |
| **Data & File Web Lama** | Di folder subdomain lama | **Tersimpan aman di folder backup & arsip ZIP/SQL** |
| **Document Root** | Folder lama | Diarahkan ke: `/home/pesonaas/bigdata.sitrobbani.sch.id/public` |
| **Database** | Database lama terpisah | Terintegrasi penuh ke database SmartEdu (Master Siswa, Kelas, & SPP) |

---

## 🛠️ TAHAP 1: Backup Penuh Website & Database Lama (100% Aman)

Lakukan backup terlebih dahulu sebelum mengubah pengaturan apa pun di cPanel.

### 1.1. Backup File Website Lama
Pilih salah satu cara di bawah ini:

#### Cara A: Melalui File Manager cPanel (Grafis)
1. Login ke dashboard **cPanel** akun Anda (`pesonaas`).
2. Buka menu **File Manager**.
3. Masuk ke direktori home (biasanya `/home/pesonaas/`).
4. Cari folder website lama Anda, umumnya bernama:
   - `/home/pesonaas/spmb.sitrobbani.sch.id` atau `/home/pesonaas/public_html/spmb`
5. **Klik kanan** pada folder tersebut $\rightarrow$ pilih **Compress (Zip Archive)**.
6. Beri nama file arsip, misalnya: `backup_spmb_lama_2026.zip` $\rightarrow$ klik **Compress File(s)**.
7. Setelah selesai, klik kanan file `backup_spmb_lama_2026.zip` $\rightarrow$ pilih **Download** ke laptop/komputer Anda untuk disimpan sebagai cadangan *offline*.
8. **PENTING - Ubah Nama Folder Lama (Rename):**
   - Klik kanan folder `spmb.sitrobbani.sch.id` $\rightarrow$ pilih **Rename**.
   - Ubah namanya menjadi:
     ```text
     spmb.sitrobbani.sch.id_backup_lama
     ```
   - *Fungsi:* Seluruh file lama tidak terhapus dan tidak akan tertimpa kode baru.

#### Cara B: Melalui Terminal cPanel (Cepat via Perintah)
Jika lebih menyukai terminal, jalankan perintah berikut:
```bash
cd /home/pesonaas
# Buat arsip cadangan zip
zip -r backup_spmb_lama_$(date +%Y%m%d).zip spmb.sitrobbani.sch.id/
# Ganti nama folder lama agar aman
mv spmb.sitrobbani.sch.id spmb.sitrobbani.sch.id_backup_lama
```

---

### 1.2. Backup Database Website Lama
1. Di cPanel, buka menu **phpMyAdmin**.
2. Di kolom sebelah kiri, klik nama database yang digunakan oleh web SPMB lama Anda.
3. Klik tab **Export (Ekspor)** pada menu navigasi bagian atas.
4. Pilih metode ekspor **Quick (Cepat)** dan format **SQL**.
5. Klik tombol **Export / Go**.
6. Simpan file `.sql` cadangan tersebut di komputer Anda.

> **Status Saat Ini:** Seluruh file kode, gambar, dan database lama Anda sudah aman 100% di komputer lokal dan di folder `_backup_lama` di server.

---

## 🛠️ TAHAP 2: Mengalihkan Subdomain ke Sistem Baru SmartEdu

Setelah web lama dibackup, kini saatnya mengarahkan subdomain `spmb.sitrobbani.sch.id` ke sistem SmartEdu yang baru:

1. Di menu cPanel, buka menu **Domains** (atau **Subdomains**).
2. Cari subdomain **`spmb.sitrobbani.sch.id`** pada tabel daftar domain.
3. Klik tombol **Manage** atau ikon pensil pada kolom **Document Root**.
4. Ubah isi kolom **Document Root** menjadi:
   ```text
   /home/pesonaas/bigdata.sitrobbani.sch.id/public
   ```
   *(Atau sesuaikan jika folder project Laravel Anda bernama `/home/pesonaas/sitrobbani.sch.id/public`)*.

   > ⚠️ **Catatan Kritis:** Wajib diakhiri dengan `/public`, karena pintu gerbang utama aplikasi Laravel berada di file `public/index.php`. Jangan mengarahkan ke folder root tanpa `/public`.

5. Jika ada pengaturan **Redirects (Pengalihan)** aktif pada subdomain tersebut, pastikan dihapus atau dinonaktifkan agar tidak berputar (*loop*).
6. Klik tombol **Update / Save**.

---

## 🛠️ TAHAP 3: Tarik Pembaruan & Bersihkan Cache di Server

Buka menu **Terminal** di cPanel Anda, lalu jalankan rangkaian perintah berikut:

```bash
# 1. Masuk ke folder aplikasi SmartEdu
cd /home/pesonaas/bigdata.sitrobbani.sch.id

# 2. Tarik update terbaru dari repositori GitHub
git pull origin main

# 3. Bersihkan seluruh cache lama
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# 4. Buat cache baru untuk performa maksimal
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🌐 TAHAP 4: Verifikasi & Pengujian Hasil

Silakan buka browser Anda (disarankan menggunakan mode *Incognito* / *Private Window* atau tekan `Ctrl + F5` untuk membersihkan cache browser):

1. **Uji Halaman Depan SPMB:**
   - Akses: `https://spmb.sitrobbani.sch.id/`
   - *Hasil:* Tampil Landing Page SPMB baru dengan kartu 6 pilihan unit sekolah (TPA, KB, TK IT, SD IT, SMP IT, SMA IT), foto siswa ultra-realistis, 5 program unggulan yang simetris di mobile, syarat berkas, rekening resmi, dan testimoni.
2. **Uji Formulir Pendaftaran Online (F-SPMB):**
   - Akses: `https://spmb.sitrobbani.sch.id/daftar`
   - *Hasil:* Formulir pendaftaran resmi yang langsung menghitung biaya pendaftaran per unit, upload foto, Akta Kelahiran, KK, KTP, dan bukti transfer.
3. **Uji Cek Status Pendaftaran:**
   - Akses: `https://spmb.sitrobbani.sch.id/cek-status`
   - *Hasil:* Wali murid dapat langsung melacak status pendaftaran dan mengunduh formulir bukti registrasi berformat PDF.
4. **Uji Pengelolaan Admin Unit Sekolah:**
   - Akses: `https://bigdata.sitrobbani.sch.id/admin/login`
   - Login menggunakan akun Admin Unit Sekolah, Staf TU, atau Panitia PPDB.
   - Buka menu **PPDB & SPMB Siswa Baru** (`/ppdb-admin`):
     - Membuka modal detail pendaftar lengkap dengan cek berkas (Akta, KK, KTP, bukti transfer).
     - Menambah pendaftar manual offline (walk-in).
     - Saat pendaftar diset **DITERIMA (PASSED)**, otomatis terbuat data siswa baru di Master Siswa, penempatan kelas, wali murid, dan tagihan SPP.
   - Buka menu **Pengaturan SPMB & Form** (`/admin/settings/spmb`):
     - Kelola fungsi CRUD (+ Tambah, Edit, 🗑️ Hapus) untuk unit, program keunggulan, syarat berkas, rekening bank, dan ulasan testimoni.

---

## 🔄 Prosedur Rollback (Jika Suatu Saat Ingin Melihat Web Lama)

Karena file lama tidak pernah dihapus dan berada di `spmb.sitrobbani.sch.id_backup_lama`, Anda dapat mengembalikannya kapan saja dengan sangat mudah:
1. Buka cPanel $\rightarrow$ **Domains**.
2. Ubah Document Root `spmb.sitrobbani.sch.id` kembali ke folder:
   `/home/pesonaas/spmb.sitrobbani.sch.id_backup_lama`
3. Klik **Update**. Web lama Anda akan langsung kembali aktif seperti sedia kala.
