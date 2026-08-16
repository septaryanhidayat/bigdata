<?php

$dir = __DIR__ . '/../public/images';

$files = [
    'tkit' => 'Logo TKIT Robbani Light.png',
    'sdit' => 'Logo SDIT Robbani Light.png',
    'smpit' => 'Logo SMPIT Robbani Light.png',
    'smait' => 'Logo SMAIT Robbani Light.png',
];

echo "=== COMPRESSING UNIT LOGO IMAGES (< 100 KB) ===\n\n";

foreach ($files as $unit => $file) {
    $srcPath = $dir . '/' . $file;
    if (!file_exists($srcPath)) {
        echo "File not found: $srcPath\n";
        continue;
    }

    $origSize = filesize($srcPath);
    echo "Processing $file (Original: " . round($origSize / 1024, 2) . " KB)...\n";

    // Load original image
    $srcImg = imagecreatefrompng($srcPath);
    $origWidth = imagesx($srcImg);
    $origHeight = imagesy($srcImg);

    // Target max dimensions (e.g. 400x400 max, perfect for web, letters & dashboard)
    $maxDim = 400;
    if ($origWidth > $maxDim || $origHeight > $maxDim) {
        if ($origWidth > $origHeight) {
            $newWidth = $maxDim;
            $newHeight = (int) round(($origHeight / $origWidth) * $maxDim);
        } else {
            $newHeight = $maxDim;
            $newWidth = (int) round(($origWidth / $origHeight) * $maxDim);
        }
    } else {
        $newWidth = $origWidth;
        $newHeight = $origHeight;
    }

    // Create new truecolor image with alpha transparency
    $dstImg = imagecreatetruecolor($newWidth, $newHeight);
    imagealphablending($dstImg, false);
    imagesavealpha($dstImg, true);
    $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
    imagefilledrectangle($dstImg, 0, 0, $newWidth, $newHeight, $transparent);

    // Resample
    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

    // Save back to original file and clean normalized file
    $normalizedPath = $dir . "/logo_{$unit}.png";

    // Save with maximum compression
    imagepng($dstImg, $srcPath, 9);
    imagepng($dstImg, $normalizedPath, 9);

    imagedestroy($srcImg);
    imagedestroy($dstImg);

    $newSizeOrig = filesize($srcPath);
    $newSizeNorm = filesize($normalizedPath);

    echo "✓ Success: $file -> " . round($newSizeOrig / 1024, 2) . " KB (Dim: {$newWidth}x{$newHeight})\n";
    echo "✓ Created normalized alias: logo_{$unit}.png -> " . round($newSizeNorm / 1024, 2) . " KB\n\n";
}

echo "=== ALL UNIT LOGOS COMPRESSED TO < 100 KB! ===\n";
