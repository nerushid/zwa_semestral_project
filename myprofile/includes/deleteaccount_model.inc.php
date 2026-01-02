<?php
declare(strict_types=1);

function delete_user(object $pdo, int $userId) {
    // Get all listings for this user
    $query = "SELECT id FROM listings WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Delete images for each listing
    foreach ($listings as $listing) {
        $listingId = (int)$listing['id'];
        
        // Get all images for this listing
        $imgQuery = "SELECT image_path FROM listing_images WHERE listing_id = :listingId";
        $imgStmt = $pdo->prepare($imgQuery);
        $imgStmt->bindParam(':listingId', $listingId, PDO::PARAM_INT);
        $imgStmt->execute();
        $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
        
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
    
    // Delete user (CASCADE will delete listings and listing_images records)
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
}