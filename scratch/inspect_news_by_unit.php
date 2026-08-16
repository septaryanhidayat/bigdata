<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;
use App\Http\Controllers\SchoolWebsiteController;

$ctrl = new SchoolWebsiteController();
$news = $ctrl->getNewsData();

echo "Total getNewsData count: " . count($news) . "\n";

$byUnit = [];
foreach ($news as $n) {
    $u = $n['unit'] ?? 'unassigned';
    $byUnit[$u] = ($byUnit[$u] ?? 0) + 1;
}

print_r($byUnit);

echo "\n--- 5 Samples of TKIT news ---\n";
$tkitNews = array_values(array_filter($news, fn($x) => ($x['unit'] ?? '') === 'tkit'));
for ($i = 0; $i < min(5, count($tkitNews)); $i++) {
    echo "  " . ($i+1) . ". [{$tkitNews[$i]['date']}] {$tkitNews[$i]['title']}\n";
    echo "     Category: {$tkitNews[$i]['category']} | Image: {$tkitNews[$i]['image']}\n";
}
