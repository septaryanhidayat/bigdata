<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'error_type',
        'severity',
        'message',
        'file',
        'line',
        'stack_trace',
        'url',
        'user_agent',
        'ip_address',
        'status',
        'mitigation_solution',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Generate smart automated mitigation steps based on error patterns.
     */
    public static function generateMitigation(string $errorType, string $message, ?string $file = null): string
    {
        $msgLower = strtolower($message);

        if (str_contains($msgLower, 'sql') || str_contains($msgLower, 'database') || str_contains($msgLower, 'connection refused')) {
            return "1. Periksa koneksi database MySQL di file .env (DB_HOST, DB_PORT, DB_USERNAME).\n2. Jalankan perintah recovery: `php artisan config:clear` dan `php artisan cache:clear`.\n3. Pastikan service MySQL/MariaDB berjalan normal.";
        }

        if (str_contains($msgLower, 'class') && str_contains($msgLower, 'not found')) {
            return "1. Jalankan `composer dump-autoload` untuk memperbarui auto-loader PHP.\n2. Pastikan namespace dan import `use App\\Models\\...` pada file {$file} sudah benar.";
        }

        if (str_contains($msgLower, 'undefined variable') || str_contains($msgLower, 'undefined index') || str_contains($msgLower, 'null')) {
            return "1. Buka file {$file} dan tambahkan pengecekan null / optional chaining (contoh: `\$data->name ?? '-'` atau `@if(isset(\$var))`).\n2. Pastikan variabel yang dikirim dari controller ke view Blade tidak bernilai null.";
        }

        if (str_contains($msgLower, 'rfid') || str_contains($msgLower, 'gate') || str_contains($msgLower, 'reader')) {
            return "1. Periksa koneksi fisik/IP port alat RFID Reader Gate di lokasi sekolah.\n2. Pastikan IP Alat RFID terdaftar di database Master Data RFID & API Presensi Gate.\n3. Lakukan restart service listener RFID Gate GateKeeper.";
        }

        if (str_contains($msgLower, 'canteen') || str_contains($msgLower, 'pos') || str_contains($msgLower, 'payment') || str_contains($msgLower, 'insufficient')) {
            return "1. Periksa ketersediaan saldo kartu cashless siswa dan batas transaksi harian.\n2. Pastikan terminal POS Kantin terhubung ke koneksi internet lokal sekolah.";
        }

        if (str_contains($msgLower, 'js') || str_contains($msgLower, 'typeerror') || str_contains($msgLower, 'cannot read property')) {
            return "1. Terdeteksi kendala di perangkat/browser user. Tambahkan pengecekan elemen DOM sebelum eksekusi (contoh: `if(element) { element.addEventListener(...) }`).\n2. Minta user melakukan hard refresh (Ctrl + F5) untuk memuat ulang script frontend terbaru.";
        }

        if (str_contains($msgLower, '404') || str_contains($msgLower, 'not found')) {
            return "1. Periksa deklarasi route di file `routes/web.php` atau `routes/api.php`.\n2. Jalankan `php artisan route:clear` untuk memperbarui cache routing Laravel.";
        }

        return "1. Periksa stack trace lengkap pada tombol [Detail Trace] untuk mengetahui titik awal kendala.\n2. Lakukan pengujian di environment lokal sebelum melakukan push update.\n3. Jalankan fitur Auto-Mitigasi Cepat untuk mereset cache dan konfigurasi sistem.";
    }
}
