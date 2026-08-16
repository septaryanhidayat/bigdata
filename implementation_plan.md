# Rencana Implementasi: Aplikasi Mobile SDM SIT Robbani (React Native + Expo)

Pengembangan aplikasi mobile resmi **"SDM SIT Robbani"** berbasis **React Native + Expo** untuk seluruh Pendidik dan Tenaga Kependidikan (Guru, Karyawan, TU, Musyrif, Staff, Pimpinan) di 4 unit pendidikan (TKIT, SDIT, SMPIT, SMAIT) dan Yayasan Generasi Robbani Ogan Ilir, yang terintegrasi secara *realtime* dengan backend SmartEdu.

---

## 👥 User Review Required

> [!IMPORTANT]
> **Arsitektur Multi-Tenancy Otomatis pada 1 Aplikasi:**
> Aplikasi mendeteksi unit sekolah asal pegawai secara otomatis dari email/NIP yang didaftarkan saat login (`school_id`).
> - Koordinat GPS sekolah & batas radius presensi (Geofencing) disesuaikan secara dinamis dengan lokasi unit masing-masing.
> - Data presensi, cuti, slip gaji, dan KPI terkunci 100% pada database unit sekolah yang bersangkutan tanpa bercampur.

> [!NOTE]
> **Presensi Face Recognition & Proteksi Anti-Fake GPS:**
> - Presensi memvalidasi foto selfie wajah pegawai (*face detection / liveness challenge*).
> - Sistem mendeteksi parameter `isMocked` / Mock Location dari OS untuk mencegah kecurangan Fake GPS, serta memvalidasi jarak (*Haversine formula*) terhadap titik koordinat resmi kampus unit sekolah.

---

## 🏗️ Modul & Fitur Aplikasi Mobile SDM

```mermaid
graph TD
    subgraph Frontend Mobile (React Native + Expo)
        A[Login & Auto-Detect Unit] --> B[Dashboard SDM Multi-Unit]
        B --> C[Presensi Face Recognition + Anti-Fake GPS]
        B --> D[Pengajuan Izin, Sakit & Cuti Online]
        B --> E[Slip Gaji Digital & Riwayat Payroll]
        B --> F[Penilaian Kinerja & Evaluasi KPI]
        B --> G[Dompet Digital & Belanja Kantin/Koperasi]
        B --> H[Broadcast Info & Memo Internal Yayasan]
    end

    subgraph Backend SmartEdu (Laravel REST API)
        I[/api/v1/mobile/auth]
        J[/api/v1/mobile/attendance]
        K[/api/v1/mobile/leaves]
        L[/api/v1/mobile/payroll]
        M[/api/v1/mobile/kpi]
        N[/api/v1/mobile/canteen]
    end

    C --> J
    D --> K
    E --> L
    F --> M
    G --> N
    A --> I
```

---

## 📂 Rincian Perubahan & File yang Akan Dibuat

### 1. Backend SmartEdu (Laravel API Extension)

#### [NEW] [HrisMobileApiController.php](file:///c:/Users/RYAN/Herd/bigdata/app/Http/Controllers/Api/HrisMobileApiController.php)
- Menangani seluruh endpoint REST API untuk aplikasi mobile SDM:
  - `POST /api/v1/mobile/auth/login` (Otentikasi & deteksi unit).
  - `GET /api/v1/mobile/dashboard` (Ringkasan presensi, saldo, info, tugas).
  - `POST /api/v1/mobile/attendance/check-in` & `check-out` (Verifikasi wajah, geofencing, anti-mock GPS).
  - `GET /api/v1/mobile/attendance/history` (Rekap absensi bulanan).
  - `GET /api/v1/mobile/leaves` & `POST /api/v1/mobile/leaves/apply` (Pengajuan & approval cuti).
  - `GET /api/v1/mobile/payroll` & `GET /api/v1/mobile/payroll/{id}/slip` (Rincian slip gaji).
  - `GET /api/v1/mobile/kpi` (Capaian target KPI & penilaian kinerja).
  - `GET /api/v1/mobile/canteen/products` & `POST /api/v1/mobile/canteen/pay` (Kantin & koperasi).
  - `GET /api/v1/mobile/announcements` (Memo & pengumuman internal).

#### [MODIFY] [routes/api.php](file:///c:/Users/RYAN/Herd/bigdata/routes/api.php)
- Mendaftarkan rute grup `/api/v1/mobile/...` dengan middleware `auth:sanctum` / API Token verification.

#### [NEW] [2026_08_16_000012_create_hris_mobile_support_tables.php](file:///c:/Users/RYAN/Herd/bigdata/database/migrations/2026_08_16_000012_create_hris_mobile_support_tables.php)
- Menambahkan tabel pendukung: `employee_leaves`, `employee_kpis`, `employee_attendance_logs` (dengan kolom `face_image_url`, `latitude`, `longitude`, `is_mock_detected`, `distance_meters`).

---

### 2. Frontend Mobile (React Native + Expo Project: `sdm-robbani-mobile/`)

```
sdm-robbani-mobile/
├── App.js / index.js                   # Entry point aplikasi Expo
├── app.json / package.json             # Konfigurasi project & dependensi
├── src/
│   ├── api/
│   │   ├── client.js                   # Axios HTTP client dengan interceptor token
│   │   ├── authApi.js                  # Endpoint otentikasi
│   │   ├── attendanceApi.js            # Endpoint presensi & geofence
│   │   ├── leaveApi.js                 # Endpoint cuti & izin
│   │   ├── payrollApi.js               # Endpoint slip gaji
│   │   ├── kpiApi.js                   # Endpoint penilaian kinerja
│   │   └── canteenApi.js               # Endpoint belanja kantin
│   ├── context/
│   │   ├── AuthContext.js              # State login, unit auto-scoping & user profile
│   │   └── ThemeContext.js             # State Dark/Light mode & Unit Theme Colors
│   ├── components/
│   │   ├── HeaderBar.js                # Header responsif dengan info unit & notifikasi
│   │   ├── GeofenceRadar.js            # Visualisasi jarak radar radius GPS sekolah
│   │   ├── FaceCameraModal.js          # Modal kamera selfie liveness face recognition
│   │   ├── StatusBadge.js              # Badge status izin/presensi/gaji
│   │   └── QuickActionCard.js          # Grid tombol akses cepat
│   ├── screens/
│   │   ├── LoginScreen.js              # Login modern dengan email/NIP & auto-unit badge
│   │   ├── DashboardScreen.js          # Beranda SDM (jadwal, presensi cepat, info terkini)
│   │   ├── AttendanceScreen.js         # Halaman presensi selfie + radar geofence anti-fake GPS
│   │   ├── AttendanceHistoryScreen.js  # Riwayat & rekap statistik absensi bulanan
│   │   ├── LeaveScreen.js              # Daftar sisa cuti, form pengajuan & upload surat
│   │   ├── PayrollScreen.js            # Slip gaji digital dengan rincian pendapatan & potongan
│   │   ├── KpiScreen.js                # Indikator Kinerja Utama & evaluasi kinerja pegawai
│   │   ├── CanteenScreen.js            # Belanja non-tunai kantin/koperasi via QR barcode
│   │   ├── AnnouncementScreen.js       # Info & broadcast yayasan/unit
│   │   └── ProfileScreen.js            # Profil lengkap pegawai, ganti sandi, preferensi tema
│   ├── navigation/
│   │   ├── AppNavigator.js             # Root Stack Navigator (Auth vs Main)
│   │   └── BottomTabNavigator.js       # 5 Tab Utama (Home, Presensi, Cuti, Payroll, Profil)
│   └── utils/
│       ├── geoDistance.js              # Kalkulator rumus Haversine radius GPS
│       └── formatters.js               # Formatter mata uang Rupiah & tanggal Indonesia
```

---

## 🎨 Spesifikasi Desain & Palet Warna per Unit Sekolah

Aplikasi otomatis menyesuaikan warna tema dan aksen unit sekolah asal pegawai:
- **KB/TKIT Robbani:** Hijau Toska Cerah (`#059669`) & Aksen Kuning Ceria
- **SDIT Robbani:** Hijau Botol Islami (`#004532`) & Oranye Sunset (`#f97316`)
- **SMPIT Robbani:** Biru Royal Edukatif (`#2563eb`) & Cyan Modern
- **SMAIT Robbani:** Ungu Prestasi (`#7c3aed`) & Electric Indigo
- **Yayasan Induk:** Deep Obsidian Emerald (`#061107`) & Neon Lime (`#c6f634`)

---

## 🧪 Verification Plan

### 1. Automated API Test Suite
- Jalankan test PHP CLI:
  ```bash
  php scratch/test_mobile_hris_api.php
  ```
- Memverifikasi endpoint:
  - Otentikasi login multi-unit (TKIT, SDIT, SMPIT, SMAIT, Yayasan).
  - Validasi presensi GPS (dalam radius vs di luar radius).
  - Validasi deteksi fake GPS (`is_mock_detected: true`).
  - Pengajuan cuti & perhitungan saldo cuti.
  - Kalkulasi slip gaji & riwayat payroll.
  - Pengambilan data KPI & belanja kantin.

### 2. Mobile App Simulation Test
- Menjalankan Expo development bundler & verifikasi layar-layar navigasi (Auth flow, Presensi camera modal, Radar geofence, Payroll card, Dark mode toggle).
