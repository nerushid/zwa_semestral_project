<?php
/**
 * Main Page View Helper
 * 
 * Contains functions for rendering main page elements including
 * header navigation, listing cards, and pagination controls.
 * All output is properly escaped to prevent XSS attacks.
 * 
 * @package NestlyHomes\Views
 */

declare(strict_types=1);

/**
 * Prints header navigation based on user authentication status
 * 
 * Renders appropriate navigation links for logged-in users,
 * administrators, and anonymous visitors.
 * 
 * @param PDO $pdo Database connection for admin check
 * @return void
 */
function print_header(PDO $pdo): void {
    if (isset($_SESSION["user_id"])) {
        require_once __DIR__ . '/../../includes/user_model.inc.php';
        
        $isAdmin = is_user_admin($pdo, $_SESSION["user_id"]);
        
        echo '<a href="../newlisting/index.php" id="new-listing2">+ Add New Listing</a>';
        
        if ($isAdmin) {
            echo '<a href="../admin/index.php">Admin Panel</a>';
        }
        
        echo '<a href="../myprofile/index.php">My Profile</a>
              <a href="#" id="logout">Log Out</a>';
    } else {
        echo '<a href="../login/index.php">Login</a>
              <a href="../registration/index.php">Sign Up</a>';
    }
}

/**
 * Prints listing cards for apartment display
 * 
 * Renders article elements for each listing with image slider,
 * property details, and pricing information.
 * 
 * @param PDO $pdo Database connection for image retrieval
 * @param array $listings Array of listing data from database
 * @return void
 */
function print_listings(PDO $pdo, array $listings): void {
    if (empty($listings)) {
        echo '<p>No listings found.</p>';
        return;
    }

    foreach ($listings as $listing) {
        $praha = htmlspecialchars((string)($listing["praha"]));
        $district = htmlspecialchars((string)($listing["district"]));
        $layout = htmlspecialchars((string)($listing["layout"]));
        $area = htmlspecialchars((string)($listing["area"]));
        $price = htmlspecialchars(number_format((int)$listing["price"], 0, '.', ' '));
        $listingId = (int)$listing["id"];

        $images = get_all_images_for_listing($pdo, $listingId);
        
        echo '<article class="listing-item" data-listing-id="' . $listingId . '">
                <a href="../listing/index.php?id=' . $listingId . '">
                    <div class="image-slider-container">';
        
        if (!empty($images)) {
            echo '<div class="slider-images">';
            foreach ($images as $index => $image) {
                $activeClass = $index === 0 ? 'active' : '';
                echo '<img src="../uploads/' . 'thumb_' . htmlspecialchars($image['image_path']) . '" 
                          alt="apartment image" 
                          class="slider-image ' . $activeClass . '">';
            }
            echo '</div>';
            
            if (count($images) > 1) {
                echo '<button class="slider-btn prev-btn" data-listing="' . $listingId . '">‹</button>
                      <button class="slider-btn next-btn" data-listing="' . $listingId . '">›</button>
                      <div class="slider-dots">';
                for ($i = 0; $i < count($images); $i++) {
                    $activeClass = $i === 0 ? 'active' : '';
                    echo '<span class="dot ' . $activeClass . '" data-index="' . $i . '"></span>';
                }
                echo '</div>';
            }
        } else {
            echo '<img src="../uploads/placeholder.jpg" alt="no image" class="slider-image active">';
        }
        
        echo '      </div>
                    <p class="for-rent">Apartment for rent</p>
                    <p class="flat-size">Flat '. $layout .', '. $area .' m²</p>
                    <p class="flat-location"> Prague '. $praha .', '. $district .'</p>
                    <p class="flat-cost"><span id="strong">'. $price .'</span> CZK/month</p>
                </a> 
            </article>';
    }
}

/**
 * Prints pagination navigation controls
 * 
 * Renders page navigation with previous/next buttons and
 * numbered page links. Preserves current filter parameters.
 * 
 * @param int $currentPage Current page number (1-indexed)
 * @param int $totalPages Total number of available pages
 * @return void
 */
function print_pagination(int $currentPage, int $totalPages): void {
    if ($totalPages <= 1) return;

    echo '<div class="pagination">';
    $queryParams = $_GET;

    $generateUrl = function($page) use ($queryParams) {
        $queryParams['page'] = $page; 
        return '?' . http_build_query($queryParams); 
    };
    
    // Previous button
    if ($currentPage > 1) {
        echo '<a href="' . $generateUrl($currentPage - 1) . '">« Previous</a>';
    }
    
    $range = 2; // Number of pages to show on each side of the current page

    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
            
            if ($i == $currentPage) {
                echo '<span class="current-page">' . $i . '</span>';
            } else {
                echo '<a href="' . $generateUrl($i) . '">' . $i . '</a>';
            }
        } elseif ($i == $currentPage - $range - 1 || $i == $currentPage + $range + 1) {
            echo '<span class="dots">...</span>';
        }
    }

    // Next button
    if ($currentPage < $totalPages) {
        echo '<a href="' . $generateUrl($currentPage + 1) . '">Next »</a>';
    }
    
    echo '</div>';
}