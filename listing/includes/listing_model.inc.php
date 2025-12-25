<?php
declare(strict_types=1);

function get_listing_by_id(PDO $pdo, int $listingId): array|false {
    $sql = "SELECT * FROM listings WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_all_images_for_listing(PDO $pdo, int $listingId): array {
    $sql = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_listing_owner(PDO $pdo, int $userId): array|false {
    $sql = "SELECT firstname, surname, email FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
