# 📱 Aplikasi Mobile SDM SIT Robbani (React Native + Expo)

Platform aplikasi mobile resmi bagi seluruh Pendidik dan Tenaga Kependidikan (Guru, Karyawan, TU, Musyrif, Staff, dan Pimpinan) di 4 unit pendidikan (TKIT, SDIT, SMPIT, SMAIT) dan Yayasan Generasi Robbani Ogan Ilir, Sumatera Selatan.

---

## 🌟 Fitur Unggulan

1. **Auto Multi-Tenancy Detection:**  
   Satu aplikasi untuk seluruh unit. Begitu pegawai masuk dengan email/NIP, aplikasi otomatis mendeteksi unit sekolah terdaftar, mengunci data unit, menyesuaikan palet warna unit, dan mengatur titik koordinat GPS kampus secara dinamis.
2. **Presensi Face Recognition & Anti-Fake GPS:**  
   - Foto selfie wajah (*liveness & face detection*).
   - Validasi radius geofencing (*Haversine Formula*) terhadap koordinat resmi kampus unit.
   - Proteksi otomatis terhadap pemalsuan lokasi (*Mock Location / Fake GPS detection*).
3. **Pengajuan Cuti & Izin Online:**  
   Cek sisa kuota cuti tahunan, ajukan cuti (tahunan, sakit, melahirkan, umroh) langsung dari genggaman dan pantau status persetujuan pimpinan secara *realtime*.
4. **Slip Gaji Digital (Payroll):**  
   Akses riwayat gaji bulanan, rincian pendapatan, tunjangan jabatan/transport, potongan BPJS & pajak, serta unduh slip gaji resmi ber-QR TTE.
5. **Evaluasi Kinerja (KPI):**  
   Pantau capaian 5 dimensi kompetensi kerja (Pedagogik, Kepribadian, Sosial, Keislaman BPI, Kedisiplinan) dengan predikat mutu A/B/C/D.
6. **Kantin & Koperasi Belanja Non-Tunai:**  
   Dompet digital terintegrasi untuk belanja makan siang di kantin sekolah dan koperasi pegawai.
7. **Memo & Informasi Internal Yayasan:**  
   Broadcast berita dan memo kedinasan resmi pimpinan yayasan.
8. **Mode Gelap (Obsidian Emerald Theme):**  
   Tema gelap eksekutif hemat daya baterai dengan kontras tinggi WCAG AAA.

---

## 🚀 Cara Menjalankan Aplikasi

### 1. Prasyarat:
- Node.js versi 18+ atau 20+
- Expo CLI (`npm install -g expo-cli` atau `npx expo`)
- Aplikasi **Expo Go** pada Smartphone Android/iOS (bisa diunduh di Google Play Store / Apple App Store)

### 2. Jalankan Perintah:
```bash
cd sdm-robbani-mobile
npm install
npx expo start
```

### 3. Pindai QR Code:
- Buka aplikasi **Expo Go** pada smartphone Anda, lalu pindai QR code yang tampil di terminal.
- Atau tekan `w` untuk membuka versi web browser langsung di laptop.

---

## 🔗 Endpoint Backend SmartEdu Terkait
Seluruh fitur terhubung secara *realtime* ke backend Laravel SmartEdu:
- `POST /api/v1/mobile/auth/login`
- `GET /api/v1/mobile/dashboard`
- `POST /api/v1/mobile/attendance/check-in`
- `POST /api/v1/mobile/attendance/check-out`
- `GET /api/v1/mobile/attendance/history`
- `GET /api/v1/mobile/leaves` & `POST /api/v1/mobile/leaves/apply`
- `GET /api/v1/mobile/payroll` & `GET /api/v1/mobile/payroll/{id}/slip`
- `GET /api/v1/mobile/kpi`
- `GET /api/v1/mobile/canteen/products` & `POST /api/v1/mobile/canteen/pay`
- `GET /api/v1/mobile/announcements`
