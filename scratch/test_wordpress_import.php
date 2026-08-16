<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\SiteSetting;
use App\Http\Controllers\Admin\CmsController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

echo "=== TESTING WORDPRESS XML IMPORT SUITE ===\n\n";

$admin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($admin);

$cmsCtrl = new CmsController();
$xmlPath = storage_path('app/test_wordpress_export.xml');

// 1. Test Server File Path Import (Supports 100MB+ without HTTP post size limits)
echo "1. Testing Server File Path Import ('{$xmlPath}')...\n";
$reqPath = Request::create('/admin/cms/import-wordpress', 'POST', [
    'server_file_path' => $xmlPath,
]);

$resPath = $cmsCtrl->importWordPress($reqPath);
assert($resPath->isRedirect(), "Must return a redirect response");
assert(session('success') !== null, "Must set success message in session");
echo "✓ " . session('success') . "\n\n";

// 2. Verify Data Saved to SiteSetting
$newsData = json_decode(SiteSetting::get('cms_news_data', '[]'), true);
$articleData = json_decode(SiteSetting::get('cms_article_data', '[]'), true);

$foundNews = false;
foreach ($newsData as $n) {
    if (str_contains($n['title'], 'Wisuda Tahfidz')) {
        $foundNews = true;
        break;
    }
}

$foundArticle = false;
foreach ($articleData as $a) {
    if (str_contains($a['title'], 'Pentingnya Menanamkan Adab')) {
        $foundArticle = true;
        break;
    }
}

assert($foundNews === true, "Imported news must be present in cms_news_data");
assert($foundArticle === true, "Imported article must be present in cms_article_data");
echo "✓ 2. Verified WordPress news & articles stored in CMS SiteSetting data!\n\n";

// 3. Test Artisan Command CLI
echo "3. Testing Artisan Command 'php artisan wp:import'...\n";
$exitCode = \Illuminate\Support\Facades\Artisan::call('wp:import', [
    'file' => $xmlPath,
]);
assert($exitCode === 0, "Artisan command wp:import must exit with code 0");
echo "✓ 3. Artisan command wp:import passed successfully!\n\n";

echo "=== ALL WORDPRESS XML IMPORT TESTS PASSED 100%! ===\n";
