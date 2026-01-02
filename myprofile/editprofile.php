<?php
require_once '../includes/config_session.php';
require_once '../includes/csrf.inc.php';
require_once 'includes/editprofile_view.inc.php';
if (!isset($_SESSION["user_id"])) {
    header("Location: ../mainpage/index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editprofile.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="editprofile.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <h1>Edit Profile</h1>

        <form action="includes/editprofile.inc.php" method="post" id="form">
            <?php print_inputs(); ?>
            <?php print_csrf_input(); ?>

            <div class="button-group">
                <button type="submit" class="save-button">Save Changes</button>
                <a href="index.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </main>
</body>
</html>