<?php
/**
 * Main Page Model
 * 
 * Contains database functions for listing retrieval with filtering,
 * sorting, and pagination support. Uses prepared statements
 * for all database queries.
 * 
 * @package NestlyHomes
 * @subpackage Models
 */

declare(strict_types=1);

/**
 * Builds SQL conditions and parameters from filter array
 * 
 * Converts filter parameters into SQL WHERE conditions
 * with corresponding prepared statement parameters.
 * 
 * @param array $filters Associative array of filter values
 * @return array Contains 'conditions' array and 'params' array
 */
function setConditionForQuerry(array $filters): array {
    $conditions = [];
    $params = [];

    if (!empty($filters['praha'])) {
        $conditions[] = 'praha = :praha';
        $params[':praha'] = $filters['praha'];
    }

    if (!empty($filters['district'])) {
        $conditions[] = 'district = :district';
        $params[':district'] = $filters['district'];
    }

    if (!empty($filters['price_from'])) {
        $conditions[] = 'price >= :price_from';
        $params[':price_from'] = $filters['price_from'];
    }

    if (!empty($filters['price_to'])) {
        $conditions[] = 'price <= :price_to';
        $params[':price_to'] = $filters['price_to'];
    }

    if (!empty($filters['area_from'])) {
        $conditions[] = 'area >= :area_from';
        $params[':area_from'] = $filters['area_from'];
    }

    if (!empty($filters['area_to'])) {
        $conditions[] = 'area <= :area_to';
        $params[':area_to'] = $filters['area_to'];
    }

    if (!empty($filters['layouts'])) {
        $layoutPlaceholders = [];
        foreach ($filters['layouts'] as $key => $layout) {
            $ph = ":layout_" . $key;
            $layoutPlaceholders[] = $ph;
            $params[$ph] = $layout;
        }
        $conditions[] = "l.layout IN (" . implode(', ', $layoutPlaceholders) . ")";
    }

    return ['conditions' => $conditions, 'params' => $params];
}

/**
 * Gets total count of listings matching filters
 * 
 * @param PDO $pdo Database connection instance
 * @param array $conditions SQL WHERE conditions
 * @param array $params Prepared statement parameters
 * @return int Total number of matching listings
 */
function get_number_of_listings(PDO $pdo, array $conditions = [], array $params = []): int {
    $sql = "SELECT COUNT(id) AS total FROM listings l";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $totalListings = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    return $totalListings;
}

/**
 * Retrieves paginated listings with optional filters and sorting
 * 
 * @param PDO $pdo Database connection instance
 * @param int $startFrom Offset for pagination
 * @param int $resultsPerPage Number of results to return
 * @param array $conditions SQL WHERE conditions
 * @param array $params Prepared statement parameters
 * @param string $sort Sort order ('newest', 'cheap', 'expensive')
 * @return array Array of listing records
 */
function get_listings_with_limit(PDO $pdo, int $startFrom, int $resultsPerPage, array $conditions, array $params, string $sort = 'newest'): array {
    $sql = "SELECT l.*, 
            (SELECT image_path FROM listing_images WHERE listing_id = l.id LIMIT 1) as main_image
            FROM listings l";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    switch ($sort) {
        case 'cheap':     
            $sql .= " ORDER BY l.price ASC"; break;
        case 'expensive': 
            $sql .= " ORDER BY l.price DESC"; break;
        case 'newest':    
        default:          
            $sql .= " ORDER BY l.created_at DESC"; break;
    }

    $sql .= " LIMIT :offset, :limit";
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':offset', $startFrom, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $listings;
}

/**
 * Retrieves all images for a specific listing
 * 
 * @param PDO $pdo Database connection instance
 * @param int $listingId The listing ID
 * @return array Array of image paths
 */
function get_all_images_for_listing(PDO $pdo, int $listingId): array {
    $sql = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $images;
}