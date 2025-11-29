<?php
require_once '../includes/config_session.php';
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
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <h1>My Profile</h1>
        <?php print_user(); ?>

        <button class="edit-profile">Edit Profile</button>
        <button class="change-password">Change Password</button>
        <button class="delete-account">Delete Account</button>
    </main>
</body>
</html>