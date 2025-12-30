<?php
require_once '../includes/config_session.php';
require_once '../includes/dbh.inc.php';
require_once '../includes/csrf.inc.php';
require_once 'includes/editlisting_view.inc.php';
require_once 'includes/editlisting_model.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../mainpage/index.php");
    die();
}

$listingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$listing = get_listing_by_id($pdo, $listingId);

if (!$listing || $listing['user_id'] !== $_SESSION["user_id"]) {
    header("Location: ../myprofile/mylistings.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../myprofile/header.css">
    <script src="editlisting.js" defer></script>
    <script src="fh.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <h1>Edit Listing</h1>

        <form action="includes/editlisting.inc.php" method="post" id="form">
            <input type="hidden" name="listing_id" value="<?php echo $listingId; ?>">
            <?php print_inputs($listing); ?>
            <?php print_csrf_input(); ?>

            <div class="button-group">
                <button type="submit" class="save-button">Save Changes</button>
                <a href="../myprofile/mylistings.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </main>
</body>
</html>
