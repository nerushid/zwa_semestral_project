<?php
require_once '../includes/config_session.php';
require_once 'includes/newlisting_view.inc.php';
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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css">
    <script src="imgupload.js" defer></script>
    <script src="select.js" defer></script>
    <script src="formcheck.js" defer></script>
</head>
<body>
    <header>
        <a href="../mainpage/index.php">NestlyHomes</a>
    </header>
    <main>
        <form action="includes/newlisting.inc.php" method="post" id="formid" enctype="multipart/form-data">
            <h1 id="topicid">--- New listing ---</h1>

            <?php print_newlisting_form(); ?>

            <input type="submit" value="Submit Listing" name="submitlisting" id="submitlistingid">
            <?php
            unset($_SESSION["newlisting_errors"]);
            unset($_SESSION["newlisting_data"]);
            ?>
        </form>
    </main>
</body>
</html>