<?php
/**
 * Admin Actions Handler
 * 
 * Processes administrative actions from the admin panel.
 * Handles user management (delete, promote, demote) and
 * listing management (delete) operations.
 * 
 * @package NestlyHomes
 */

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        require_once '../../includes/config_session.php';
        require_once '../../includes/dbh.inc.php';
        require_once 'admin_model.inc.php';

        if (!isset($_SESSION["user_id"]) || !is_admin($pdo, $_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        $action = $_POST['action'] ?? '';
        $targetId = isset($_POST['target_id']) ? (int)$_POST['target_id'] : 0;

        switch ($action) {
            case 'delete_user':
                if ($targetId > 0 && $targetId !== $_SESSION["user_id"]) {
                    delete_user_admin($pdo, $targetId);
                    header("Location: ../index.php?tab=users");
                }
                break;

            case 'make_admin':
                if ($targetId > 0) {
                    make_admin($pdo, $targetId);
                    header("Location: ../index.php?tab=users");
                }
                break;

            case 'remove_admin':
                if ($targetId > 0 && $targetId !== $_SESSION["user_id"]) {
                    remove_admin($pdo, $targetId);
                    header("Location: ../index.php?tab=users");
                }
                break;

            case 'delete_listing':
                if ($targetId > 0) {
                    delete_listing_admin($pdo, $targetId);
                    $returnTab = $_POST['return_tab'] ?? 'listings';
                    header("Location: ../index.php?tab=" . $returnTab);
                }
                break;

            default:
                header("Location: ../index.php");
                break;
        }

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
