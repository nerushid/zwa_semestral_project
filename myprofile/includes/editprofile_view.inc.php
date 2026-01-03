<?php
/**
 * Edit Profile View Helper
 * 
 * Contains functions for rendering edit profile form elements
 * with error handling and value persistence.
 * 
 * @package NestlyHomes\Views
 */

declare(strict_types=1);

/**
 * Prints edit profile form input fields
 * 
 * Renders input fields for first name, surname, and email
 * with current values, error messages, and CSRF error display.
 * Clears session data after rendering.
 * 
 * @return void
 */
function print_inputs(): void {
    $firstnameValue = $_SESSION["editprofile_data"]["firstname"] ?? $_SESSION["user_firstname"];
    $surnameValue = $_SESSION["editprofile_data"]["surname"] ?? $_SESSION["user_surname"];
    $emailValue = $_SESSION["editprofile_data"]["email"] ?? $_SESSION["user_email"];
    
    $firstnameError = $_SESSION["editprofile_errors"]["firstname_error"] ?? '';
    $surnameError = $_SESSION["editprofile_errors"]["surname_error"] ?? '';
    $emailError = $_SESSION["editprofile_errors"]["email_error"] ?? '';
    
    $firstnameClass = $firstnameError ? ' error-input' : '';
    $surnameClass = $surnameError ? ' error-input' : '';
    $emailClass = $emailError ? ' error-input' : '';

    echo '<div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" 
            value="' . htmlspecialchars($firstnameValue) . '" class="' . $firstnameClass . '">
            <div class="error" id="firstname_error">' . ($firstnameError ? '* ' . $firstnameError : '') . '</div>
        </div>';

    echo '<div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname" placeholder="Enter your surname" 
            value="' . htmlspecialchars($surnameValue) . '" class="' . $surnameClass . '">
            <div class="error" id="surname_error">' . ($surnameError ? '* ' . $surnameError : '') . '</div>
        </div>';

    echo '<div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email" 
            value="' . htmlspecialchars($emailValue) . '" class="' . $emailClass . '">
            <div class="error" id="email_error">' . ($emailError ? '* ' . $emailError : '') . '</div>
        </div>';

    echo '<div class="error" id="csrf-error">' . htmlspecialchars($_SESSION["editprofile_errors"]["csrf_error"] ?? '') . '</div>';

    unset($_SESSION["editprofile_errors"]);
    unset($_SESSION["editprofile_data"]);
}