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
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return 1;
        }

        $this->info("Memulai proses parsing file WordPress XML: {$filePath}...");

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xml === false) {
            $this->error("Gagal membaca file XML. Pastikan format file adalah ekspor resmi WordPress (WXR).");
            return 1;
        }

        $namespaces = $xml->getNamespaces(true);
        $items = $xml->channel->item;

        $importedNews = [];
        $importedArticles = [];
        $count = 0;

        foreach ($items as $item) {
            $contentNs = $item->children($namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/');
            $excerptNs = $item->children($namespaces['excerpt'] ?? 'http://wordpress.org/export/1.1/excerpt/');
            $wpNs = $item->children($namespaces['wp'] ?? 'http://wordpress.org/export/1.1/');

            $postType = (string) $wpNs->post_type;
            $postStatus = (string) $wpNs->status;

            if ($postType !== 'post' || $postStatus !== 'publish') {
                continue;
            }

            $title = (string) $item->title;
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
            foreach ($item->category as $cat) {
                $domain = (string) $cat['domain'];
                if ($domain === 'category') {
                    $category = (string) $cat;
                    break;
                }
            }

            // Search for image in content or default
            $image = '/images/mockup_desktop_1.png';
            if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $matches)) {
                $image = $matches[1];
            }

            $postData = [
                'title' => $title,
                'slug' => $slug,
                'category' => $category,
                'date' => $formattedDate,
                'author' => 'Admin WordPress',
                'image' => $image,
                'excerpt' => $excerpt,
                'content' => $content,
            ];

            if (Str::contains(strtolower($category), ['artikel', 'edukasi', 'opini', 'tips', 'kajian'])) {
                $importedArticles[] = $postData;
            } else {
                $importedNews[] = $postData;
            }

            $count++;
            $this->line("✔ Berhasil memproses: {$title} [{$category}]");
        }

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
