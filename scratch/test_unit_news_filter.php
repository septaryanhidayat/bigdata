<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\SchoolWebsiteController;

$ctrl = new SchoolWebsiteController();

foreach (['tkit', 'sdit', 'smpit', 'smait'] as $code) {
    $allNews = $ctrl->getNewsData();
    $unitNews = collect($allNews)->filter(function($item) use ($code) {
        $u = strtolower($item['unit'] ?? '');
        $cat = strtolower($item['category'] ?? '');
        $title = strtolower($item['title'] ?? '');
        return $u === $code || str_contains($cat, $code) || str_contains($title, $code);
    })->values();

    echo "=== UNIT: " . strtoupper($code) . " (Count: " . count($unitNews) . ") ===\n";
    for ($i = 0; $i < min(3, count($unitNews)); $i++) {
        echo "  " . ($i+1) . ". [{$unitNews[$i]['date']}] {$unitNews[$i]['title']}\n";
    }
    echo "\n";
}
