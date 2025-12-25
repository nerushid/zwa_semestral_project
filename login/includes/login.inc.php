<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $pwd = $_POST["password"];

    try {
        require_once '../../includes/dbh.inc.php'; 
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        $errors = [];

        // Email validation
        if (empty($email)) {
            $errors['email_error'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = 'Invalid email format.';
        }

        // Password validation
        if (empty($pwd)) {
            $errors['password_error'] = 'Password is required.';
        }

        // Check user credentials if no format errors
        if (empty($errors)) {
            $result = get_user($pdo, $email);

            if (!$result) {
                $errors['login_error'] = 'Incorrect email or password.';
            } elseif (!password_verify($pwd, $result["pwd"])) {
                $errors['login_error'] = 'Incorrect email or password.';
            }
        }

        require_once '../../includes/config_session.php';

        if ($errors) {
            $_SESSION["login_errors"] = $errors;
            
            $login_data = [
                'email' => $email
            ];
            $_SESSION["login_data"] = $login_data;

            header("Location: ../index.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_write_close();
        session_id($sessionId);
        session_start();

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_firstname"] = htmlspecialchars($result["firstname"]);
        $_SESSION["user_surname"] = htmlspecialchars($result["surname"]);
        $_SESSION["user_email"] = htmlspecialchars($result["email"]);

        $_SESSION["last_regeneration"] = time();

        unset($_SESSION["login_errors"]);
        unset($_SESSION["login_data"]);

        header("Location: ../../mainpage/index.php");
        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}