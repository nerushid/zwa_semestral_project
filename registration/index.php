<?php
require_once '../includes/config_session.php';
require_once '../includes/csrf.inc.php';
require_once 'includes/signup_view.inc.php';

$passwordError = $_SESSION['signup_errors']['password_error'] ?? '';
$passwordClass = $passwordError ? ' error-input' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="../includes/print.css" media="print">
    <script src="index.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>

    <main>
        <form action="includes/signup.inc.php" method="post" class="registration-form" id="form1">
            <h1>Sign Up</h1>
            <?php signup_inputs(); ?>

            <label for="passwordid">Password: <span class="required">*</span></label>
            <input type="password" name="password" id="passwordid" placeholder="Password" class="<?php echo $passwordClass; ?>">
            <div class="error" id="password-error"><?php echo $passwordError ? '* ' . $passwordError : ''; ?></div>

            <label for="password-confirmid">Password confirm: <span class="required">*</span></label>
            <?php password_input(); ?>
            <?php print_csrf_input(); ?>

            <input type="submit" name="submit" id="submitid" value="Sign Up">
            <a href="../login/index.php" id="login-link">Login</a>
            
        </form>
    </main>

</body>
</html>