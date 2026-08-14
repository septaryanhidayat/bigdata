<?php

namespace App\Services;

class ImageOptimizer
{
    /**
     * Compress, resize, and convert uploaded image to optimized WebP/JPEG format
     * to conserve server storage size.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string|null $filename
     * @param int $quality (1 - 100, default 75)
     * @param int $maxWidth (max width in pixels, default 1600)
     * @return string Relative URL path of saved image (e.g. /uploads/cms/img_xyz.webp)
     */
    public static function compress($file, $folder = 'uploads/cms', $filename = null, $quality = 75, $maxWidth = 1600)
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filePath = $file->getRealPath();

        // Create GD image resource based on extension
        $image = null;
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = @imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $image = @imagecreatefrompng($filePath);
                break;
            case 'webp':
                $image = @imagecreatefromwebp($filePath);
                break;
            case 'gif':
                $image = @imagecreatefromgif($filePath);
                break;
            default:
                if (function_exists('imagecreatefromstring')) {
                    $image = @imagecreatefromstring(file_get_contents($filePath));
                }
                break;
        }

        $destDir = public_path($folder);
        if (!file_exists($destDir)) {
            mkdir($destDir, 0755, true);
        }

        if (!$filename) {
            $filename = uniqid('img_') . '_' . time() . '.webp';
        } else {
            $baseName = pathinfo($filename, PATHINFO_FILENAME);
            $filename = $baseName . '_' . uniqid() . '.webp';
        }

        $fullPath = $destDir . '/' . $filename;

        if ($image) {
            // Check dimensions and resize if wider than $maxWidth
            $origWidth = imagesx($image);
            $origHeight = imagesy($image);

            if ($origWidth > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = (int) (($origHeight / $origWidth) * $newWidth);

                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                
                // Preserve transparency for PNG/WebP
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);

                imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                imagedestroy($image);
                $image = $resizedImage;
            }

            // Save as WebP if imagewebp function exists, else compressed JPEG
            if (function_exists('imagewebp')) {
                imagewebp($image, $fullPath, $quality);
            } else {
                $jpgFilename = str_replace('.webp', '.jpg', $filename);
                $fullPathJpg = $destDir . '/' . $jpgFilename;
                imagejpeg($image, $fullPathJpg, $quality);
                $filename = $jpgFilename;
            }

            imagedestroy($image);

            return '/' . trim($folder, '/') . '/' . $filename;
        }

        // Fallback: move original file if GD processing failed
        $file->move($destDir, $filename);
        return '/' . trim($folder, '/') . '/' . $filename;
    }
}
