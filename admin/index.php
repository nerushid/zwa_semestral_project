<?php
/**
 * Admin Control Panel
 * 
 * Administrative interface for managing users and listings.
 * Provides tabbed interface with search, sort, and pagination.
 * Requires administrator privileges.
 * 
 * @package NestlyHomes
 * @subpackage Administration
 */

require_once '../includes/config_session.php';
require_once '../includes/dbh.inc.php';
require_once 'includes/admin_model.inc.php';
require_once 'includes/admin_view.inc.php';

if (!isset($_SESSION["user_id"]) || !is_admin($pdo, $_SESSION["user_id"])) {
    header("Location: ../mainpage/index.php");
    die();
}

$activeTab = $_GET['tab'] ?? 'users';
$searchId = isset($_GET['search_id']) ? (int)$_GET['search_id'] : 0;
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$sort = $_GET['sort'] ?? 'newest';

$resultsPerPage = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$startFrom = ($page - 1) * $resultsPerPage;

if ($activeTab === 'users') {
    if ($searchId > 0) {
        $users = [get_user_by_id($pdo, $searchId)];
        $totalUsers = $users[0] ? 1 : 0;
    } else {
        $totalUsers = get_total_users_count($pdo);
        $users = get_users_with_limit($pdo, $startFrom, $resultsPerPage, $sort);
    }
    $totalPages = ceil($totalUsers / $resultsPerPage);
} elseif ($activeTab === 'listings') {
    if ($searchId > 0) {
        $listings = [get_listing_by_id_admin($pdo, $searchId)];
        $totalListings = $listings[0] ? 1 : 0;
    } else {
        $totalListings = get_total_listings_count($pdo);
        $listings = get_listings_with_limit_admin($pdo, $startFrom, $resultsPerPage, $sort);
    }
    $totalPages = ceil($totalListings / $resultsPerPage);
} elseif ($activeTab === 'user_listings' && $userId > 0) {
    $user = get_user_by_id($pdo, $userId);
    $totalListings = get_user_listings_count($pdo, $userId);
    $listings = get_user_listings_admin($pdo, $userId, $startFrom, $resultsPerPage);
    $totalPages = ceil($totalListings / $resultsPerPage);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel - NestlyHomes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="admin.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php" id="nestly-logo">NestlyHomes</a>
        <div id="right-side">
            <a href="../myprofile/index.php">My Profile</a>
            <a href="../includes/logout.inc.php" id="logout">Log Out</a>
        </div>
    </header>

    <main>
        <h1>Admin Control Panel</h1>

        <div class="tabs">
            <button class="tab-btn <?php echo $activeTab === 'users' ? 'active' : ''; ?>" data-tab="users">Users</button>
            <button class="tab-btn <?php echo $activeTab === 'listings' ? 'active' : ''; ?>" data-tab="listings">Listings</button>
        </div>

        <?php if ($activeTab === 'users'): ?>
            <div class="tab-content">
                <div class="controls">
                    <form method="get" class="search-form">
                        <input type="hidden" name="tab" value="users">
                        <input type="number" name="search_id" placeholder="Search by User ID" value="<?php echo $searchId > 0 ? htmlspecialchars((string)$searchId, ENT_QUOTES, 'UTF-8') : ''; ?>">
                        <button type="submit">Search</button>
                        <?php if ($searchId > 0): ?>
                            <a href="?tab=users" class="reset-btn">Clear</a>
                        <?php endif; ?>
                    </form>

                    <?php if ($searchId === 0): ?>
                        <form method="get" class="sort-form">
                            <input type="hidden" name="tab" value="users">
                            <label for="sort-select">Sort by:</label>
                            <select name="sort" id="sort-select">
                                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                            </select>
                            <button type="submit">Apply</button>
                        </form>
                    <?php endif; ?>
                </div>

                <?php print_users_table($users); ?>
                
                <?php if ($searchId === 0 && $totalPages > 1): ?>
                    <?php print_pagination($page, $totalPages, $activeTab, $sort); ?>
                <?php endif; ?>
            </div>

        <?php elseif ($activeTab === 'listings'): ?>
            <div class="tab-content">
                <div class="controls">
                    <form method="get" class="search-form">
                        <input type="hidden" name="tab" value="listings">
                        <input type="number" name="search_id" placeholder="Search by Listing ID" value="<?php echo $searchId > 0 ? htmlspecialchars((string)$searchId, ENT_QUOTES, 'UTF-8') : ''; ?>">
                        <button type="submit">Search</button>
                        <?php if ($searchId > 0): ?>
                            <a href="?tab=listings" class="reset-btn">Clear</a>
                        <?php endif; ?>
                    </form>

                    <?php if ($searchId === 0): ?>
                        <form method="get" class="sort-form">
                            <input type="hidden" name="tab" value="listings">
                            <label for="sort-select">Sort by:</label>
                            <select name="sort" id="sort-select">
                                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                            </select>
                            <button type="submit">Apply</button>
                        </form>
                    <?php endif; ?>
                </div>

                <?php print_listings_table($listings); ?>
                
                <?php if ($searchId === 0 && $totalPages > 1): ?>
                    <?php print_pagination($page, $totalPages, $activeTab, $sort); ?>
                <?php endif; ?>
            </div>

        <?php elseif ($activeTab === 'user_listings' && $userId > 0): ?>
            <div class="tab-content">
                <div class="user-listings-header">
                    <h2>Listings for User: <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['surname']); ?> (ID: <?php echo $userId; ?>)</h2>
                    <a href="?tab=users" class="back-btn">← Back to Users</a>
                </div>

                <?php print_listings_table($listings); ?>
                
                <?php if ($totalPages > 1): ?>
                    <?php print_pagination($page, $totalPages, $activeTab, '', $userId); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <dialog id="confirm-dialog">
        <menu>
            <h2 id="dialog-title"></h2>
            <p id="dialog-message"></p>
            <div class="dialog-buttons">
                <form method="post" action="includes/admin_actions.inc.php" id="confirm-form">
                    <input type="hidden" name="action" id="action-input">
                    <input type="hidden" name="target_id" id="target-id-input">
                    <button type="submit" class="confirm-btn">Confirm</button>
                </form>
                <button class="cancel-btn">Cancel</button>
            </div>
        </menu>
    </dialog>
</body>
</html>