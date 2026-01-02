<?php
require_once '../includes/config_session.php';
require_once '../includes/csrf.inc.php';
require_once 'includes/myprofile_view.inc.php';

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
    <title>My Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="deleteaccount_dialog.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="deleteaccount.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <dialog id="deleteaccount-dialog">
        <menu>
            <h2>Delete Account</h2> 
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            
            <div class="dialog-buttons">
                <form action="includes/deleteaccount.inc.php" method="post" id="delete-form">
                    <?php print_csrf_input(); ?>
                    <button type="submit">Delete</button>
                </form>
                <button id="cancel">Cancel</button>
            </div>
        </menu>
    </dialog>

    <main>
        <h1>My Profile</h1>
        <?php print_user(); ?>

        <a href="editprofile.php" class="edit-profile">Edit Profile</a>
        <a href="changepwd.php" class="change-password">Change Password</a>
        <a href="mylistings.php" class="mylistings">My Listings</a>
        <a href="#" id="deleteaccountBtn" class="deleteaccountBtn">Delete Account</a>
        
    </main>
</body>
</html>