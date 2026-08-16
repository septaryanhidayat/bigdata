<?php

$file = 'C:/Users/RYAN/.gemini/antigravity-ide/brain/e46779af-e3b5-42fc-8de1-944c8d160931/.system_generated/steps/1276/content.md';
$html = file_get_contents($file);

// Match "videoId":"..." and title
preg_match_all('/"videoId":"([a-zA-Z0-9_-]{11})"/', $html, $videoMatches);
$videoIds = array_unique($videoMatches[1] ?? []);

echo "Found " . count($videoIds) . " unique video IDs:\n";
print_r(array_values($videoIds));

// Find titles
preg_match_all('/"title":\{"runs":\[\{"text":"([^"]+)"\}\]/', $html, $titleMatches);
$titles = array_unique($titleMatches[1] ?? []);
echo "\nFound " . count($titles) . " titles:\n";
print_r(array_values($titles));

// Also let's extract paired video data if available
preg_match_all('/"videoRenderer":\{"videoId":"([^"]+)".*?"title":\{"runs":\[\{"text":"([^"]+)"\}\].*?"lengthText":\{"simpleText":"([^"]+)"\}/s', $html, $fullMatches, PREG_SET_ORDER);

echo "\nFull matched videos:\n";
foreach ($fullMatches as $m) {
    echo "ID: {$m[1]} | Title: {$m[2]} | Length: {$m[3]}\n";
}
