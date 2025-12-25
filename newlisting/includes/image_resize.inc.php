<?php

// function resize_image($sourcePath, $destPath, $targetWidth, $targetHeight) {
//     list($originalWidth, $originalHeight, $imageType) = getimagesize($sourcePath);
//     switch ($imageType) {
//         case IMAGETYPE_JPEG:
//             $sourceImage = imagecreatefromjpeg($sourcePath);
//             break;
//         case IMAGETYPE_PNG:
//             $sourceImage = imagecreatefrompng($sourcePath);
//             imagesavealpha($sourceImage, true);
//             break;
//         case IMAGETYPE_WEBP:
//             $sourceImage = imagecreatefromwebp($sourcePath);
//             break;
//         default:
//             throw new Exception("Unsupported image type; only JPEG, PNG and WEBP are allowed.");
//     }

//     $ratio = $originalWidth / $originalHeight;

//     if ($targetWidth / $targetHeight > $ratio) {
//         $newWidth = (int)($targetHeight * $ratio);
//         $newHeight = $targetHeight;
//     } else {
//         $newWidth = $targetWidth;
//         $newHeight = (int)($targetWidth / $ratio);
//     }

//     $destImage = imagecreatetruecolor($newWidth, $newHeight);

//     if ($imageType == IMAGETYPE_PNG) {
//         imagealphablending($destImage, false);
//         imagesavealpha($destImage, true);
//     }

//     imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

//     switch ($imageType) {
//         case IMAGETYPE_JPEG:
//             imagejpeg($destImage, $destPath);
//             break;
//         case IMAGETYPE_PNG:
//             imagepng($destImage, $destPath);
//             break;
//         case IMAGETYPE_WEBP:
//             imagewebp($destImage, $destPath);
//             break;
//     }

//     imagedestroy($sourceImage);
//     imagedestroy($destImage);
// }
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

    $ratio = $originalWidth / $originalHeight;
    $newHeight = $targetHeight;
    $newWidth = (int)($targetHeight * $ratio);

    $destImage = imagecreatetruecolor($newWidth, $newHeight);

    if ($imageType == IMAGETYPE_PNG) {
        imagealphablending($destImage, false);
        imagesavealpha($destImage, true);
    }

    imagecopyresampled(
        $destImage, $sourceImage, 
        0, 0, 
        0, 0, 
        $newWidth, $newHeight, 
        $originalWidth, $originalHeight
    );

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