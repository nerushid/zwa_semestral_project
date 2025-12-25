<?php
declare(strict_types = 1);

function print_header(PDO $pdo) {
    if (isset($_SESSION["user_id"])) {
        // Check if user is admin
        $query = "SELECT role FROM users WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $isAdmin = $result && $result['role'] === 'admin';
        
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
    echo '<div class="single-listing-slider">';
        echo '<div class="slider-wrapper">';
        
        if (empty($images)) {
            echo '<img src="../mainpage/appartaments.jpg" class="slide-image" alt="Default Image">';
            $totalImages = 1;
        } else {
            $totalImages = count($images);
            foreach ($images as $img) {
                $imageName = $img['image_path']; 
                
                if (is_string($imageName)) {
                    $imgPath = "../uploads/" . 'medium_' . htmlspecialchars($imageName);
                    echo '<img src="' . $imgPath . '" class="slide-image" alt="Listing Image">';
                }
            }
        }
        echo '</div>';

        echo '<div class="slide-counter">1 / ' . $totalImages . '</div>';

        if (count($images) > 1) {
            echo '<button class="slider-btn prev-btn">&#10094;</button>';
            echo '<button class="slider-btn next-btn">&#10095;</button>';
        }
    echo '</div>';
}