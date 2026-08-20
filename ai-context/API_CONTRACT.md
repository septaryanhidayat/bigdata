# SmartEdu SIT Robbani — API Contract

> *REST API Mobile HRIS — Laravel Sanctum Authentication*  
> *Base URL Production: `https://sitrobbani.sch.id/api/v1/`*  
> *Base URL Development: `http://bigdata.test/api/v1/`*  
> *Terakhir diperbarui: 18 Agustus 2026*

---

## 🔐 Autentikasi (Laravel Sanctum)

### POST `/api/v1/mobile/auth/login`

**Publik — tidak perlu token**

**Request Body:**
```json
{
  "email": "guru@sitrobbani.sch.id",
  "password": "password123",
  "device_name": "Samsung Galaxy A54"
}
```

**Response Sukses (200):**
```json
{
  "success": true,
  "message": "Login berhasil!",
  "data": {
    "token": "1|abc123xyz...",
    "user": {
      "id": 5,
      "name": "Ustadzah Sarah",
      "email": "guru@sitrobbani.sch.id",
      "role": "TEACHER",
      "school_id": 2,
      "avatar": "/uploads/avatars/sarah.jpg",
      "phone": "08123456789"
    }
  }
}
```

**Response Gagal (401):**
```json
{
  "success": false,
  "message": "Email atau kata sandi salah."
}
```

---

## 📌 Header Wajib untuk Endpoint Terproteksi

```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

---

## 👤 Dashboard & Profil

### GET `/api/v1/mobile/dashboard`

**Response:**
```json
{
  "success": true,
  "data": {
    "employee": { "nama_lengkap": "...", "jabatan": "...", "unit": "SDIT" },
    "attendance_today": { "status": "HADIR", "check_in": "07:15", "check_out": null },
    "leave_balance": 12,
    "payroll_latest": { "bulan": "Agustus 2026", "total_gaji": 3500000 },
    "bpi_today": { "submitted": true, "subuh": true, "dzuhur": false }
  }
}
```

### GET `/api/v1/mobile/profile`
### POST `/api/v1/mobile/profile/update`

---

## 🕐 Presensi (GPS + Face Recognition)

### POST `/api/v1/mobile/attendance/check-in`

```json
{
  "latitude": -3.1234567,
  "longitude": 104.7654321,
  "face_image_base64": "data:image/jpeg;base64,...",
  "check_type": "MASUK"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Presensi MASUK berhasil dicatat!",
  "data": {
    "timestamp": "2026-08-18 07:14:32",
    "status": "HADIR",
    "distance_meters": 48,
    "face_match": true,
    "face_confidence": 0.97
  }
}
```

### POST `/api/v1/mobile/attendance/check-out`
### GET `/api/v1/mobile/attendance/history`

---

## 🏖️ Izin & Cuti

### GET `/api/v1/mobile/leaves`
### POST `/api/v1/mobile/leaves/apply`

```json
{
  "leave_type": "SAKIT",
  "start_date": "2026-08-19",
  "end_date": "2026-08-19",
  "reason": "Demam dan perlu istirahat",
  "attachment_base64": "data:application/pdf;base64,..."
}
```

---

## 💰 Payroll & Slip Gaji

### GET `/api/v1/mobile/payroll`

```json
{
  "success": true,
  "data": [
    {
      "id": 10,
      "bulan": "Agustus",
      "tahun": 2026,
      "gaji_pokok": 3000000,
      "tunjangan_kehadiran": 500000,
      "potongan": 0,
      "total_bersih": 3500000,
      "status": "DIBAYAR"
    }
  ]
}
```

### GET `/api/v1/mobile/payroll/{id}/slip`

---

## 🕌 BPI & Mutabaah

### GET `/api/v1/mobile/bpi/mutabaah/today`
### POST `/api/v1/mobile/bpi/mutabaah/save`

```json
{
  "date": "2026-08-18",
  "sholat_subuh": true,
  "sholat_dzuhur": true,
  "sholat_ashr": true,
  "sholat_maghrib": true,
  "sholat_isya": false,
  "tilawah_ayat": 10,
  "puasa_sunnah": false,
  "sholat_dhuha": true,
  "sholat_tahajjud": false,
  "sedekah": true
}
```

### GET `/api/v1/mobile/bpi/my-group`
### GET `/api/v1/mobile/bpi/mutabaah/history`
### GET `/api/v1/mobile/bpi/mentor/dashboard`
### POST `/api/v1/mobile/bpi/meetings/record`

---

## 📢 Pengumuman

### GET `/api/v1/mobile/announcements`

---

## 👤 Biometrik Wajah

### POST `/api/v1/mobile/face/enroll`

```json
{
  "face_image_base64": "data:image/jpeg;base64,..."
}
```

### GET `/api/v1/mobile/face/status`

---

## 🛒 Kantin Digital

### GET `/api/v1/mobile/canteen/products`
### POST `/api/v1/mobile/canteen/pay`

```json
{
  "product_id": 3,
  "quantity": 2,
  "outlet_id": 1
}
```

---

## 📟 RFID Gate (Hardware Terminal)

### POST `/api/v1/attendance/tap-rfid`

**Tidak perlu Sanctum** (menggunakan token internal hardware):

```json
{
  "rfid_code": "ABC12345",
  "gate_id": "GATE_UTAMA",
  "tap_type": "MASUK"
}
```

---

## ⚠️ Format Error Standar

Semua error API menggunakan format:

```json
{
  "success": false,
  "message": "Pesan error yang jelas dalam Bahasa Indonesia.",
  "errors": {
    "field_name": ["Pesan validasi field ini wajib diisi."]
  }
}
```

**HTTP Status Codes:**
- `200` — Sukses
- `201` — Created
- `400` — Bad Request / Validasi gagal
- `401` — Unauthenticated (token tidak valid / tidak ada)
- `403` — Forbidden (role tidak berhak)
- `404` — Data tidak ditemukan
- `413` — Payload terlalu besar (foto > limit)
- `419` — CSRF Token Mismatch (web only)
- `422` — Unprocessable Entity (validasi Laravel)
- `500` — Internal Server Error (auto-logged ke `system_error_logs`)
