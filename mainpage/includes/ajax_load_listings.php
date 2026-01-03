<?php
/**
 * AJAX Listings Loader
 * 
 * Handles AJAX requests for dynamic listing updates.
 * Returns HTML content for listings section with pagination.
 * Used for filter updates without full page reload.
 * 
 * @package NestlyHomes
 */

require_once __DIR__ . '/../../includes/config_session.php';
require_once __DIR__ . '/../../includes/dbh.inc.php';
require_once __DIR__ . '/mainpage_model.inc.php';
require_once __DIR__ . '/mainpage_view.inc.php';
require_once __DIR__ . '/mainpage_contr.inc.php';

$resultsPerPage = 6;

$sort = $_GET['sort'] ?? 'newest';
if (!isValidSortByFilter($sort)) {
    $sort = 'newest';
}
// Escape for HTML output
$sortEscaped = htmlspecialchars($sort, ENT_QUOTES, 'UTF-8');

$conditionsAndParams = setConditionForQuerry($_GET);

$totalListings = get_number_of_listings($pdo, $conditionsAndParams['conditions'], $conditionsAndParams['params']);
$totalPages = ceil($totalListings / $resultsPerPage);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$startFrom = ($page - 1) * $resultsPerPage;

$listings = get_listings_with_limit($pdo, $startFrom, $resultsPerPage, $conditionsAndParams['conditions'], $conditionsAndParams['params'], $sort);
?>

<div class="sort-container">
    <label for="sort-select">Sort by:</label>
    <select id="sort-select">
        <option value="newest" <?php if($sort === 'newest') echo 'selected'; ?>>Newest</option>
        <option value="cheap" <?php if($sort === 'cheap') echo 'selected'; ?>>Price: Low to High</option>
        <option value="expensive" <?php if($sort === 'expensive') echo 'selected'; ?>>Price: High to Low</option>
    </select>
</div>

<section class="listings">
    <?php print_listings($pdo, $listings); ?>
</section>

<?php print_pagination($page, $totalPages); ?>