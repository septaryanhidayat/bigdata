<?php
// cpanel_setup.php — Script setup pertama kali di cPanel Terminal
// Jalankan SEKALI SAJA setelah clone dari GitHub:
//   php8.4 cpanel_setup.php
// Atau jika php default:
//   php cpanel_setup.php
//
// PRASYARAT: .env sudah dikonfigurasi dengan DB MySQL cPanel

echo "========================================\n";
echo "  SIT Robbani - CPanel First-Time Setup\n";
echo "========================================\n\n";

// Cek versi PHP
$phpVersion = phpversion();
echo "PHP Version: $phpVersion\n";
if (version_compare($phpVersion, '8.2.0', '<')) {
    echo "❌ ERROR: PHP 8.2+ diperlukan! Versi kamu: $phpVersion\n";
    echo "   Coba: /usr/local/php84/bin/php cpanel_setup.php\n";
    exit(1);
}
echo "✅ PHP version OK\n\n";

// Cek .env ada
if (!file_exists('.env')) {
    echo "❌ ERROR: File .env tidak ditemukan!\n";
    echo "   Copy dari .env.cpanel: cp .env.cpanel .env\n";
    echo "   Lalu edit .env sesuai konfigurasi MySQL cPanel kamu.\n";
    exit(1);
}
echo "✅ .env ditemukan\n";

// Cek DB_CONNECTION di .env bukan sqlite
$envContent = file_get_contents('.env');
if (str_contains($envContent, 'DB_CONNECTION=sqlite')) {
    echo "❌ ERROR: .env masih pakai SQLite!\n";
    echo "   Edit .env: ubah DB_CONNECTION=sqlite → DB_CONNECTION=mysql\n";
    echo "   Dan isi DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD\n";
    exit(1);
}
echo "✅ .env DB connection = MySQL\n\n";

// Cek folder storage bisa ditulis
$storagePaths = [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) mkdir($path, 0755, true);
    if (!is_writable($path)) chmod($path, 0755);
    echo "✅ Writable: $path\n";
}

echo "\n";
echo "========================================\n";
echo "  Langkah Selanjutnya:\n";
echo "========================================\n";
echo "1. Jalankan: php artisan key:generate\n";
echo "2. Jalankan: php artisan migrate --force\n";
echo "3. Jalankan: php artisan config:cache\n";
echo "4. Jalankan: php artisan route:cache\n";
echo "5. Jalankan: php artisan storage:link\n";
echo "\n";
echo "Atau jalankan semuanya sekaligus:\n";
echo "   bash deploy.sh\n\n";
