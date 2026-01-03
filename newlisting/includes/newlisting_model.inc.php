<?php
/**
 * New Listing Model
 * 
 * Contains database functions for creating new listings
 * and associated image records.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

function create_new_listing(PDO $pdo, int $userId, string $praha, string $district, string $layout, int $area, int $price, string $description): int {
    $sql = "INSERT INTO listings (user_id, praha, district, layout, area, price, listing_description) 
            VALUES (:user_id, :praha, :district, :layout, :area, :price, :listing_description)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':praha', $praha, PDO::PARAM_STR);
    $stmt->bindParam(':district', $district, PDO::PARAM_STR);
    $stmt->bindParam(':layout', $layout, PDO::PARAM_STR);
    $stmt->bindParam(':area', $area, PDO::PARAM_INT);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':listing_description', $description, PDO::PARAM_STR);
    $stmt->execute();

    return (int)$pdo->lastInsertId();
}

function save_listing_images(PDO $pdo, int $listingId, array $imagePaths): void {
    $sql = "INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)";
    $stmt = $pdo->prepare($sql);

    foreach ($imagePaths as $path) {
        $stmt->bindParam(':listing_id', $listingId, PDO::PARAM_INT);
        $stmt->bindParam(':image_path', $path, PDO::PARAM_STR);
        $stmt->execute();
    }
}