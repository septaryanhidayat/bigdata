<?php

$ids = [
    'Q-vZ49vP1_c',
    '8yp0GZL27fU',
    'lhFR6TrEWxY',
    '9gBk0Fss9yw',
    '5ifsHX2orZ8',
    'Vj0e1PCWqJo',
    'ug0lt6LlYSs',
    'tFjiILUphjY',
    'cCRXQhYNF38',
    'RyVRofyKPP0',
    'wWCsYWuLbMI',
    'oZBAzQdiLK0',
    'BJujO04WJdQ',
    '7smS4aubVYo',
    'JR4HcgB0BB0',
    '9mDPNCwUYhA',
    '3Q9HsRpuHHQ',
    'OD3GZPdKGkk',
    'ebSKaPhWR6Y',
    'vsAxPVwDhHI',
];

$videos = [];

foreach ($ids as $id) {
    $url = "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v={$id}&format=json";
    $ctx = stream_context_create([
        'http' => [
            'timeout' => 4,
            'user_agent' => 'Mozilla/5.0'
        ]
    ]);
    $json = @file_get_contents($url, false, $ctx);
    if ($json) {
        $data = json_decode($json, true);
        if (!empty($data['title'])) {
            $videos[] = [
                'youtube_id' => $id,
                'title' => $data['title'],
                'author' => $data['author_name'] ?? 'SIT Robbani Ogan Ilir',
                'thumbnail' => "https://img.youtube.com/vi/{$id}/hqdefault.jpg",
                'desc' => $data['title'] . ' — Channel Resmi YouTube SIT Robbani Ogan Ilir',
                'category' => 'Dokumentasi',
                'duration' => 'HD'
            ];
            echo "✓ Found: [{$id}] {$data['title']}\n";
        }
    }
}

file_put_contents('scratch/sit_robbani_real_videos.json', json_encode($videos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "\nTotal fetched real videos: " . count($videos) . "\n";
