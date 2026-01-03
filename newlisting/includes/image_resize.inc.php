<?php
/**
 * Image Resize Module
 * 
 * Contains functions for resizing uploaded images to
 * thumbnail (420px) and medium (1080px) sizes.
 * Supports JPEG, PNG, GIF, and WebP formats.
 * 
 * @package NestlyHomes
 * @subpackage Utilities
 */

declare(strict_types=1);

/**
 * Resize image to specified height while maintaining aspect ratio
 * @param string $sourcePath Path to source image
 * @param string $destPath Path to save resized image
 * @param int $targetHeight Target height in pixels
 * @return bool Success status
 */
function resize_image($sourcePath, $destPath, $targetHeight) {
    list($originalWidth, $originalHeight, $imageType) = getimagesize($sourcePath);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            imagealphablending($sourceImage, true);
            break;
        case IMAGETYPE_WEBP:
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false; 
    }

    // Calculate new dimensions maintaining aspect ratio
    $ratio = $originalWidth / $originalHeight;
    $newHeight = $targetHeight;
    $newWidth = (int)($targetHeight * $ratio);

    $destImage = imagecreatetruecolor($newWidth, $newHeight);

    // Handle PNG transparency
    if ($imageType == IMAGETYPE_PNG) {
        imagealphablending($destImage, false);
        imagesavealpha($destImage, true);
    }

    // Resample image
    imagecopyresampled(
        $destImage, $sourceImage, 
        0, 0, 
        0, 0, 
        $newWidth, $newHeight, 
        $originalWidth, $originalHeight
    );

    // Save resized image
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($destImage, $destPath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($destImage, $destPath);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($destImage, $destPath, 90);
            break;
    }

    imagedestroy($sourceImage);
    imagedestroy($destImage);

    return true;
}