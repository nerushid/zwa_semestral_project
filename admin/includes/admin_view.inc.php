<?php
declare(strict_types=1);

function print_users_table(array $users): void {
    if (empty($users) || !$users[0]) {
        echo '<p class="no-results">No users found.</p>';
        return;
    }

    echo '<div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
    foreach ($users as $user) {
        $id = htmlspecialchars((string)$user['id']);
        $name = htmlspecialchars($user['firstname'] . ' ' . $user['surname']);
        $email = htmlspecialchars($user['email']);
        $isAdmin = $user['role'] === 'admin';
        $role = $isAdmin ? '<span class="badge admin">Admin</span>' : '<span class="badge user">User</span>';
        $date = htmlspecialchars(date('M j, Y', strtotime($user['created_at'])));
        
        echo '<tr>
                <td>' . $id . '</td>
                <td>' . $name . '</td>
                <td>' . $email . '</td>
                <td>' . $role . '</td>
                <td>' . $date . '</td>
                <td class="actions">
                    <a href="?tab=user_listings&user_id=' . $id . '" class="btn-view">View Listings</a>';
        
        if (!$isAdmin) {
            echo '<button class="btn-promote" data-action="make_admin" data-id="' . $id . '" data-name="' . $name . '">Make Admin</button>';
        } else {
            echo '<button class="btn-demote" data-action="remove_admin" data-id="' . $id . '" data-name="' . $name . '">Remove Admin</button>';
        }
        
        if ($id !== (string)$_SESSION["user_id"]) {
            echo '<button class="btn-delete" data-action="delete_user" data-id="' . $id . '" data-name="' . $name . '">Delete</button>';
        }
        
        echo '</td>
            </tr>';
    }
    
    echo '</tbody>
        </table>
      </div>';
}

function print_listings_table(array $listings): void {
    if (empty($listings) || !$listings[0]) {
        echo '<p class="no-results">No listings found.</p>';
        return;
    }

    echo '<div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Layout</th>
                        <th>Price</th>
                        <th>Owner (ID)</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
    foreach ($listings as $listing) {
        $id = htmlspecialchars((string)$listing['id']);
        $location = 'Prague ' . htmlspecialchars($listing['praha']) . ', ' . htmlspecialchars($listing['district']);
        $layout = htmlspecialchars($listing['layout']);
        $price = htmlspecialchars(number_format((int)$listing['price'], 0, '.', ' ')) . ' CZK/month';
        $ownerId = isset($listing['user_id']) ? htmlspecialchars((string)$listing['user_id']) : 'N/A';
        $owner = isset($listing['firstname']) ? htmlspecialchars($listing['firstname'] . ' ' . $listing['surname']) . ' (' . $ownerId . ')' : 'N/A';
        $date = htmlspecialchars(date('M j, Y', strtotime($listing['created_at'])));
        
        echo '<tr>
                <td>' . $id . '</td>
                <td>' . $location . '</td>
                <td>' . $layout . '</td>
                <td>' . $price . '</td>
                <td>' . $owner . '</td>
                <td>' . $date . '</td>
                <td class="actions">
                    <a href="../listing/index.php?id=' . $id . '" class="btn-view" target="_blank">View</a>
                    <button class="btn-delete" data-action="delete_listing" data-id="' . $id . '" data-name="' . $location . '">Delete</button>
                </td>
            </tr>';
    }
    
    echo '</tbody>
        </table>
      </div>';
}

function print_pagination(int $currentPage, int $totalPages, string $tab, string $sort = '', int $userId = 0): void {
    if ($totalPages <= 1) return;

    echo '<div class="pagination">';
    
    $buildUrl = function($page) use ($tab, $sort, $userId) {
        $params = ['tab' => $tab, 'page' => $page];
        if ($sort) $params['sort'] = $sort;
        if ($userId > 0) $params['user_id'] = $userId;
        return '?' . http_build_query($params);
    };
    
    // Previous button
    if ($currentPage > 1) {
        echo '<a href="' . $buildUrl($currentPage - 1) . '">« Previous</a>';
    }
    
    $range = 2; // Number of pages to show on each side of the current page

    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
            
            if ($i == $currentPage) {
                echo '<span class="current-page">' . $i . '</span>';
            } else {
                echo '<a href="' . $buildUrl($i) . '">' . $i . '</a>';
            }
        } elseif ($i == $currentPage - $range - 1 || $i == $currentPage + $range + 1) {
            echo '<span class="dots">...</span>';
        }
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        echo '<a href="' . $buildUrl($currentPage + 1) . '">Next »</a>';
    }
    
    echo '</div>';
}
