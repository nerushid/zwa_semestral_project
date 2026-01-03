<?php
/**
 * Delete Listing Model
 * 
 * Contains database functions for listing deletion operations.
 * Handles retrieval of listing images and database cleanup.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Retrieves all image paths for a listing
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId The listing ID
 * @return array Array of image path records
 */
function get_listing_images(object $pdo, int $listingId): array {
    $query = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Deletes all listing images from database
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId The listing ID
 * @return void
 */
function delete_listing_images(object $pdo, int $listingId): void {
    $query = "DELETE FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Deletes a listing from database
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId The listing ID
 * @return void
 */
function delete_listing(object $pdo, int $listingId): void {
    $query = "DELETE FROM listings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $listingId, PDO::PARAM_INT);
    $stmt->execute();
}
