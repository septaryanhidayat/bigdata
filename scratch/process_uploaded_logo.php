<?php

$src = 'C:/Users/RYAN/.gemini/antigravity-ide/brain/e46779af-e3b5-42fc-8de1-944c8d160931/.user_uploaded/media_1786885673197.jpg';
$destDir = __DIR__ . '/../sdm-robbani-mobile/assets';

if (!file_exists($src)) {
    die("Source file not found: $src\n");
}

$orig = imagecreatefromjpeg($src);
$width = imagesx($orig);
$height = imagesy($orig);

echo "Loaded original image: {$width}x{$height}\n";

// Function to resize and save
function saveResized($orig, $width, $height, $targetW, $targetH, $destPath) {
    $img = imagecreatetruecolor($targetW, $targetH);
    // Background putih bersih
    $white = imagecolorallocate($img, 255, 255, 255);
    imagefilledrectangle($img, 0, 0, $targetW, $targetH, $white);
    
    // Resize resampled
    imagecopyresampled($img, $orig, 0, 0, 0, 0, $targetW, $targetH, $width, $height);
    imagepng($img, $destPath);
    imagedestroy($img);
    echo "Saved: $destPath ({$targetW}x{$targetH})\n";
}

// 1. icon.png (1024x1024)
saveResized($orig, $width, $height, 1024, 1024, "$destDir/icon.png");

// 2. adaptive-icon.png (1024x1024)
saveResized($orig, $width, $height, 1024, 1024, "$destDir/adaptive-icon.png");

// 3. favicon.png (192x192)
saveResized($orig, $width, $height, 192, 192, "$destDir/favicon.png");

// 4. splash.png (1242x2436 dengan logo di tengah dan background putih bersih)
$splash = imagecreatetruecolor(1242, 2436);
$bgWhite = imagecolorallocate($splash, 255, 255, 255);
imagefilledrectangle($splash, 0, 0, 1242, 2436, $bgWhite);

// Ukuran logo di splash: 800x800 di tengah
$logoW = 800;
$logoH = 800;
$posX = (1242 - $logoW) / 2;
$posY = (2436 - $logoH) / 2 - 100;
imagecopyresampled($splash, $orig, $posX, $posY, 0, 0, $logoW, $logoH, $width, $height);
imagepng($splash, "$destDir/splash.png");
imagedestroy($splash);
echo "Saved: $destDir/splash.png (1242x2436)\n";

// 5. logo.png (512x512) untuk dipakai langsung di dalam komponen UI LoginScreen & Header
saveResized($orig, $width, $height, 512, 512, "$destDir/logo.png");

imagedestroy($orig);
echo "All app logos and splash screens generated successfully!\n";
