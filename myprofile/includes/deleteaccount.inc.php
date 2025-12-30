<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    try {
        require_once '../../includes/dbh.inc.php';
        require_once '../../includes/config_session.php';
        require_once '../../includes/csrf.inc.php';
        require_once 'deleteaccount_model.inc.php';

        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        // CSRF validation
        $csrfToken = $_POST["csrf_token"] ?? '';
        if (!verify_csrf_token($csrfToken)) {
            header("Location: ../index.php");
            die();
        }

        $userId = $_SESSION["user_id"];

        delete_user($pdo, $userId);

        session_unset();
        session_destroy();

        $pdo = null;
        $stmt = null;

        header("Location: ../../mainpage/index.php?accountdeleted=success");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../index.php");
    die();
}