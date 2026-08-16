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
    protected $description = 'Import WordPress posts, articles, and news from a WXR XML export file into Laravel CMS';

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

        // Streaming XMLReader parser
        $reader = new \XMLReader();
        if (!$reader->open($filePath, null, LIBXML_NONET | LIBXML_NOBLANKS | LIBXML_PARSEHUGE)) {
            $this->error("Gagal membuka file XML. Pastikan format file adalah ekspor resmi WordPress (WXR).");
            return 1;
        }

        $attachmentMap = [];
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

                // Index attachment URLs
                if ($postType === 'attachment') {
                    $attachmentUrl = (string) $wpNs->attachment_url;
                    if ($attachmentUrl) {
                        $attachmentMap[$postId] = $attachmentUrl;
                    }
                    continue;
                }

                $postStatus = (string) $wpNs->status;
                if ($postType === 'post' && $postStatus === 'publish') {
                    $title = trim((string) $item->title);
                    if (empty($title)) continue;

                    $content = (string) $contentNs->encoded;
                    $excerpt = (string) $excerptNs->encoded;
                    if (empty($excerpt)) {
                        $excerpt = Str::limit(strip_tags($content), 160);
                    }

                    $postDate = (string) $wpNs->post_date;
                    $formattedDate = !empty($postDate) ? date('d F Y', strtotime($postDate)) : date('d F Y');
                    $slug = (string) $wpNs->post_name;
                    if (empty($slug)) {
                        $slug = Str::slug($title);
                    }

                    // Extract Category
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

                    if (Str::contains(strtolower($category), ['artikel', 'edukasi', 'opini', 'tips', 'kajian'])) {
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

        // Resolve thumbnail URLs that were defined after post item
        foreach ($importedNews as &$pn) {
            if ((empty($pn['image']) || $pn['image'] === '/images/mockup_desktop_1.png') && !empty($pn['wp_thumbnail_id'])) {
                if (isset($attachmentMap[$pn['wp_thumbnail_id']])) {
                    $pn['image'] = $attachmentMap[$pn['wp_thumbnail_id']];
                }
            }
            unset($pn['wp_thumbnail_id']);
        }
        unset($pn);

        foreach ($importedArticles as &$pa) {
            if ((empty($pa['image']) || $pa['image'] === '/images/mockup_desktop_1.png') && !empty($pa['wp_thumbnail_id'])) {
                if (isset($attachmentMap[$pa['wp_thumbnail_id']])) {
                    $pa['image'] = $attachmentMap[$pa['wp_thumbnail_id']];
                }
            }
            unset($pa['wp_thumbnail_id']);
        }
        unset($pa);

        if ($count === 0) {
            $this->warn("Tidak ada postingan bertipe 'post' dengan status 'publish' yang ditemukan.");
            return 0;
        }

        // Merge with existing CMS data if present
        $existingNewsJson = SiteSetting::get('cms_news_data');
        $existingNews = $existingNewsJson ? json_decode($existingNewsJson, true) : [];
        $finalNews = array_merge($importedNews, is_array($existingNews) ? $existingNews : []);

        $existingArticleJson = SiteSetting::get('cms_article_data');
        $existingArticles = $existingArticleJson ? json_decode($existingArticleJson, true) : [];
        $finalArticles = array_merge($importedArticles, is_array($existingArticles) ? $existingArticles : []);

        SiteSetting::set('cms_news_data', json_encode($finalNews, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        SiteSetting::set('cms_article_data', json_encode($finalArticles, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info("\n🎉 SUKSES! Total {$count} konten WordPress berhasil di-import ke CMS Laravel.");
        $this->info("Detail: " . count($importedNews) . " Berita & " . count($importedArticles) . " Artikel.");
        return 0;
    }
}
