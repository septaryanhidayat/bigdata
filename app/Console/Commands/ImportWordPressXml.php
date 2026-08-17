<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

class ImportWordPressXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:import {file : Path to WordPress XML export file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import WordPress posts, articles, news, and GTK teachers from a WXR XML export file into Laravel CMS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        @ini_set('memory_limit', '1024M');
        @set_time_limit(600);

        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return 1;
        }

        // Detect unit code from filename or content
        $filename = strtolower(basename($filePath));
        $unitCode = 'smpit';
        if (str_contains($filename, 'tkit')) {
            $unitCode = 'tkit';
        } elseif (str_contains($filename, 'sdit') || str_contains($filename, 'sdislamterpadu')) {
            $unitCode = 'sdit';
        } elseif (str_contains($filename, 'smait')) {
            $unitCode = 'smait';
        } elseif (str_contains($filename, 'smpit')) {
            $unitCode = 'smpit';
        }

        // Streaming XMLReader parser
        $reader = new \XMLReader();
        if (!$reader->open($filePath, null, LIBXML_NONET | LIBXML_NOBLANKS | LIBXML_PARSEHUGE)) {
            $this->error("Gagal membuka file XML. Pastikan format file adalah ekspor resmi WordPress (WXR).");
            return 1;
        }

        $attachmentMap = [];
        $gtkList = [];
        $importedNews = [];
        $importedArticles = [];
        $count = 0;

        libxml_use_internal_errors(true);

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->name == 'item') {
                $nodeXml = $reader->readOuterXML();
                $item = simplexml_load_string($nodeXml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_PARSEHUGE);
                if (!$item) continue;

                $namespaces = $item->getNamespaces(true);
                $wpNs = $item->children($namespaces['wp'] ?? 'http://wordpress.org/export/1.1/');
                $contentNs = $item->children($namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/');
                $excerptNs = $item->children($namespaces['excerpt'] ?? 'http://wordpress.org/export/1.1/excerpt/');

                $postType = (string) $wpNs->post_type;
                $postId = (int) $wpNs->post_id;
                $title = trim((string) $item->title);
                $content = (string) $contentNs->encoded;
                $excerpt = (string) $excerptNs->encoded;
                $postDate = (string) $wpNs->post_date;
                $status = (string) $wpNs->status;

                // Index attachment URLs
                if ($postType === 'attachment') {
                    $attachmentUrl = (string) $wpNs->attachment_url;
                    if ($attachmentUrl) {
                        $attachmentMap[$postId] = [
                            'url' => $attachmentUrl,
                            'title' => $title,
                        ];
                    }
                    continue;
                }

                $thumbnailId = null;
                if (isset($wpNs->postmeta)) {
                    foreach ($wpNs->postmeta as $meta) {
                        if ((string) $meta->meta_key === '_thumbnail_id') {
                            $thumbnailId = (int) $meta->meta_value;
                            break;
                        }
                    }
                }

                $categories = [];
                $taxonomies = [];
                if (isset($item->category)) {
                    foreach ($item->category as $cat) {
                        $domain = (string) $cat['domain'];
                        $catVal = (string) $cat;
                        $taxonomies[$domain][] = $catVal;
                        if ($domain === 'category' || $domain === 'blog-kat') {
                            $categories[] = $catVal;
                        }
                    }
                }

                // Handle GTK / Teachers
                if ($postType === 'gtk') {
                    $gtkList[] = [
                        'id' => $postId,
                        'name' => $title,
                        'thumbnail_id' => $thumbnailId,
                        'taxonomies' => $taxonomies,
                        'bio' => trim(strip_tags($content))
                    ];
                    continue;
                }

                // Handle Posts, Prestasi, Editorial, Blog, Pengumuman
                if (in_array($postType, ['post', 'prestasi', 'editorial', 'blog', 'pengumuman']) && $status === 'publish') {
                    if (empty($title)) continue;

                    if (empty($excerpt)) {
                        $excerpt = Str::limit(strip_tags($content), 160);
                    }

                    $formattedDate = !empty($postDate) ? date('d F Y', strtotime($postDate)) : date('d F Y');
                    $timestamp = !empty($postDate) ? strtotime($postDate) : time();
                    $slug = (string) $wpNs->post_name;
                    if (empty($slug)) {
                        $slug = Str::slug($title);
                    }

                    $category = strtoupper($unitCode);
                    if (!empty($categories)) {
                        $category = $categories[0];
                    } elseif ($postType === 'prestasi') {
                        $category = 'Prestasi ' . strtoupper($unitCode);
                    } elseif ($postType === 'editorial' || $postType === 'blog') {
                        $category = 'Artikel ' . strtoupper($unitCode);
                    }

                    $postData = [
                        'title' => $title,
                        'slug' => $slug,
                        'category' => $category,
                        'unit' => $unitCode,
                        'date' => $formattedDate,
                        'timestamp' => $timestamp,
                        'author' => 'Humas ' . strtoupper($unitCode) . ' Robbani',
                        'image' => null,
                        'excerpt' => $excerpt,
                        'content' => $content,
                        'wp_thumbnail_id' => $thumbnailId,
                        'post_type' => $postType,
                    ];

                    if ($postType === 'editorial' || $postType === 'blog' || Str::contains(strtolower($category), ['artikel', 'edukasi', 'opini', 'tips', 'kajian'])) {
                        $importedArticles[] = $postData;
                    } else {
                        $importedNews[] = $postData;
                    }

                    $count++;
                    $this->line("✔ Berhasil memproses: {$title} [{$category}]");
                }
            }
        }
        $reader->close();

        // Resolve thumbnail URLs
        $resolveImages = function(&$items) use ($attachmentMap) {
            foreach ($items as &$p) {
                $thumbId = $p['wp_thumbnail_id'] ?? null;
                if ($thumbId && isset($attachmentMap[$thumbId])) {
                    $p['image'] = $attachmentMap[$thumbId]['url'];
                } elseif (!empty($p['content']) && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $p['content'], $matches)) {
                    $p['image'] = $matches[1];
                } else {
                    $p['image'] = '/images/hero_3d_illustration_1786347707126.png';
                }
                unset($p['wp_thumbnail_id']);
            }
        };

        $resolveImages($importedNews);
        $resolveImages($importedArticles);

        // Process GTK & Unit Profile if GTK items found
        if (count($gtkList) > 0) {
            $formattedTeachers = [];
            $principalName = null;
            $principalPhoto = null;
            $principalTitle = 'Kepala Sekolah ' . strtoupper($unitCode) . ' Robbani Ogan Ilir';

            foreach ($gtkList as $g) {
                $photo = isset($attachmentMap[$g['thumbnail_id']]) ? $attachmentMap[$g['thumbnail_id']]['url'] : '/images/logo-robbani-official.png';
                $roles = $g['taxonomies']['jab'] ?? ['Guru ' . strtoupper($unitCode)];
                $roleStr = implode(', ', $roles);

                if (stripos($g['name'], 'Tia Wulandari') !== false || stripos($roleStr, 'Kepala Sekolah') !== false || stripos($roleStr, 'Kepsek') !== false) {
                    $principalName = $g['name'];
                    $principalPhoto = $photo;
                }

                $formattedTeachers[] = [
                    'name' => $g['name'],
                    'role' => $roleStr,
                    'photo' => $photo,
                    'bio' => $g['bio']
                ];
            }

            // Fetch existing unit profile or create
            $existingProfileJson = SiteSetting::get("unit_profile_{$unitCode}");
            $profile = $existingProfileJson ? json_decode($existingProfileJson, true) : [];
            
            if ($principalName) {
                $profile['principal_name'] = $principalName;
                $profile['principal_photo'] = $principalPhoto;
                $profile['principal_title'] = $principalTitle;
            }
            if (count($formattedTeachers) > 0) {
                $profile['teachers'] = $formattedTeachers;
                $profile['employees_count'] = count($formattedTeachers);
            }

            SiteSetting::set("unit_profile_{$unitCode}", json_encode($profile, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $this->info("✔ Data GTK & Kepala Sekolah unit [{$unitCode}] berhasil disinkronkan ({$principalName}).");
        }

        if ($count === 0 && count($gtkList) === 0) {
            $this->warn("Tidak ada konten yang dapat diproses.");
            return 0;
        }

        // Merge and Deduplicate News Data
        $existingNews = json_decode(SiteSetting::get('cms_news_data') ?? '[]', true) ?: [];
        $existingNewsMap = [];
        foreach ($existingNews as $idx => $item) {
            $s = $item['slug'] ?? Str::slug($item['title']);
            $existingNewsMap[$s] = $idx;
        }

        foreach ($importedNews as $item) {
            $s = $item['slug'];
            if (isset($existingNewsMap[$s])) {
                $existingNews[$existingNewsMap[$s]] = array_merge($existingNews[$existingNewsMap[$s]], $item);
            } else {
                $existingNews[] = $item;
                $existingNewsMap[$s] = count($existingNews) - 1;
            }
        }

        usort($existingNews, function($a, $b) {
            $tA = isset($a['timestamp']) ? (int)$a['timestamp'] : strtotime($a['date'] ?? 'now');
            $tB = isset($b['timestamp']) ? (int)$b['timestamp'] : strtotime($b['date'] ?? 'now');
            return $tB <=> $tA;
        });
        SiteSetting::set('cms_news_data', json_encode($existingNews, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        // Merge and Deduplicate Articles Data
        $existingArticles = json_decode(SiteSetting::get('cms_article_data') ?? '[]', true) ?: [];
        $existingArticleMap = [];
        foreach ($existingArticles as $idx => $art) {
            $s = $art['slug'] ?? Str::slug($art['title']);
            $existingArticleMap[$s] = $idx;
        }

        foreach ($importedArticles as $art) {
            $s = $art['slug'];
            if (isset($existingArticleMap[$s])) {
                $existingArticles[$existingArticleMap[$s]] = array_merge($existingArticles[$existingArticleMap[$s]], $art);
            } else {
                $existingArticles[] = $art;
                $existingArticleMap[$s] = count($existingArticles) - 1;
            }
        }

        usort($existingArticles, function($a, $b) {
            $tA = isset($a['timestamp']) ? (int)$a['timestamp'] : strtotime($a['date'] ?? 'now');
            $tB = isset($b['timestamp']) ? (int)$b['timestamp'] : strtotime($b['date'] ?? 'now');
            return $tB <=> $tA;
        });
        SiteSetting::set('cms_article_data', json_encode($existingArticles, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->info("\n🎉 SUKSES! Total {$count} konten dan " . count($gtkList) . " GTK WordPress berhasil di-import ke CMS Laravel.");
        $this->info("Detail: " . count($importedNews) . " Berita, " . count($importedArticles) . " Artikel, Unit: [{$unitCode}].");
        return 0;
    }
}
