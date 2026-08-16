<?php

$filePath = __DIR__ . '/../public/images/sitrobbani.WordPress.2026-08-16.xml';

$reader = new XMLReader();
$reader->open($filePath, null, LIBXML_NONET | LIBXML_NOBLANKS);

$posts = [];

while ($reader->read()) {
    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'item') {
        $nodeXml = $reader->readOuterXML();
        $item = simplexml_load_string($nodeXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$item) continue;

        $namespaces = $item->getNamespaces(true);
        $wpNs = $item->children($namespaces['wp'] ?? 'http://wordpress.org/export/1.1/');
        $contentNs = $item->children($namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/');

        $postType = (string) $wpNs->post_type;
        $postStatus = (string) $wpNs->status;

        if ($postType === 'post' && $postStatus === 'publish') {
            $title = (string) $item->title;
            $postDate = (string) $wpNs->post_date;
            $content = (string) $contentNs->encoded;

            $cats = [];
            if (isset($item->category)) {
                foreach ($item->category as $cat) {
                    $cats[] = (string) $cat;
                }
            }

            $posts[] = [
                'title' => $title,
                'date' => $postDate,
                'timestamp' => strtotime($postDate),
                'categories' => $cats,
                'content_snippet' => substr(strip_tags($content), 0, 100),
            ];
        }
    }
}
$reader->close();

echo "Total published posts: " . count($posts) . "\n";

// Sort descending by timestamp
usort($posts, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

echo "\n--- 10 NEWEST POSTS (Sorted Descending) ---\n";
for ($i = 0; $i < min(10, count($posts)); $i++) {
    echo ($i+1) . ". [{$posts[$i]['date']}] {$posts[$i]['title']} (Cats: " . implode(', ', $posts[$i]['categories']) . ")\n";
}

echo "\n--- 5 OLDEST POSTS ---\n";
for ($i = count($posts) - 5; $i < count($posts); $i++) {
    echo ($i+1) . ". [{$posts[$i]['date']}] {$posts[$i]['title']}\n";
}
