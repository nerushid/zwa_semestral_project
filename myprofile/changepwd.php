<?php
require_once '../includes/config_session.php';
require_once 'includes/changepwd_view.inc.php';
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
    <title>Change Password</title>
    <link rel="stylesheet" href="changepwd.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <h1>Change Password</h1>

        <form action="includes/changepwd.inc.php" method="post" id="form">
            <?php print_inputs(); ?>

            <div class="button-group">
                <button type="submit" class="save-button">Change Password</button>
                <a href="index.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </main>
</body>
</html>
