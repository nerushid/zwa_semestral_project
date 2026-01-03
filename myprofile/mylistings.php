<?php
/**
 * My Listings Page
 * 
 * Displays paginated list of user's own listings with
 * sorting options and edit/delete actions.
 * Requires authentication.
 * 
 * @package 
 */

require_once '../includes/config_session.php';
require_once 'includes/mylistings_view.inc.php';
require_once 'includes/mylistings_model.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../mainpage/index.php");
    die();
}

require_once '../includes/dbh.inc.php';

$resultsPerPage = 6;

$sort = $_GET['sort'] ?? 'newest';
if (!in_array($sort, ['newest', 'oldest', 'cheap', 'expensive'])) {
    $sort = 'newest';
}

$totalListings = get_total_user_listings_count($pdo, $_SESSION["user_id"]);
$totalPages = ceil($totalListings / $resultsPerPage);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$startFrom = ($page - 1) * $resultsPerPage;

$listings = get_user_listings_with_limit($pdo, $_SESSION["user_id"], $startFrom, $resultsPerPage, $sort);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings</title>
    <link rel="stylesheet" href="mylistings.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="mylistings_sort.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <h1>My Listings</h1>
        <?php print_sort_dropdown($sort); ?>
        <?php print_listings($listings); ?>
        <?php print_pagination($page, $totalPages, $sort); ?>
        <a href="index.php" class="back-button">Back to Profile</a>
    </main>
</body>
</html>
