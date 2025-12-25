<?php
declare(strict_types=1);

function get_user_listings(object $pdo, int $userId) {
    $query = "SELECT id, price, layout, area, praha, district, created_at 
              FROM listings 
              WHERE user_id = :userId 
              ORDER BY created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_total_user_listings_count(object $pdo, int $userId): int {
    $query = "SELECT COUNT(id) AS total FROM listings WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['total'];
}

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
