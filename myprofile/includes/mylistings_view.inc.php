<?php
/**
 * My Listings View Helper
 * 
 * Contains functions for rendering user's listings page elements
 * including sort dropdown, listing cards, and pagination.
 * 
 * @package NestlyHomes
 * @subpackage Views
 */

declare(strict_types=1);

/**
 * Prints sort dropdown for listings
 * 
 * @param string $currentSort Current sort option value
 * @return void
 */
function print_sort_dropdown(string $currentSort): void {
    // Escape the sort value for safety
    $currentSort = htmlspecialchars($currentSort, ENT_QUOTES, 'UTF-8');
    
    echo '<div class="sort-container">
            <label for="sort-select">Sort by:</label>
            <select id="sort-select">
                <option value="newest"' . ($currentSort === 'newest' ? ' selected' : '') . '>Newest First</option>
                <option value="oldest"' . ($currentSort === 'oldest' ? ' selected' : '') . '>Oldest First</option>
                <option value="cheap"' . ($currentSort === 'cheap' ? ' selected' : '') . '>Price: Low to High</option>
                <option value="expensive"' . ($currentSort === 'expensive' ? ' selected' : '') . '>Price: High to Low</option>
            </select>
          </div>';
}

/**
 * Prints user's listing cards
 * 
 * Renders listing cards with property details and action buttons.
 * Shows "no listings" message with create button if empty.
 * 
 * @param array $listings Array of user's listings
 * @return void
 */
function print_listings(array $listings): void {
    if (empty($listings)) {
        echo '<div class="no-listings">
                <p>You don\'t have any listings yet.</p>
                <a href="../newlisting/index.php" class="add-listing-btn">Create Your First Listing</a>
              </div>';
        return;
    }
    
    echo '<div class="listings-container">';
    foreach ($listings as $listing) {
        $listingId = htmlspecialchars((string)$listing['id']);
        $price = htmlspecialchars(number_format((int)$listing['price'], 0, '.', ' '));
        $location = 'Prague ' . htmlspecialchars($listing['praha']) . ', ' . htmlspecialchars($listing['district']);
        $layout = htmlspecialchars($listing['layout']);
        $area = htmlspecialchars((string)$listing['area']);
        $createdAt = htmlspecialchars(date('F j, Y', strtotime($listing['created_at'])));
        
        echo '<div class="listing-card">
                <div class="listing-header">
                    <h3>Apartment for Rent</h3>
                    <span class="listing-date">'.$createdAt.'</span>
                </div>
                <div class="listing-details">
                    <p class="price">'.$price.' CZK/month</p>
                    <p class="location">'.$location.'</p>
                    <div class="listing-features">
                        <span> '.$layout.'</span>
                        <span> '.$area.' m²</span>
                    </div>
                </div>
                <div class="listing-actions">
                    <a href="../listing/index.php?id='.$listingId.'" class="view-btn">View</a>
                    <a href="../editlisting/index.php?id='.$listingId.'" class="edit-btn">Edit</a>
                    <a href="../deletelisting/index.php?id='.$listingId.'" class="delete-btn">Delete</a>
                </div>
              </div>';
    }
    echo '</div>';
}

/**
 * Prints pagination for user listings
 * 
 * @param int $currentPage Current page number
 * @param int $totalPages Total number of pages
 * @param string $sort Current sort option
 * @return void
 */
function print_pagination(int $currentPage, int $totalPages, string $sort): void {
    if ($totalPages <= 1) return;

    echo '<div class="pagination">';
    
    $generateUrl = function($page) use ($sort) {
        return '?page=' . $page . '&sort=' . htmlspecialchars($sort);
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