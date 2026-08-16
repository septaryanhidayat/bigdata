<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\SchoolWebsiteController;

echo "=== TESTING SMARTEDU DIGITAL ECOSYSTEM SHOWCASE ON HOMEPAGE ===\n\n";

$ctrl = new SchoolWebsiteController();
$homeView = $ctrl->index();
$rendered = $homeView->render();

// 1. Check Section Presence
assert(str_contains($rendered, 'id="smartedu-ekosistem"'), "Homepage must have smartedu-ekosistem section");
assert(str_contains($rendered, 'EKOSISTEM DIGITAL SMARTEDU TERPADU'), "Section must have banner badge");
echo "✓ 1. SmartEdu Ecosystem section container is present!\n";

// 2. Check Key Modules in the 22 module list
$sampleModules = [
    'LMS &amp; Kelas Online',
    'CBT Ujian &amp; Asesmen',
    'E-Rapor Merdeka',
    'Presensi Digital Realtime',
    'Jurnal Mengajar Guru',
    'Tagihan SPP &amp; Pos Bayar',
    'Tabungan Santri Digital',
    'Kantin Smart RFID POS',
    'Laporan Kas &amp; Audit',
    'Persuratan &amp; Agenda',
    'TTE Digital QR &amp; SHA-256',
    'Disposisi Instruksi',
    'Isolasi Data Per-Unit',
    'Bina Pribadi Islami (BPI)',
    'Mutabaah &amp; Tahfidz Tracker',
    'Bimbingan Konseling &amp; Prestasi',
    'E-Library &amp; Sirkulasi Buku',
    'Sarpras &amp; Inventaris Aset',
    'HRIS &amp; Payroll Gaji Pegawai',
    'CMS Website &amp; Profil Unit',
    'SPMB Online Terpadu',
    'Manajemen 15 Hak Akses'
];

foreach ($sampleModules as $mod) {
    assert(str_contains($rendered, $mod), "Must contain module: {$mod}");
}
echo "✓ 2. All 22 digital modules are properly rendered with rich styling!\n";

// 3. Check Quick Menu & Navigation links
assert(str_contains($rendered, 'href="#smartedu-ekosistem"'), "Quick menu and drawer must link to #smartedu-ekosistem");
assert(str_contains($rendered, '22 Modul'), "Quick menu badge must say 22 Modul");
echo "✓ 3. Quick Menu & Mobile Drawer links are active!\n";

echo "\n=== ALL SMARTEDU SHOWCASE TESTS PASSED 100%! ===\n";
