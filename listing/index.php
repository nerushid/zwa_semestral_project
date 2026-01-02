<?php
require_once __DIR__ . '/../includes/config_session.php';
require_once __DIR__ . '/../includes/dbh.inc.php';

require_once 'includes/listing_view.inc.php';
require_once 'includes/listing_model.inc.php';
$listingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$listing = get_listing_by_id($pdo, $listingId);
if ($listing === false) {
    header("Location: ../mainpage/index.php");
    die();
}

$user = get_listing_owner($pdo, (int)$listing['user_id']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Details - NestlyHomes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="slider.js" defer></script>
</head>
<body>
    <header>
        <a id="nestly-logo" href="../mainpage/index.php">NestlyHomes</a>
        <div id="right-side">
            <?php print_header($pdo); ?>
        </div>
    </header>

    <main>
        <div class="listing-detail">
            <?php print_slider(get_all_images_for_listing($pdo, $_GET['id'])); ?>

            <div class="listing-info">
                <div class="info-header">
                    <h1>Apartment for Rent</h1>
                    <p class="price"><span class="price-amount"><?php echo htmlspecialchars(number_format((int)$listing['price'], 0, '.', ' ')); ?></span> CZK/month</p>
                </div>

                <div class="basic-info">
                    <div class="info-item">
                        <span class="info-label">Layout:</span>
                        <span class="info-value"><?php echo htmlspecialchars($listing['layout']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Area:</span>
                        <span class="info-value"><?php echo htmlspecialchars($listing['area']); ?> m²</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Location:</span>
                        <span class="info-value"><?php echo htmlspecialchars($listing['praha']) . ', ' . htmlspecialchars($listing['district']); ?></span>
                    </div>
                </div>

                <div class="description-section">
                    <h2>Description</h2>
                    <p class="description">
                        <?php echo nl2br(htmlspecialchars($listing['listing_description'])); ?>
                    </p>
                </div>

                <div class="contact-section">
                    <h2>Contact Owner</h2>
                    <div class="contact-info">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstname']) . ', ' . htmlspecialchars($user['surname']); ?></p>
                        <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>"><?php echo htmlspecialchars($user['email']); ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

