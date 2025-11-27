<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $email = trim($_POST["email"]);
    $pwd = $_POST["password"];
    $pwd_confirm = $_POST["password-confirm"];

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        $errors = [];

        if (is_inputs_empty($firstName, $surname, $email, $pwd, $pwd_confirm)) {
            $errors['empty_input'] = 'Fill in all fields!';
        }
        if (is_email_invalid($email)) {
            $errors['invalid_email'] = 'Invalid email used!';
        }

        if (is_email_registred($pdo, $email)) {
            $errors['email_registred'] = 'Email alredy registred';
        }

        if (is_passwords_mismatch($pwd, $pwd_confirm)) {
            $errors['password_mismatch'] = 'Passwords do not match';
        }

        require_once 'config_session.php';
        
        if ($errors) {
            $_SESSION["signup_errors"] = $errors;

            $signup_data = [
                'firstName' => $firstName,
                'surname' => $surname,
                'email' => $email
            ];
            
            $_SESSION['signup_data'] = $signup_data;

            header('Location: ../index.php');
            die();
        }

        create_user($pdo, $firstName, $surname, $email, $pwd);
        header("Location: ../../mainpage/index.html");
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}