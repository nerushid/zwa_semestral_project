<?php
declare(strict_types=1);

function print_sort_dropdown(string $currentSort): void {
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