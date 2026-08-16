<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;
use App\Http\Controllers\SchoolWebsiteController;

echo "=== TESTING REAL YOUTUBE VIDEOS FROM @sitrobbanioganilir8496 ===\n\n";

$ctrl = new SchoolWebsiteController();
$videos = $ctrl->getVideoData();

assert(count($videos) >= 6, "Must have at least 6 YouTube videos");
echo "Total videos: " . count($videos) . "\n";

foreach ($videos as $idx => $v) {
    assert($v['youtube_id'] !== 'dQw4w9WgXcQ', "Must not contain demo placeholder ID dQw4w9WgXcQ");
    assert(!empty($v['title']), "Video title must not be empty");
    assert(str_starts_with($v['thumbnail'], 'https://img.youtube.com/vi/'), "Thumbnail must be real YouTube thumbnail");
    echo "  " . ($idx + 1) . ". [ID: {$v['youtube_id']}] {$v['title']}\n";
}

// Check homepage rendering
$homeView = $ctrl->index();
$rendered = $homeView->render();

assert(str_contains($rendered, 'https://www.youtube.com/@sitrobbanioganilir8496'), "Homepage must link to https://www.youtube.com/@sitrobbanioganilir8496");
assert(str_contains($rendered, 'Q-vZ49vP1_c'), "Homepage must contain Jingle video Q-vZ49vP1_c");
assert(str_contains($rendered, '8yp0GZL27fU'), "Homepage must contain MPLS video 8yp0GZL27fU");
assert(!str_contains($rendered, 'dQw4w9WgXcQ'), "Homepage must NOT contain any demo dQw4w9WgXcQ video");

echo "\n✓ Homepage renders real SIT Robbani YouTube videos & channel links perfectly!\n";
echo "\n=== ALL REAL YOUTUBE VIDEO TESTS PASSED 100%! ===\n";
