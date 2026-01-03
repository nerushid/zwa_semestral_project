<?php
/**
 * Registration Form Handler
 * 
 * Processes user registration form submissions.
 * Validates all input fields, handles image uploads,
 * and creates new user accounts with hashed passwords.
 * 
 * @package NestlyHomes
 */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $email = trim($_POST["email"]);
    $pwd = $_POST["password"];
    $pwd_confirm = $_POST["password-confirm"];
    $csrfToken = $_POST["csrf_token"] ?? '';

    try {
        require_once '../../includes/dbh.inc.php'; 
        require_once '../../includes/config_session.php';
        require_once '../../includes/csrf.inc.php';
        require_once '../../includes/pwd_validation.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        // CSRF validation
        if (!verify_csrf_token($csrfToken)) {
            $_SESSION["signup_errors"] = [
                'csrf_error' => 'Invalid security token. Please try again.'
            ];

            // Preserve user input on CSRF failure
            $signup_data = [
                'firstname' => $firstName,
                'surname' => $surname,
                'email' => $email
            ];
            $_SESSION['signup_data'] = $signup_data;

            header("Location: ../index.php");
            die();
        }

        $errors = [];

        // First Name validation
        if (empty($firstName)) {
            $errors['firstname_error'] = 'First name is required.';
        } elseif (is_name_invalid($firstName)) {
            $errors['firstname_error'] = 'First name can only contain letters, spaces, hyphens, and apostrophes.';
        }

        // Surname validation
        if (empty($surname)) {
            $errors['surname_error'] = 'Surname is required.';
        } elseif (is_name_invalid($surname)) {
            $errors['surname_error'] = 'Surname can only contain letters, spaces, hyphens, and apostrophes.';
        }

        // Email validation
        if (empty($email)) {
            $errors['email_error'] = 'Email is required.';
        } elseif (is_email_invalid($email)) {
            $errors['email_error'] = 'Invalid email format.';
        } elseif (is_email_registred($pdo, $email)) {
            $errors['email_error'] = 'Email already registered.';
        }

        // Password validation
        if (empty($pwd)) {
            $errors['password_error'] = 'Password is required.';
        } else {
            $passwordError = is_password_invalid($pwd);
            if ($passwordError !== null) {
                $errors['password_error'] = $passwordError;
            }
        }

        // Password confirmation validation
        if (empty($pwd_confirm)) {
            $errors['password_confirm_error'] = 'Please confirm your password.';
        } elseif (is_passwords_mismatch($pwd, $pwd_confirm)) {
            $errors['password_confirm_error'] = 'Passwords do not match.';
        }
        
        if ($errors) {
            $_SESSION["signup_errors"] = $errors;

            $signup_data = [
                'firstname' => $firstName,
                'surname' => $surname,
                'email' => $email
            ];
            
            $_SESSION['signup_data'] = $signup_data;

            header('Location: ../index.php');
            die();
        }

        create_user($pdo, $firstName, $surname, $email, $pwd);

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