<?php
require_once '../includes/config_session.php';
require_once '../includes/csrf.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <script src="index.js" defer></script>
    <title>Login</title>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <form action="includes/login.inc.php" method="post" id="form">
            <h1>Login</h1>

            <?php print_inputs(); ?>
            <?php print_csrf_input(); ?>

            <input type="submit" name="submit" id="submitid" value="Login">

            <a href="../registration/index.php" id="register-link">Sign Up</a>
        </form>
    </main>
</body>
</html>