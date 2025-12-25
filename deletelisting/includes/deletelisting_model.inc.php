<?php
declare(strict_types=1);

function get_listing_images(object $pdo, int $listingId): array {
    $query = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function delete_listing_images(object $pdo, int $listingId): void {
    $query = "DELETE FROM listing_images WHERE listing_id = :listingId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_listing(object $pdo, int $listingId): void {
    $query = "DELETE FROM listings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $listingId, PDO::PARAM_INT);
    $stmt->execute();
}
