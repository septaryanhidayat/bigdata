# SmartEdu SIT Robbani — API Contract (API_CONTRACT.md)

> **Kontrak Lengkap REST API Mobile, Webhook Payment, dan Integrasi Eksternal**
> *Terakhir diperbarui: 17 Agustus 2026*

---

## 🔐 1. Autentikasi API Mobile (Laravel Sanctum)

**Base URL:** `https://sitrobbani.sch.id/api/v1/mobile`

> **PENTING:** Semua endpoint kecuali `/auth/login` memerlukan header `Authorization: Bearer {token}`.

### POST `/auth/login`
**Request:**
```json
{
  "email": "guru@sitrobbani.sch.id",
  "password": "password123",
  "device_name": "Samsung Galaxy A54"
}
```
**Response (200 OK):**
```json
{
  "success": true,
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...",
  "user": {
    "id": 5,
    "name": "Nur Amalia, S.Pd",
    "email": "nur.amalia@sitrobbani.sch.id",
    "role": "HEADMASTER",
    "school_id": 2,
    "school_name": "SDIT Robbani"
  }
}
```
**Response (401 Unauthorized):**
```json
{
  "success": false,
  "message": "Email atau password salah."
}
```

---

## 📱 2. Endpoint API Mobile (auth:sanctum required)

> Header wajib: `Authorization: Bearer {token}` + `Accept: application/json`

### GET `/dashboard`
Mengembalikan ringkasan data dashboard pegawai (presensi hari ini, notifikasi, saldo kantin).

### GET `/profile`
Mengembalikan data lengkap profil pengguna yang sedang login.

### POST `/profile/update`
**Request:**
```json
{
  "phone": "0812-3456-7890",
  "address": "Indralaya, Ogan Ilir"
}
```

### POST `/attendance/check-in`
**Request:**
```json
{
  "latitude": -3.2345678,
  "longitude": 104.5678901,
  "face_image": "base64_encoded_image_data"
}
```
**Response:**
```json
{
  "success": true,
  "message": "Check-in berhasil pada 07:30 WIB",
  "attendance_id": 123
}
```

### POST `/attendance/check-out`
Sama dengan check-in, untuk merekam jam pulang.

### GET `/attendance/history`
Mengembalikan riwayat 30 hari presensi pengguna.

### GET `/payroll`
Mengembalikan daftar slip gaji bulanan.

### GET `/payroll/{id}/slip`
Mengembalikan detail slip gaji dalam format JSON (untuk render di app).

### GET `/bpi/mutabaah/today`
Mengembalikan form mutabaah yaumiyah hari ini beserta status pengisian.

### POST `/bpi/mutabaah/save`
**Request:**
```json
{
  "date": "2026-08-17",
  "sholat_subuh": true,
  "sholat_dhuha": true,
  "sholat_dzuhur": true,
  "sholat_ashar": true,
  "sholat_maghrib": true,
  "sholat_isya": true,
  "tilawah_pages": 2,
  "tahajjud": false,
  "notes": "Alhamdulillah"
}
```

### POST `/face/enroll`
**Request:**
```json
{
  "face_images": ["base64_img_1", "base64_img_2", "base64_img_3"]
}
```

---

## 💳 3. Payment Gateway (Coming Soon)

### Midtrans Snap — Pembayaran SPP
```json
// Webhook payload dari Midtrans
{
  "transaction_status": "settlement",
  "order_id": "SPP-2026-002-001",
  "gross_amount": "350000.00",
  "payment_type": "qris",
  "signature_key": "SHA512_HASH"
}
```

### Xendit — Virtual Account
```json
// Webhook payload dari Xendit
{
  "id": "5f213443c324d506a...",
  "external_id": "SPP-2026-002-001",
  "amount": 350000,
  "status": "PAID"
}
```

---

## 📲 4. WhatsApp Gateway (Coming Soon)

**Provider:** Fonnte / Wablas / WAHA API

```json
// Request kirim notifikasi tagihan
POST https://api.fonnte.com/send
{
  "target": "62812345678",
  "message": "Yth. Wali Murid Ahmad,\nTagihan SPP Agustus 2026 sebesar Rp 350.000 belum dibayar.\nBayar via: [link QR]"
}
```

---

## 🔄 5. RFID Gate Terminal

### POST `/api/v1/attendance/tap-rfid`
**Request (dari hardware RFID reader):**
```json
{
  "rfid_uid": "A1B2C3D4",
  "terminal_id": "GATE-SMPIT-01",
  "timestamp": "2026-08-17T07:30:00+07:00"
}
```
**Response:**
```json
{
  "success": true,
  "employee_name": "Tia Wulandari, S.Pd., Gr.",
  "action": "CHECK_IN",
  "time": "07:30"
}
```

---

## ⚠️ 6. Catatan Keamanan API

1. **Rate Limiting:** API endpoint dibatasi 60 request/menit per IP (default Laravel Sanctum).
2. **Token Expiry:** Token tidak expired otomatis, tapi bisa di-revoke via `DELETE /auth/logout`.
3. **HTTPS Only:** Semua API harus diakses via HTTPS di produksi.
4. **CORS:** Konfigurasi `CORS` di `config/cors.php` harus membatasi origin yang diizinkan.
