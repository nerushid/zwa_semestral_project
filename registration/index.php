<?php
require_once 'includes/config_session.php';
require_once 'includes/signup_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <script src="index.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.html">NestlyHomes</a>
    </header>

    <main>
        <form action="includes/signup.inc.php" method="post" class="registration-form" id="form1">
            <h1>Sign Up</h1>
            <?php signup_inputs(); ?>

            <label for="passwordid">Password: <span class="required">*</span></label>
            <input type="password" name="password" id="passwordid" placeholder="Password">
            <div class="error" id="password-error"></div>

            <label for="password-confirmid">Password confirm: <span class="required">*</span></label>
            <?php password_input(); ?>

            <input type="submit" name="submit" id="submitid" value="Sign Up">
            <a href="../login/login.html" id="login-link">Login</a>
            
        </form>
    </main>

</body>
</html>