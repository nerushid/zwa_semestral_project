<?php
/**
 * Delete Listing Handler
 * 
 * Processes listing deletion requests.
 * Verifies ownership, deletes listing images from filesystem,
 * and removes database records.
 * 
 * @package NestlyHomes
 * @subpackage Handlers
 */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $listingId = isset($_POST["listing_id"]) ? (int)$_POST["listing_id"] : 0;

    try {
        require_once '../../includes/config_session.php';
        require_once '../../includes/dbh.inc.php';
        require_once 'deletelisting_model.inc.php';
        require_once '../../editlisting/includes/editlisting_model.inc.php';

        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        // Verify ownership
        $listing = get_listing_by_id($pdo, $listingId);
        if (!$listing || $listing['user_id'] !== $_SESSION["user_id"]) {
            header("Location: ../../myprofile/mylistings.php");
            die();
        }

        // Delete listing images from filesystem
        $images = get_listing_images($pdo, $listingId);
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

        // Delete from database (CASCADE will handle listing_images)
        delete_listing_images($pdo, $listingId);
        delete_listing($pdo, $listingId);

        header("Location: ../../myprofile/mylistings.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../myprofile/mylistings.php");
    die();
}