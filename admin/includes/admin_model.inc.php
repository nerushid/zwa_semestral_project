<?php
/**
 * Admin Model
 * 
 * Contains database functions for administrative operations.
 * Handles user management, listing management, and cascade deletions.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Checks if user has administrator privileges
 * 
 * Wrapper function for centralized admin check.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to check
 * @return bool True if user is admin, false otherwise
 */
function is_admin(object $pdo, int $userId): bool {
    require_once __DIR__ . '/../../includes/user_model.inc.php';
    return is_user_admin($pdo, $userId);
}

/**
 * Gets total count of users excluding current admin
 * 
 * @param object $pdo PDO database connection instance
 * @return int Total number of users
 */
function get_total_users_count(object $pdo): int {
    $query = "SELECT COUNT(*) as total FROM users WHERE id != :currentUserId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':currentUserId', $_SESSION["user_id"], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['total'];
}

/**
 * Retrieves paginated users with sorting
 * 
 * @param object $pdo PDO database connection instance
 * @param int $offset Pagination offset
 * @param int $limit Number of results per page
 * @param string $sort Sort order ('newest' or 'oldest')
 * @return array Array of user records
 */
function get_users_with_limit(object $pdo, int $offset, int $limit, string $sort = 'newest'): array {
    $orderBy = $sort === 'oldest' ? 'ASC' : 'DESC';
    $query = "SELECT id, firstname, surname, email, role, created_at FROM users WHERE id != :currentUserId ORDER BY created_at $orderBy LIMIT :offset, :limit";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':currentUserId', $_SESSION["user_id"], PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Retrieves a single user by ID
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to retrieve
 * @return array|false User data or false if not found
 */
function get_user_by_id(object $pdo, int $userId): array|false {
    $query = "SELECT id, firstname, surname, email, role, created_at FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Deletes a user and all associated data
 * 
 * Removes user, their listings, and all listing images from
 * filesystem and database. Implements cascade deletion.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to delete
 * @return void
 */
function delete_user_admin(object $pdo, int $userId): void {
    // Get all listings for this user
    $query = "SELECT id FROM listings WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Delete images for each listing
    foreach ($listings as $listing) {
        delete_listing_images_files($pdo, (int)$listing['id']);
    }
    
    // Delete user's listings (CASCADE will handle listing_images records)
    $query = "DELETE FROM listings WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Delete user
    $query = "DELETE FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Promotes a user to administrator
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to promote
 * @return void
 */
function make_admin(object $pdo, int $userId): void {
    $query = "UPDATE users SET role = 'admin' WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Demotes an administrator to regular user
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to demote
 * @return void
 */
function remove_admin(object $pdo, int $userId): void {
    $query = "UPDATE users SET role = 'user' WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Gets total count of all listings
 * 
 * @param object $pdo PDO database connection instance
 * @return int Total number of listings
 */
function get_total_listings_count(object $pdo): int {
    $query = "SELECT COUNT(*) as total FROM listings";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['total'];
}

/**
 * Retrieves paginated listings with owner information
 * 
 * Joins listing and user data for admin overview.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $offset Pagination offset
 * @param int $limit Number of results per page
 * @param string $sort Sort order ('newest' or 'oldest')
 * @return array Array of listing records with owner data
 */
function get_listings_with_limit_admin(object $pdo, int $offset, int $limit, string $sort = 'newest'): array {
    $orderBy = $sort === 'oldest' ? 'ASC' : 'DESC';
    $query = "SELECT l.*, u.firstname, u.surname, u.email 
              FROM listings l 
              JOIN users u ON l.user_id = u.id 
              ORDER BY l.created_at $orderBy 
              LIMIT :offset, :limit";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Retrieves a single listing by ID with owner information
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId Listing ID to retrieve
 * @return array|false Listing data with owner info or false if not found
 */
function get_listing_by_id_admin(object $pdo, int $listingId): array|false {
    $query = "SELECT l.*, u.firstname, u.surname, u.email 
              FROM listings l 
              JOIN users u ON l.user_id = u.id 
              WHERE l.id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Gets total count of listings for a specific user
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID
 * @return int Total number of user's listings
 */
function get_user_listings_count(object $pdo, int $userId): int {
    $query = "SELECT COUNT(*) as total FROM listings WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['total'];
}

/**
 * Retrieves paginated listings for a specific user
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID
 * @param int $offset Pagination offset
 * @param int $limit Number of results per page
 * @return array Array of listing records
 */
function get_user_listings_admin(object $pdo, int $userId, int $offset, int $limit): array {
    $query = "SELECT l.* FROM listings l WHERE l.user_id = :userId ORDER BY l.created_at DESC LIMIT :offset, :limit";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Deletes a listing and all associated images
 * 
 * Removes listing images from filesystem and deletes
 * listing record from database.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId Listing ID to delete
 * @return void
 */
function delete_listing_admin(object $pdo, int $listingId): void {
    // Delete physical image files first
    delete_listing_images_files($pdo, $listingId);
    
    // Delete listing images from database
    $query = "DELETE FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Delete listing
    $query = "DELETE FROM listings WHERE id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Deletes physical image files for a listing
 * 
 * Removes thumbnail and medium-sized images from filesystem.
 * Helper function called before database deletion.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $listingId Listing ID
 * @return void
 */
function delete_listing_images_files(object $pdo, int $listingId): void {
    // Get all images for this listing
    $query = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Delete physical files
    foreach ($images as $image) {
        $imagePath = $image['image_path'];
        
        // Delete thumbnail (420px)
        $thumbPath = __DIR__ . '/../../uploads/thumb_' . $imagePath;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
        
        // Delete medium (1080px)
        $mediumPath = __DIR__ . '/../../uploads/medium_' . $imagePath;
        if (file_exists($mediumPath)) {
            unlink($mediumPath);
        }
    }
}
