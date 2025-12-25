<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0) {
        require_once '../../includes/config_session.php';
        
        $errors = [];
        $errors["image_error"] = "Files are too large. Server limit exceeded.";
        $_SESSION["newlisting_errors"] = $errors;
        
        header("Location: ../index.php");
        die();
    }
    
    try {
        require_once '../../includes/dbh.inc.php';
        require_once '../../includes/config_session.php';
        require_once 'newlisting_model.inc.php';
        require_once 'newlisting_contr.inc.php';
        require_once 'image_resize.inc.php';

        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../mainpage/index.php");
            die();
        }

        $userId = $_SESSION["user_id"];
        $praha = $_POST["praha"] ?? '';
        $district = $_POST["district"] ?? '';
        $layout = $_POST["layout"] ?? '';
        $area = $_POST["area"] ?? '';
        $price = $_POST["price"] ?? '';
        $description = $_POST["description"] ?? '';

        $images = $_FILES["listingImages"] ?? null;

        $errors = [];
        if (empty($praha)) {
            $errors["praha_error"] = "Please select a Praha.";
        } elseif (is_praha_invalid($praha)) {
            $errors["praha_error"] = "Please select a valid Praha.";
        }

        if (empty($district)) {
            $errors["district_error"] = "Please select a district.";
        } elseif (is_district_invalid($district, $praha)) {
            $errors["district_error"] = "Please select a valid district for the selected Praha.";
        }

        if (empty($layout)) {
            $errors["layout_error"] = "Please enter the layout.";
        } elseif (is_layout_invalid($layout)) {
            $errors["layout_error"] = "Please select a valid layout.";
        }

        if (empty($area)) {
            $errors["area_error"] = "Please enter the area.";
        } elseif (!is_numeric($area) || (int)$area <= 0) {
            $errors["area_error"] = "Please enter a valid area.";
        } elseif (!preg_match('/^\d+$/', $area)) {
            $errors["area_error"] = "Area must be an integer.";
        }

        if (empty($price)) {
            $errors["price_error"] = "Please enter the price.";
        } elseif (!is_numeric($price) || (int)$price <= 0) {
            $errors["price_error"] = "Please enter a valid price.";
        } elseif (!preg_match('/^\d+$/', $price)) {
            $errors["price_error"] = "Price must be an integer.";
        }

        if (empty($description)) {
            $errors["description_error"] = "Description is required.";
        } elseif (strlen($description) < 20) {
            $errors["description_error"] = "Description must be at least 20 characters.";
        } elseif (!preg_match("/^[\p{L}\p{N}\s.,!?;:()\-–—'\"\/\n\r]+$/u", $description)) {
            $errors["description_error"] = "Description contains invalid characters. Only letters, numbers, spaces, and basic punctuation are allowed.";
        }

        if ($images === null || is_file_upload_empty($images)) {
             $errors["image_error"] = "Please upload at least one photo.";
        } elseif (is_file_count_invalid($images)) {
             $errors["image_error"] = "Maximum 10 photos allowed.";
        } else {
            $imagesCount = count($images['name']);

            for ($i = 0; $i < $imagesCount; $i++) {
                if ($images['error'][$i] !== UPLOAD_ERR_OK) {
                    continue; 
                }

                if (is_file_size_too_big($images['size'][$i])) {
                    $errors["image_error"] = "One of the files is too large (max 5MB).";
                    break; 
                }

                if (is_file_format_invalid($images['tmp_name'][$i])) {
                    $errors["image_error"] = "Invalid file type. Only JPG, PNG, WEBP allowed.";
                    break;
                }
            }
        }

        if ($errors) {
            $_SESSION['newlisting_errors'] = $errors;
            $_SESSION['newlisting_data'] = [
                'praha' => $praha,
                'district' => $district,
                'layout' => $layout,
                'area' => $area,
                'price' => $price,
                'description' => $description
            ];
            header("Location: ../index.php");
            die();
        }
        

        $listingId = create_new_listing($pdo, $userId, $praha, $district, $layout, (int)$area, (int)$price, $description);

        $imagePaths = [];
        $imagesCount = count($images['name']);
        for ($i = 0; $i < $imagesCount; $i++) {
            if ($images['error'][$i] === UPLOAD_ERR_OK) {
                $extension = pathinfo($images['name'][$i], PATHINFO_EXTENSION);

                $uniqueName = "listing_" . $listingId . "_" . uniqid();

                $newFileName = $uniqueName . "." . $extension;
                $destination = "../../uploads/" . $newFileName;

                $fileNameThumb = "thumb_" . $uniqueName . "." . $extension;
                $destinationThumb = "../../uploads/" . $fileNameThumb;

                $fileNameMedium = "medium_" . $uniqueName . "." . $extension;
                $destinationMedium = "../../uploads/" . $fileNameMedium;
                

                if (move_uploaded_file($images['tmp_name'][$i], $destination)) {
                    resize_image($destination, $destinationThumb, 280);
                    resize_image($destination, $destinationMedium, 600);

                    $imagePaths[] = $newFileName;
                }
            }
        }

        if (!empty($imagePaths)) {
            save_listing_images($pdo, $listingId, $imagePaths);
        }

        // Clear session data after successful submission
        unset($_SESSION['newlisting_errors']);
        unset($_SESSION['newlisting_data']);

        $pdo = null;
        $stmt = null;

        header("Location: ../../mainpage/index.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../index.php");
    die();
}

