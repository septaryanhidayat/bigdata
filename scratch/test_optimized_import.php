<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;

$filePath = __DIR__ . '/../public/images/sitrobbani.WordPress.2026-08-16.xml';

$startTime = microtime(true);
echo "=== TESTING ULTRA-FAST STREAM PARSER FOR 9.8MB XML ===\n";

// Pass 1: Build Attachment ID -> Attachment URL map
$reader = new XMLReader();
$reader->open($filePath, null, LIBXML_NONET | LIBXML_NOBLANKS);

$attachmentMap = [];
$publishedPosts = [];
$publishedArticles = [];

while ($reader->read()) {
    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'item') {
        $node = $reader->readOuterXML();
        $item = simplexml_load_string($node, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$item) continue;

        $namespaces = $item->getNamespaces(true);
        $wpNs = $item->children($namespaces['wp'] ?? 'http://wordpress.org/export/1.1/');
        $contentNs = $item->children($namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/');
        $excerptNs = $item->children($namespaces['excerpt'] ?? 'http://wordpress.org/export/1.1/excerpt/');

        $postType = (string) $wpNs->post_type;
        $postId = (int) $wpNs->post_id;

        // Save attachment URL
        if ($postType === 'attachment') {
            $attachmentUrl = (string) $wpNs->attachment_url;
            if ($attachmentUrl) {
                $attachmentMap[$postId] = $attachmentUrl;
            }
            continue;
        }

        // Process published posts
        $postStatus = (string) $wpNs->status;
        if ($postType === 'post' && $postStatus === 'publish') {
            $title = trim((string) $item->title);
            if (empty($title)) continue;

            $content = (string) $contentNs->encoded;
            $excerpt = (string) $excerptNs->encoded;
            if (empty($excerpt)) {
                $excerpt = \Illuminate\Support\Str::limit(strip_tags($content), 160);
            }

            $postDate = (string) $wpNs->post_date;
            $formattedDate = !empty($postDate) ? date('d F Y', strtotime($postDate)) : date('d F Y');
            $slug = (string) $wpNs->post_name;
            if (empty($slug)) {
                $slug = \Illuminate\Support\Str::slug($title);
            }

            // Category resolution
            $category = 'Berita';
            if (isset($item->category)) {
                foreach ($item->category as $cat) {
                    $domain = (string) $cat['domain'];
                    if ($domain === 'category') {
                        $category = (string) $cat;
                        break;
                    }
                }
            }

            // Extract featured image from thumbnail_id or img in content
            $thumbnailId = null;
            if (isset($wpNs->postmeta)) {
                foreach ($wpNs->postmeta as $meta) {
                    if ((string) $meta->meta_key === '_thumbnail_id') {
                        $thumbnailId = (int) $meta->meta_value;
                        break;
                    }
                }
            }

            $image = null;
            if ($thumbnailId && isset($attachmentMap[$thumbnailId])) {
                $image = $attachmentMap[$thumbnailId];
            } elseif (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches)) {
                $image = $matches[1];
            } else {
                $image = '/images/mockup_desktop_1.png';
            }

            $postData = [
                'title' => $title,
                'slug' => $slug,
                'category' => $category,
                'date' => $formattedDate,
                'author' => 'Admin SIT Robbani',
                'image' => $image,
                'excerpt' => $excerpt,
                'content' => $content,
                'wp_thumbnail_id' => $thumbnailId,
            ];

            if (\Illuminate\Support\Str::contains(strtolower($category), ['artikel', 'edukasi', 'opini', 'tips', 'kajian'])) {
                $publishedArticles[] = $postData;
            } else {
                $publishedNews[] = $postData;
            }
        }
    }
}
$reader->close();

// Resolve any thumbnail IDs that were parsed after the post
foreach ($publishedNews as &$pn) {
    if (empty($pn['image']) || $pn['image'] === '/images/mockup_desktop_1.png') {
        if (!empty($pn['wp_thumbnail_id']) && isset($attachmentMap[$pn['wp_thumbnail_id']])) {
            $pn['image'] = $attachmentMap[$pn['wp_thumbnail_id']];
        }
    }
    unset($pn['wp_thumbnail_id']);
}
unset($pn);

foreach ($publishedArticles as &$pa) {
    if (empty($pa['image']) || $pa['image'] === '/images/mockup_desktop_1.png') {
        if (!empty($pa['wp_thumbnail_id']) && isset($attachmentMap[$pa['wp_thumbnail_id']])) {
            $pa['image'] = $attachmentMap[$pa['wp_thumbnail_id']];
        }
    }
    unset($pa['wp_thumbnail_id']);
}
unset($pa);

$duration = round(microtime(true) - $startTime, 3);
$total = count($publishedNews) + count($publishedArticles);
echo "✓ Parsed {$total} posts (" . count($publishedNews) . " Berita, " . count($publishedArticles) . " Artikel, " . count($attachmentMap) . " Gambar Attachment) in {$duration} seconds!\n";

// Save into SiteSetting
SiteSetting::set('cms_news_data', json_encode($publishedNews, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
SiteSetting::set('cms_article_data', json_encode($publishedArticles, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

$saveDuration = round(microtime(true) - $startTime, 3);
echo "✓ Saved all {$total} items to Database in {$saveDuration}s total!\n";
