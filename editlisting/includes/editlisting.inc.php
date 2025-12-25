<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $listingId = (int)$_POST["listing_id"];
    $praha = isset($_POST["praha"]) ? trim($_POST["praha"]) : '';
    $district = isset($_POST["district"]) ? trim($_POST["district"]) : '';
    $layout = isset($_POST["layout"]) ? trim($_POST["layout"]) : '';
    $area = isset($_POST["area"]) ? trim($_POST["area"]) : '';
    $price = isset($_POST["price"]) ? trim($_POST["price"]) : '';
    $description = isset($_POST["description"]) ? trim($_POST["description"]) : '';

    try {
        require_once '../../includes/config_session.php';
        require_once '../../includes/dbh.inc.php';
        require_once 'editlisting_model.inc.php';
        require_once 'editlisting_contr.inc.php';

        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        // Verify ownership
        $listing = get_listing_by_id($pdo, $listingId);
        if (!$listing || $listing['user_id'] !== $_SESSION["user_id"]) {
            header("Location: ../../myprofile/mylistings.php");
            die();
        }

        $errors = [];

        // Praha validation
        if (empty($praha)) {
            $errors["praha_error"] = "Prague district is required.";
        } elseif (!isValidPrahaFilter($praha)) {
            $errors["praha_error"] = "Invalid Prague district selected.";
        }

        // District validation
        if (empty($district)) {
            $errors["district_error"] = "Specific district is required.";
        } elseif (!empty($praha) && !isValidDistrictFilter($district, $praha)) {
            $errors["district_error"] = "Invalid district for selected Prague area.";
        }

        // Layout validation
        if (empty($layout)) {
            $errors["layout_error"] = "Layout is required.";
        } elseif (!isValidLayoutFilter($layout)) {
            $errors["layout_error"] = "Invalid layout selected.";
        }

        // Area validation
        if (empty($area)) {
            $errors["area_error"] = "Area is required.";
        } elseif (!ctype_digit($area) || (int)$area <= 0) {
            $errors["area_error"] = "Area must be a positive number.";
        }

        // Price validation
        if (empty($price)) {
            $errors["price_error"] = "Price is required.";
        } elseif (!ctype_digit($price) || (int)$price <= 0) {
            $errors["price_error"] = "Price must be a positive number.";
        }

        // Description validation
        if (empty($description)) {
            $errors["description_error"] = "Description is required.";
        } elseif (strlen($description) < 20) {
            $errors["description_error"] = "Description must be at least 20 characters.";
        } elseif (!preg_match("/^[\p{L}\p{N}\s.,!?;:()\-–—'\"\/\n\r]+$/u", $description)) {
            $errors["description_error"] = "Description contains invalid characters. Only letters, numbers, spaces, and basic punctuation are allowed.";
        }

        if ($errors) {
            $_SESSION["editlisting_errors"] = $errors;
            $_SESSION['editlisting_data'] = [
                'praha' => $praha,
                'district' => $district,
                'layout' => $layout,
                'area' => $area,
                'price' => $price,
                'listing_description' => $description
            ];

            header('Location: ../index.php?id=' . $listingId);
            die();
        }

        update_listing($pdo, $listingId, (int)$praha, $district, $layout, (int)$area, (int)$price, $description);

        header("Location: ../../myprofile/mylistings.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
