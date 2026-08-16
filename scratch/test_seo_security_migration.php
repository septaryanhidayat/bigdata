<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\SchoolWebsiteController;
use Illuminate\Http\Request;

echo "=== TESTING SEO ENGINE, SECURITY HEADERS & WORDPRESS MIGRATION ===\n\n";

$controller = app(SchoolWebsiteController::class);

// 1. Test Sitemap XML
$sitemapResponse = $controller->sitemapXml();
assert($sitemapResponse->getStatusCode() === 200, "Sitemap must return HTTP 200");
$sitemapXml = $sitemapResponse->getContent();
assert(str_contains($sitemapXml, '<?xml version="1.0"'), "Sitemap must start with XML declaration");
assert(str_contains($sitemapXml, '<urlset'), "Sitemap must contain urlset tag");
assert(str_contains($sitemapXml, '/berita'), "Sitemap must contain /berita URLs");
assert(str_contains($sitemapXml, '<priority>1.0</priority>'), "Homepage must have priority 1.0");
echo "✓ 1. Dynamic XML Sitemap (/sitemap.xml) is valid & fully populated!\n";

// 2. Test Robots.txt
$robotsResponse = $controller->robotsTxt();
assert($robotsResponse->getStatusCode() === 200, "Robots.txt must return HTTP 200");
$robotsTxt = $robotsResponse->getContent();
assert(str_contains($robotsTxt, 'User-agent: *'), "Robots must contain User-agent");
assert(str_contains($robotsTxt, 'Disallow: /admin/'), "Robots must disallow /admin/");
assert(str_contains($robotsTxt, 'Sitemap:'), "Robots must link to Sitemap");
echo "✓ 2. Dynamic Robots.txt (/robots.txt) is valid & properly configured!\n";

// 3. Test WordPress Legacy 301 Permanent Redirects
$req1 = Request::create('/2022/08/16/upgrading-sdm-sit-robbani', 'GET');
$redir1 = $controller->handleWordPressLegacyRedirect($req1, '2022', '08', '16', 'upgrading-sdm-sit-robbani');
assert($redir1->getStatusCode() === 301, "Legacy WP post URL must return 301 Permanent Redirect");
echo "✓ 3. WordPress Legacy Permalink (/{year}/{month}/{day}/{slug}) 301 Redirect passed!\n";

$req2 = Request::create('/category/berita-sdit', 'GET');
$redir2 = $controller->handleWordPressLegacyRedirect($req2, 'category', 'berita-sdit');
assert($redir2->getStatusCode() === 301, "Legacy WP category URL must return 301 Redirect");
echo "✓ 4. WordPress Legacy Category (/category/{cat}) 301 Redirect passed!\n";

// 4. Test Security Headers Middleware
$middleware = new \App\Http\Middleware\SecurityHeaders();
$dummyReq = Request::create('/', 'GET');
$response = $middleware->handle($dummyReq, function ($req) {
    return response('OK', 200);
});

assert($response->headers->get('X-Frame-Options') === 'SAMEORIGIN', "X-Frame-Options must be SAMEORIGIN");
assert($response->headers->get('X-Content-Type-Options') === 'nosniff', "X-Content-Type-Options must be nosniff");
assert($response->headers->get('X-XSS-Protection') === '1; mode=block', "X-XSS-Protection must be active");
echo "✓ 5. Global Security Headers (Anti-Clickjacking, Anti-Sniffing, Anti-XSS) passed!\n";

// 5. Test JSON-LD Schema.org & Meta Tags on News View
$newsList = $controller->getNewsData();
$view = $controller->beritaShow($newsList[0]['slug']);
$rendered = $view->render();
assert(str_contains($rendered, 'application/ld+json'), "JSON-LD structured data must be in news view");
assert(str_contains($rendered, 'NewsArticle'), "NewsArticle schema must be present");
assert(str_contains($rendered, 'canonical'), "Canonical link tag must be present");
assert(str_contains($rendered, 'og:title'), "OpenGraph meta title must be present");
echo "✓ 6. News View SEO Meta Tags & Schema.org NewsArticle JSON-LD confirmed!\n";

echo "\n=== ALL SEO, SECURITY & MIGRATION TESTS PASSED 100%! ===\n";
