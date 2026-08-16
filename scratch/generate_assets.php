<?php

$dir = __DIR__ . '/../sdm-robbani-mobile/assets';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

// 1. Icon (512x512)
$im = imagecreatetruecolor(512, 512);
$green = imagecolorallocate($im, 0, 69, 50); // #004532
imagefilledrectangle($im, 0, 0, 512, 512, $green);
imagepng($im, $dir . '/icon.png');
imagepng($im, $dir . '/adaptive-icon.png');
imagedestroy($im);

// 2. Favicon (48x48)
$im = imagecreatetruecolor(48, 48);
$green = imagecolorallocate($im, 0, 69, 50);
imagefilledrectangle($im, 0, 0, 48, 48, $green);
imagepng($im, $dir . '/favicon.png');
imagedestroy($im);

// 3. Splash (600x800)
$im = imagecreatetruecolor(600, 800);
$green = imagecolorallocate($im, 0, 69, 50);
imagefilledrectangle($im, 0, 0, 600, 800, $green);
imagepng($im, $dir . '/splash.png');
imagedestroy($im);

echo "Valid PNG assets generated with proper CRC checksums!\n";
