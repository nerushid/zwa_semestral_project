<?php
/**
 * Listing Model
 * 
 * Contains database functions for single listing retrieval
 * including listing data, images, and owner information.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Retrieves a listing by its ID
 * 
 * @param PDO $pdo Database connection instance
 * @param int $listingId The listing ID to retrieve
 * @return array|false Listing data array or false if not found
 */
function get_listing_by_id(PDO $pdo, int $listingId): array|false {
    $sql = "SELECT * FROM listings WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Retrieves all images for a listing
 * 
 * @param PDO $pdo Database connection instance
 * @param int $listingId The listing ID
 * @return array Array of image path records
 */
function get_all_images_for_listing(PDO $pdo, int $listingId): array {
    $sql = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Retrieves listing owner's contact information
 * 
 * @param PDO $pdo Database connection instance
 * @param int $userId The owner's user ID
 * @return array|false Owner data array or false if not found
 */
function get_listing_owner(PDO $pdo, int $userId): array|false {
    $sql = "SELECT firstname, surname, email FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
