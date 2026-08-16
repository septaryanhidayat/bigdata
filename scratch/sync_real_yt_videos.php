<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;
use App\Http\Controllers\SchoolWebsiteController;

$ctrl = new SchoolWebsiteController();
$realVideos = $ctrl->getVideoData();

SiteSetting::set('cms_video_data', json_encode($realVideos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Successfully saved " . count($realVideos) . " authentic SIT Robbani YouTube videos to database SiteSetting!\n";

foreach ($realVideos as $idx => $v) {
    echo ($idx + 1) . ". [ID: {$v['youtube_id']}] [{$v['category']}] {$v['title']}\n";
}
