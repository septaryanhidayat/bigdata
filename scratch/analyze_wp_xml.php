<?php

$filePath = __DIR__ . '/../public/images/sitrobbani.WordPress.2026-08-16.xml';

if (!file_exists($filePath)) {
    die("File not found: $filePath\n");
}

$startTime = microtime(true);
echo "Analyzing $filePath (" . round(filesize($filePath) / (1024 * 1024), 2) . " MB)...\n";

// Use XMLReader for ultra-fast stream parsing (O(1) memory, lightning fast)
$reader = new XMLReader();
$reader->open($filePath, null, LIBXML_NONET | LIBXML_NOBLANKS);

$counts = [
    'total_items' => 0,
    'post' => 0,
    'page' => 0,
    'attachment' => 0,
    'nav_menu_item' => 0,
    'wp_block' => 0,
    'other' => 0,
    'published_posts' => 0,
];

while ($reader->read()) {
    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'item') {
        $counts['total_items']++;
        
        $itemXml = simplexml_load_string($reader->readOuterXML(), 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($itemXml) {
            $namespaces = $itemXml->getNamespaces(true);
            $wpNs = $itemXml->children($namespaces['wp'] ?? 'http://wordpress.org/export/1.1/');
            $postType = (string) $wpNs->post_type;
            $postStatus = (string) $wpNs->status;

            if (isset($counts[$postType])) {
                $counts[$postType]++;
            } else {
                $counts['other']++;
            }

            if ($postType === 'post' && $postStatus === 'publish') {
                $counts['published_posts']++;
            }
        }
    }
}
$reader->close();

$duration = round(microtime(true) - $startTime, 3);
echo "Analysis completed in {$duration}s:\n";
print_r($counts);
