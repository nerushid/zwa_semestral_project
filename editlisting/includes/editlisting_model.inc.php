<?php
/**
 * Edit Listing Model
 * 
 * Contains database functions for listing retrieval and updates.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Retrieves a listing by ID
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId Listing ID to retrieve
 * @return array|false Listing data or false if not found
 */
function get_listing_by_id(object $pdo, int $listingId): array|false {
    $query = "SELECT * FROM listings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Updates listing information in database
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId Listing ID to update
 * @param int $praha Prague district number
 * @param string $district Specific district name
 * @param string $layout Apartment layout
 * @param int $area Area in square meters
 * @param int $price Monthly rent in CZK
 * @param string $description Listing description
 * @return void
 */
function update_listing(object $pdo, int $listingId, int $praha, string $district, string $layout, int $area, int $price, string $description): void {
    $query = "UPDATE listings 
              SET praha = :praha, district = :district, layout = :layout, 
                  area = :area, price = :price, listing_description = :listing_description 
              WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':praha', $praha, PDO::PARAM_INT);
    $stmt->bindParam(':district', $district);
    $stmt->bindParam(':layout', $layout);
    $stmt->bindParam(':area', $area, PDO::PARAM_INT);
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':listing_description', $description);
    $stmt->bindParam(':id', $listingId, PDO::PARAM_INT);
    $stmt->execute();
}
