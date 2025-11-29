<?php
require_once '../includes/config_session.php';
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
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current_password" placeholder="Enter your current password">
                <div class="error" id="current_password_error"></div>
            </div>

            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" placeholder="Enter your new password">
                <div class="error" id="new_password_error"></div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your new password">
                <div class="error" id="confirm_password_error"></div>
            </div>

            <div class="button-group">
                <button type="submit" class="save-button">Change Password</button>
                <a href="index.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </main>
</body>
</html>
