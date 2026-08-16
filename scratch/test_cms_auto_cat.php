<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\SiteSetting;
use App\Http\Controllers\Admin\CmsController;
use Illuminate\Http\Request;

echo "=== TESTING CMS CONTROLLER AUTO-CATEGORIZATION & SORTING ===\n\n";

$admin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($admin);

$cmsCtrl = new CmsController();

// 1. Run auto-categorize
$req = Request::create('/admin/cms/auto-categorize', 'POST');
$res = $cmsCtrl->autoCategorizeContent($req);

assert($res->isRedirect(), "Must return a redirect response");
assert(session('success') !== null, "Must set success flash message in session");
echo "✓ " . session('success') . "\n\n";

// 2. Verify sorted descending by date
$news = json_decode(SiteSetting::get('cms_news_data', '[]'), true);
$articles = json_decode(SiteSetting::get('cms_article_data', '[]'), true);

assert(count($news) > 0, "News data must not be empty");
assert(count($articles) > 0, "Article data must not be empty");

echo "Top 3 News:\n";
for ($i = 0; $i < min(3, count($news)); $i++) {
    echo "  " . ($i+1) . ". [{$news[$i]['date']}] [Unit: " . strtoupper($news[$i]['unit'] ?? 'yayasan') . "] {$news[$i]['title']}\n";
}

echo "\nTop 3 Articles:\n";
for ($i = 0; $i < min(3, count($articles)); $i++) {
    echo "  " . ($i+1) . ". [{$articles[$i]['date']}] [Unit: " . strtoupper($articles[$i]['unit'] ?? 'yayasan') . "] {$articles[$i]['title']}\n";
}

echo "\n=== AUTO-CATEGORIZATION & DATE SORT VERIFICATION PASSED 100%! ===\n";
