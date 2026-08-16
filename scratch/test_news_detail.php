<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\SchoolWebsiteController;
use Illuminate\Http\Request;

echo "=== TESTING NEWS & ARTICLE DETAIL PAGE 2-COLUMN LAYOUT ===\n\n";

$controller = app(SchoolWebsiteController::class);

// 1. Test beritaIndex
$response = $controller->beritaIndex();
assert($response instanceof \Illuminate\View\View, "Berita index should return a View");
echo "✓ 1. Berita Index View loaded successfully!\n";

// 2. Test beritaShow
$newsList = $controller->getNewsData();
$firstNewsSlug = $newsList[0]['slug'] ?? 'upgrading-sdm-sit-robbani';
$responseShow = $controller->beritaShow($firstNewsSlug);
$html = $responseShow->render();

assert(str_contains($html, 'lg:col-span-8'), "Main news article must use lg:col-span-8 for wide desktop layout");
assert(str_contains($html, 'lg:col-span-4'), "Sidebar must use lg:col-span-4 for consolidated widgets");
assert(str_contains($html, 'prose-content'), "Prose content styling must be present");
assert(str_contains($html, 'inline-icon-img'), "Small icon constraints must be present");
assert(str_contains($html, 'Berita Terpopuler'), "Popular news widget must be present");
assert(str_contains($html, 'Kategori &amp; Unit Sekolah') || str_contains($html, 'Kategori & Unit Sekolah'), "Category widget must be present");
assert(str_contains($html, 'Kontak Humas SIT Robbani'), "Humas contact widget must be present");
echo "✓ 2. Berita Detail 2-Column layout & all consolidated widgets confirmed!\n";

// 3. Test artikelShow
$articleList = $controller->getArticleData();
$firstArticleSlug = $articleList[0]['slug'] ?? 'peran-orang-tua-mendidik-generasi-qurani';
$responseArticle = $controller->artikelShow($firstArticleSlug);
$articleHtml = $responseArticle->render();
assert(str_contains($articleHtml, 'lg:col-span-8'), "Article view must use lg:col-span-8");
assert(str_contains($articleHtml, 'lg:col-span-4'), "Article view must use lg:col-span-4");
echo "✓ 3. Artikel Detail 2-Column layout confirmed!\n";

echo "\n=== ALL 2-COLUMN NEWS & ARTICLE LAYOUT TESTS PASSED 100%! ===\n";
