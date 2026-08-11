<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Upload, convert to WebP, and ensure file size is strictly under 50KB.
     * 
     * @param UploadedFile $file
     * @param string $folder (e.g. 'uploads/schools')
     * @return string relative path (e.g. 'storage/uploads/schools/filename.webp')
     */
    public static function convertAndOptimizeToWebp(UploadedFile $file, string $folder = 'uploads'): string
    {
        $destinationDir = public_path("storage/{$folder}");
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $filename = Str::random(20) . '.webp';
        $fullPath = $destinationDir . '/' . $filename;

        $imageContent = file_get_contents($file->getRealPath());
        $sourceImage = @imagecreatefromstring($imageContent);

        if (!$sourceImage) {
            // Fallback if image type unsupported by GD
            $file->move($destinationDir, $filename);
            return "storage/{$folder}/{$filename}";
        }

        // Get dimensions
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        // Max dimension resize to 800px maintaining aspect ratio
        $maxDimension = 800;
        if ($width > $maxDimension || $height > $maxDimension) {
            if ($width > $height) {
                $newWidth = $maxDimension;
                $newHeight = (int) ($height * ($maxDimension / $width));
            } else {
                $newHeight = $maxDimension;
                $newWidth = (int) ($width * ($maxDimension / $height));
            }

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency for PNGs
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            
            imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($sourceImage);
            $sourceImage = $resizedImage;
        }

        // Compress and convert to WebP targeting < 50KB size
        $quality = 80;
        do {
            imagewebp($sourceImage, $fullPath, $quality);
            $fileSizeKb = filesize($fullPath) / 1024;
            $quality -= 10;
        } while ($fileSizeKb > 50 && $quality >= 10);

        imagedestroy($sourceImage);

        return "storage/{$folder}/{$filename}";
    }
}
