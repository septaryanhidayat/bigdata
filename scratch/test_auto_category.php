<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;

$filePath = __DIR__ . '/../public/images/sitrobbani.WordPress.2026-08-16.xml';

echo "=== TESTING AUTO-CATEGORIZATION & DATE DESCENDING SORT ===\n\n";

$reader = new XMLReader();
$reader->open($filePath, null, LIBXML_NONET | LIBXML_NOBLANKS | LIBXML_PARSEHUGE);

$attachmentMap = [];
$allItems = [];

libxml_use_internal_errors(true);

while ($reader->read()) {
    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'item') {
        $nodeXml = $reader->readOuterXML();
        $item = simplexml_load_string($nodeXml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_PARSEHUGE);
        if (!$item) continue;

        $namespaces = $item->getNamespaces(true);
        $wpNs = $item->children($namespaces['wp'] ?? 'http://wordpress.org/export/1.1/');
        $contentNs = $item->children($namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/');
        $excerptNs = $item->children($namespaces['excerpt'] ?? 'http://wordpress.org/export/1.1/excerpt/');

        $postType = (string) $wpNs->post_type;
        $postId = (int) $wpNs->post_id;

        // 1. Index attachments
        if ($postType === 'attachment') {
            $attachmentUrl = (string) $wpNs->attachment_url;
            if ($attachmentUrl) {
                $attachmentMap[$postId] = $attachmentUrl;
            }
            continue;
        }

        // 2. Published Posts
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
            $timestamp = !empty($postDate) ? strtotime($postDate) : time();
            $formattedDate = !empty($postDate) ? date('d F Y', $timestamp) : date('d F Y');
            
            $slug = (string) $wpNs->post_name;
            if (empty($slug)) {
                $slug = \Illuminate\Support\Str::slug($title);
            }

            // Extract WP Categories
            $wpCategories = [];
            if (isset($item->category)) {
                foreach ($item->category as $cat) {
                    $domain = (string) $cat['domain'];
                    if ($domain === 'category') {
                        $wpCategories[] = (string) $cat;
                    }
                }
            }

            // Extract Thumbnail
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

            // -------------------------------------------------------------
            // INTELLIGENT UNIT AUTO-CATEGORIZATION ENGINE
            // -------------------------------------------------------------
            $searchCorpus = strtolower($title . ' ' . implode(' ', $wpCategories) . ' ' . substr(strip_tags($content), 0, 1500));
            
            $isArticle = \Illuminate\Support\Str::contains(strtolower(implode(' ', $wpCategories) . ' ' . $title), ['artikel', 'edukasi', 'opini', 'tips', 'kajian', 'parenting', 'tata cara', 'keutamaan']);
            
            $unitCode = 'yayasan';
            $unitName = 'Yayasan Robbani';
            
            if (preg_match('/\b(tkit|tk\s*it|paud|kelompok\s*bermain|taman\s*kanak|kb[\/\-]?tk|kb[\/\-]?tkit)\b/i', $searchCorpus)) {
                $unitCode = 'tkit';
                $unitName = 'KB/TKIT Robbani';
            } elseif (preg_match('/\b(sdit|sd\s*it|sekolah\s*dasar|sd\s*robbani|pramuka\s*siaga|kelas\s*[1-6])\b/i', $searchCorpus)) {
                $unitCode = 'sdit';
                $unitName = 'SDIT Robbani';
            } elseif (preg_match('/\b(smpit|smp\s*it|sekolah\s*menengah\s*pertama|smp\s*robbani|boarding|asrama\s*putr|santri\s*smp)\b/i', $searchCorpus)) {
                $unitCode = 'smpit';
                $unitName = 'SMPIT Robbani';
            } elseif (preg_match('/\b(smait|sma\s*it|sekolah\s*menengah\s*atas|sma\s*robbani|santri\s*sma|jurusan\s*(ipa|ips)|snbt|utbk)\b/i', $searchCorpus)) {
                $unitCode = 'smait';
                $unitName = 'SMAIT Robbani';
            }

            if ($unitCode === 'tkit') {
                $category = $isArticle ? 'Artikel TKIT' : 'Berita TKIT';
            } elseif ($unitCode === 'sdit') {
                $category = $isArticle ? 'Artikel SDIT' : 'Berita SDIT';
            } elseif ($unitCode === 'smpit') {
                $category = $isArticle ? 'Artikel SMPIT' : 'Berita SMPIT';
            } elseif ($unitCode === 'smait') {
                $category = $isArticle ? 'Artikel SMAIT' : 'Berita SMAIT';
            } else {
                $category = $isArticle ? 'Artikel Edukasi' : 'Berita Yayasan';
            }

            $allItems[] = [
                'title' => $title,
                'slug' => $slug,
                'category' => $category,
                'unit' => $unitCode,
                'unit_name' => $unitName,
                'is_article' => $isArticle,
                'date' => $formattedDate,
                'timestamp' => $timestamp,
                'raw_date' => $postDate,
                'author' => 'Admin SIT Robbani',
                'image' => $image,
                'excerpt' => $excerpt,
                'content' => $content,
                'wp_thumbnail_id' => $thumbnailId,
            ];
        }
    }
}
$reader->close();

// Resolve any thumbnails indexed later
foreach ($allItems as &$item) {
    if ((empty($item['image']) || $item['image'] === '/images/mockup_desktop_1.png') && !empty($item['wp_thumbnail_id'])) {
        if (isset($attachmentMap[$item['wp_thumbnail_id']])) {
            $item['image'] = $attachmentMap[$item['wp_thumbnail_id']];
        }
    }
    unset($item['wp_thumbnail_id']);
}
unset($item);

// SORT DESCENDING BY TIMESTAMP (Latest 2026 posts first, oldest 2021 last)
usort($allItems, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

// De-duplicate by slug
$unique = [];
$deduped = [];
foreach ($allItems as $it) {
    if (!isset($unique[$it['slug']])) {
        $unique[$it['slug']] = true;
        $deduped[] = $it;
    }
}

$newsList = array_values(array_filter($deduped, fn($x) => !$x['is_article']));
$articleList = array_values(array_filter($deduped, fn($x) => $x['is_article']));

// Unit Statistics
$unitStats = ['tkit' => 0, 'sdit' => 0, 'smpit' => 0, 'smait' => 0, 'yayasan' => 0];
foreach ($deduped as $d) {
    $unitStats[$d['unit']]++;
}

echo "✓ Total Parsed & Sorted: " . count($deduped) . " items (" . count($newsList) . " Berita & " . count($articleList) . " Artikel)\n";
echo "✓ Unit Breakdown: " . json_encode($unitStats, JSON_PRETTY_PRINT) . "\n\n";

echo "--- 5 NEWEST ITEMS (Top of the Website) ---\n";
for ($i = 0; $i < min(5, count($deduped)); $i++) {
    echo ($i+1) . ". [{$deduped[$i]['date']}] [Unit: " . strtoupper($deduped[$i]['unit']) . " / {$deduped[$i]['category']}] {$deduped[$i]['title']}\n";
}

// Save into Database
SiteSetting::set('cms_news_data', json_encode($newsList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
SiteSetting::set('cms_article_data', json_encode($articleList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "\n✓ Successfully saved all categorized & date-sorted items to SiteSetting Database!\n";
