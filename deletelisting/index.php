<?php
require_once '../includes/config_session.php';
require_once '../includes/dbh.inc.php';
require_once '../editlisting/includes/editlisting_model.inc.php';

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
    <title>Delete Listing</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../myprofile/header.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="deletelisting.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <dialog id="delete-dialog" open>
        <menu>
            <h2>Delete Listing</h2>
            <p>Are you sure you want to delete this listing?</p>
            <div class="listing-preview">
                <p><strong>Location:</strong> Prague <?php echo htmlspecialchars($listing['praha']); ?>, <?php echo htmlspecialchars($listing['district']); ?></p>
                <p><strong>Layout:</strong> <?php echo htmlspecialchars($listing['layout']); ?></p>
                <p><strong>Price:</strong> <?php echo htmlspecialchars(number_format((int)$listing['price'], 0, '.', ' ')); ?> CZK/month</p>
            </div>
            <p class="warning">This action cannot be undone!</p>
            
            <div class="dialog-buttons">
                <form action="includes/deletelisting.inc.php" method="post" id="delete-form">
                    <input type="hidden" name="listing_id" value="<?php echo $listingId; ?>">
                    <button type="submit" class="delete-btn">Delete Listing</button>
                </form>
                <button id="cancel-btn" class="cancel-btn">Cancel</button>
            </div>
        </menu>
    </dialog>
</body>
</html>
