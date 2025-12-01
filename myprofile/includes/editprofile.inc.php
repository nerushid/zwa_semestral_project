<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $firstname = trim($_POST["firstname"]);
    $surname = trim($_POST["surname"]);
    $email = trim($_POST["email"]);


    try {
        require_once '../../includes/config_session.php';
        require_once '../../includes/dbh.inc.php'; 
        require_once 'editprofile_model.inc.php';
        require_once 'editprofile_contr.inc.php';
        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        $errors = [];


        // First Name validation
        if (empty($firstname)) {
            $errors["firstname_error"] = "First name is required.";
        } else if (is_name_invalid($firstname)) {
            $errors["firstname_error"] = "First name can only contain letters and spaces.";
        }

        // Surname validation
        if (empty($surname)) {
            $errors["surname_error"] = "Surname is required.";
        } else if (is_surname_invalid($surname)) {
            $errors["surname_error"] = "Surname can only contain letters and spaces.";
        }

        

        // Email validation
        if (empty($email)) {
            $errors["email_error"] = "Email is required.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email_error"] = "Invalid email format.";
        } else if ($email !== $_SESSION["user_email"] && is_email_registered($pdo, $email)) {
            $errors["email_error"] = "Email is already registered.";
        }
        
        if ($errors) {
            $_SESSION["editprofile_errors"] = $errors;

            $editprofile_data = [
                'firstname' => $firstname,
                'surname' => $surname,
                'email' => $email
            ];
            
            $_SESSION['editprofile_data'] = $editprofile_data;

            header('Location: ../editprofile.php');
            $pdo = null;
            $stmt = null;

            die();
        }

        update_user_profile($pdo, $_SESSION["user_id"], $firstname, $surname, $email);
        $_SESSION["user_firstname"] = htmlspecialchars($firstname);
        $_SESSION["user_surname"] = htmlspecialchars($surname);
        $_SESSION["user_email"] = htmlspecialchars($email);

        unset($_SESSION["editprofile_errors"]);
        unset($_SESSION["editprofile_data"]);

        header("Location: ../index.php");
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



