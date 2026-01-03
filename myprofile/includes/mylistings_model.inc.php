<?php
/**
 * My Listings Model
 * 
 * Contains database functions for retrieving user's listings
 * with pagination and sorting support.
 * 
 * @package NestlyHomes
 * @subpackage Models
 */

declare(strict_types=1);

/**
 * Retrieves all listings for a user
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID
 * @return array Array of listing records
 */
function get_user_listings(object $pdo, int $userId): array {
    $query = "SELECT id, price, layout, area, praha, district, created_at 
              FROM listings 
              WHERE user_id = :userId 
              ORDER BY created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Gets total count of user's listings
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID
 * @return int Total number of listings
 */
function get_total_user_listings_count(object $pdo, int $userId): int {
    $query = "SELECT COUNT(id) AS total FROM listings WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['total'];
}

/**
 * Retrieves paginated listings for a user with sorting
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID
 * @param int $startFrom Pagination offset
 * @param int $resultsPerPage Number of results per page
 * @param string $sort Sort order option
 * @return array Array of listing records
 */
function get_user_listings_with_limit(object $pdo, int $userId, int $startFrom, int $resultsPerPage, string $sort = 'newest'): array {
    $query = "SELECT id, price, layout, area, praha, district, created_at 
              FROM listings 
              WHERE user_id = :userId";
    
    switch ($sort) {
        case 'oldest':
            $query .= " ORDER BY created_at ASC";
            break;
        case 'cheap':
            $query .= " ORDER BY price ASC";
            break;
        case 'expensive':
            $query .= " ORDER BY price DESC";
            break;
        case 'newest':
        default:
            $query .= " ORDER BY created_at DESC";
            break;
    }
    
    $query .= " LIMIT :offset, :limit";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $startFrom, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
