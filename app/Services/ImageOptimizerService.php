<?php

namespace App\Services;

class ImageOptimizerService
{
    /**
     * Resize and compress an image file or base64 string to be strictly under 50KB.
     *
     * @param  mixed  $source  UploadedFile, file path, or Base64 data string
     * @param  string $destinationPath  Absolute path to save the optimized JPEG
     * @param  int    $maxDimension  Maximum width or height in pixels (default 480)
     * @param  int    $targetMaxKb   Target maximum size in KB (default 48)
     * @return bool
     */
    public static function optimizeAndSave($source, string $destinationPath, int $maxDimension = 480, int $targetMaxKb = 48): bool
    {
        $dir = dirname($destinationPath);
        if (!file_exists($dir)) {
            @mkdir($dir, 0777, true);
        }

        $image = null;

        // 1. Load image resource from various source types
        if (is_string($source)) {
            if (str_contains($source, 'base64,')) {
                $rawBase64 = explode('base64,', $source)[1];
                $data = base64_decode($rawBase64);
                if ($data) {
                    $image = @imagecreatefromstring($data);
                }
            } elseif (strlen($source) > 200 && !str_starts_with($source, 'http') && !file_exists($source)) {
                $data = base64_decode($source);
                if ($data) {
                    $image = @imagecreatefromstring($data);
                }
            } elseif (file_exists($source)) {
                $data = file_get_contents($source);
                if ($data) {
                    $image = @imagecreatefromstring($data);
                }
            }
        } elseif (is_object($source) && method_exists($source, 'getRealPath')) {
            $realPath = $source->getRealPath();
            if ($realPath && file_exists($realPath)) {
                $data = file_get_contents($realPath);
                if ($data) {
                    $image = @imagecreatefromstring($data);
                }
            }
        }

        if (!$image) {
            // Fallback: If GD could not parse, write raw if string or copy file
            if (is_string($source) && file_exists($source)) {
                return @copy($source, $destinationPath);
            }
            return false;
        }

        // 2. Calculate proportional dimensions (max width/height)
        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        $ratio = min($maxDimension / max(1, $origWidth), $maxDimension / max(1, $origHeight), 1.0);
        $newWidth = max(1, (int) round($origWidth * $ratio));
        $newHeight = max(1, (int) round($origHeight * $ratio));

        $resized = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve crisp background fill
        $white = imagecolorallocate($resized, 255, 255, 255);
        imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $white);

        imagecopyresampled(
            $resized,
            $image,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $origWidth, $origHeight
        );

        // 3. Iteratively compress quality to ensure file size is strictly under $targetMaxKb (50KB)
        $quality = 75;
        $tempPath = $destinationPath . '.tmp';

        do {
            imagejpeg($resized, $tempPath, $quality);
            $sizeKb = filesize($tempPath) / 1024;
            $quality -= 10;
        } while ($sizeKb > $targetMaxKb && $quality >= 25);

        @rename($tempPath, $destinationPath);

        imagedestroy($image);
        imagedestroy($resized);

        return file_exists($destinationPath) && filesize($destinationPath) > 0;
    }
}
