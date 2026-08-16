<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\SchoolWebsiteController;

echo "=== TESTING REAL UNIT NEWS RENDERING IN HOMEPAGE & UNIT PROFILES ===\n\n";

$ctrl = new SchoolWebsiteController();

// 1. Test Homepage
$homeView = $ctrl->index();
$renderedHome = $homeView->render();

assert(str_contains($renderedHome, 'KABAR KHUSUS UNIT'), "Homepage must contain unit news section");
assert(str_contains($renderedHome, 'Tingkatkan Kompetensi Digital') || str_contains($renderedHome, 'Penandatanganan KPI Unit'), "Homepage must contain real TKIT/SDIT/SMPIT news from WordPress");
echo "✓ Homepage (/) successfully renders dynamic real WordPress news!\n";

// 2. Test Unit TKIT
$tkitView = $ctrl->unitProfile('tkit');
$renderedTkit = $tkitView->render();
assert(str_contains($renderedTkit, 'Berita &amp; Kegiatan') || str_contains($renderedTkit, 'Berita & Kegiatan'), "TKIT page must contain unit news heading");
assert(str_contains($renderedTkit, 'Tingkatkan Kompetensi Digital') || str_contains($renderedTkit, 'Penandatanganan KPI Unit'), "TKIT page must contain real TKIT WordPress posts!");
echo "✓ Unit Profile (/unit/tkit) successfully renders real TKIT WordPress news!\n";

// 3. Test Unit SDIT
$sditView = $ctrl->unitProfile('sdit');
$renderedSdit = $sditView->render();
assert(str_contains($renderedSdit, 'Berita &amp; Kegiatan SDIT Robbani') || str_contains($renderedSdit, 'Berita & Kegiatan SDIT Robbani'), "SDIT page must contain unit news heading");
assert(str_contains($renderedSdit, 'Haflah Akhirussanah') || str_contains($renderedSdit, 'Rekrutmen Guru'), "SDIT page must contain real SDIT WordPress posts!");
echo "✓ Unit Profile (/unit/sdit) successfully renders real SDIT WordPress news!\n";

// 4. Test Unit SMPIT
$smpitView = $ctrl->unitProfile('smpit');
$renderedSmpit = $smpitView->render();
assert(str_contains($renderedSmpit, 'Berita &amp; Kegiatan') || str_contains($renderedSmpit, 'Berita & Kegiatan'), "SMPIT page must contain unit news heading");
assert(str_contains($renderedSmpit, 'Kepala SMP IT Robbani') || str_contains($renderedSmpit, 'Jambore GTK'), "SMPIT page must contain real SMPIT WordPress posts!");
echo "✓ Unit Profile (/unit/smpit) successfully renders real SMPIT WordPress news!\n";

// 5. Test Unit SMAIT
$smaitView = $ctrl->unitProfile('smait');
$renderedSmait = $smaitView->render();
assert(str_contains($renderedSmait, 'Berita &amp; Kegiatan') || str_contains($renderedSmait, 'Berita & Kegiatan'), "SMAIT page must contain unit news heading");
echo "✓ Unit Profile (/unit/smait) successfully renders campus news!\n";

// 6. Test All Berita Archive (/berita)
$beritaView = $ctrl->beritaIndex();
$renderedBerita = $beritaView->render();
assert(str_contains($renderedBerita, 'activeCategory = \'tkit\''), "Berita index must have activeCategory tkit filter");
echo "✓ Berita Index (/berita) filter chips and real news render properly!\n";

echo "\n=== ALL UNIT & HOMEPAGE REAL NEWS TESTS PASSED 100%! ===\n";
