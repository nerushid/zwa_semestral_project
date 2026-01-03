<?php
/**
 * Change Password Form Handler
 * 
 * Processes password change form submissions.
 * Verifies current password and validates new password
 * against security requirements.
 * 
 * @package NestlyHomes
 */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPwd = $_POST["current_password"];
    $newPwd = $_POST["new_password"];
    $newPwdConfirm = $_POST["new_password_confirm"];
    $csrfToken = $_POST["csrf_token"] ?? '';

    try {
        require_once '../../includes/config_session.php';
        require_once '../../includes/csrf.inc.php';
        require_once '../../includes/dbh.inc.php';
        require_once '../../includes/pwd_validation.inc.php';
        require_once 'changepwd_model.inc.php';
        require_once 'changepwd_contr.inc.php';
        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        // CSRF validation
        if (!verify_csrf_token($csrfToken)) {
            $_SESSION["changepwd_errors"] = ['csrf_error' => 'Invalid security token.'];
            header('Location: ../changepwd.php');
            die();
        }

        $errors = [];
        if (empty($currentPwd)) {
            $errors['current_password_error'] = 'Current password is required!';
        } elseif (is_current_password_wrong($currentPwd, get_pwd($pdo, $_SESSION["user_id"]))) {
            $errors['current_password_error'] = 'Current password is incorrect!';
        }

        if (empty($newPwd)) {
            $errors['new_password_error'] = 'New password is required!';
        } else {
            $passwordError = is_password_invalid($newPwd);
            if ($passwordError !== null) {
                $errors['new_password_error'] = $passwordError;
            }
        }
        
        if (empty($newPwdConfirm)) {
            $errors['new_password_confirm_error'] = 'Please confirm your new password!';
        } elseif (is_passwords_mismatch($newPwd, $newPwdConfirm)) {
            $errors['new_password_confirm_error'] = 'New passwords do not match!';
        }

        if ($errors) {
            $_SESSION["changepwd_errors"] = $errors;

            $changepwd_data = [
                'current_password' => $currentPwd,
                'new_password' => $newPwd,
                'new_password_confirm' => $newPwdConfirm
            ];

            $_SESSION['changepwd_data'] = $changepwd_data;

            header('Location: ../changepwd.php');
            $pdo = null;
            $stmt = null;

            die();
        }

        update_user_password($pdo, $_SESSION["user_id"], $newPwd);
        header("Location: ../index.php");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../changepwd.php");
    die();
}
