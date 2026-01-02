<?php
declare(strict_types = 1);

function print_header(PDO $pdo) {
    if (isset($_SESSION["user_id"])) {
        require_once __DIR__ . '/../../includes/user_model.inc.php';
        $isAdmin = is_user_admin($pdo, $_SESSION["user_id"]);
        
        echo '
            <a href="../newlisting/index.php" id="new-listing2">+ Add New Listing</a>';
        
        if ($isAdmin) {
            echo '<a href="../admin/index.php">Admin Panel</a>';
        }
        
        echo '
            <a href="../myprofile/index.php">My Profile</a>
            <a href="#" id="logout">Log Out</a>';
    } else {
        echo '
            <a href="../login/index.php">Login</a>
            <a href="../registration/index.php">Sign Up</a>';
    }
}

function print_slider(array $images): void {
    $totalImages = empty($images) ? 1 : count($images);
    
    echo '<div class="single-listing-slider">
            <div class="slider-wrapper">';
        
    if (empty($images)) {
        echo '<img src="../uploads/placeholder.jpg" class="slide-image" alt="Default Image">';
    } else {
        foreach ($images as $img) {
            if (is_string($img['image_path'])) {
                echo '<img src="../uploads/medium_' . htmlspecialchars($img['image_path']) . '" class="slide-image" alt="Listing Image">';
            }
        }
    }
    
    echo '  </div>
            <div class="slide-counter">1 / ' . $totalImages . '</div>';

    if ($totalImages > 1) {
        echo '<button class="slider-btn prev-btn">&#10094;</button>
              <button class="slider-btn next-btn">&#10095;</button>';
    }
    
    echo '</div>';
}