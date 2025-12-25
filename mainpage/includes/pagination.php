<?php
require_once __DIR__ . '/../../includes/dbh.inc.php';
require_once __DIR__ . '/../../includes/config_session.php';
require_once __DIR__ . '/mainpage_model.inc.php';
$resultsPerPage = 6;

$totalListings = get_number_of_listings($pdo);

$totalPages = ceil($totalListings / $resultsPerPage);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));

$startFrom = ($page - 1) * $resultsPerPage;

$_SESSION['listings'] = get_listings_with_limit($pdo, $startFrom, $resultsPerPage);
$_SESSION['total_pages'] = $totalPages;
$_SESSION['pdo'] = $pdo;