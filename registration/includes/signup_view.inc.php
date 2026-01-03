<?php
/**
 * Registration View Helper
 * 
 * Contains functions for rendering registration form elements
 * with error handling and value persistence.
 * 
 * @package NestlyHomes\Views
 */

declare(strict_types=1);

function signup_inputs() {
    $firstNameValue = $_SESSION["signup_data"]["firstname"] ?? '';
    $surnameValue = $_SESSION["signup_data"]["surname"] ?? '';
    $emailValue = $_SESSION["signup_data"]["email"] ?? '';
    
    $firstNameError = $_SESSION["signup_errors"]["firstname_error"] ?? '';
    $surnameError = $_SESSION["signup_errors"]["surname_error"] ?? '';
    $emailError = $_SESSION["signup_errors"]["email_error"] ?? '';
    
    $firstNameClass = $firstNameError ? ' error-input' : '';
    $surnameClass = $surnameError ? ' error-input' : '';
    $emailClass = $emailError ? ' error-input' : '';
    
    echo '<div id="name-username">
        <div>
            <label for="nameid">First name: <span class="required">*</span></label>
            <input type="text" name="name" class="first-name' . $firstNameClass . '" id="nameid" placeholder="First name" 
            value="' . htmlspecialchars($firstNameValue) . '">
            <div class="error" id="first-name-error">' . ($firstNameError ? '* ' . $firstNameError : '') . '</div>
        </div>
        <div>
            <label for="surnameid">Surname: <span class="required">*</span></label>
            <input type="text" name="surname" class="surname' . $surnameClass . '" id="surnameid" placeholder="Surname" 
            value="' . htmlspecialchars($surnameValue) . '">
            <div class="error" id="surname-error">' . ($surnameError ? '* ' . $surnameError : '') . '</div>
        </div>
    </div>';

    echo '<label for="emailid">Email: <span class="required">*</span></label>
    <input type="text" name="email" class="email' . $emailClass . '" id="emailid" placeholder="Your email" 
    value="' . htmlspecialchars($emailValue) . '">
    <div class="error" id="email-error">' . ($emailError ? '* ' . $emailError : '') . '</div>';
}

function password_input() {
    $passwordError = $_SESSION["signup_errors"]['password_error'] ?? '';
    $passwordConfirmError = $_SESSION["signup_errors"]['password_confirm_error'] ?? '';
    
    $passwordConfirmClass = $passwordConfirmError ? ' error-input' : '';
    
    echo '<input type="password" name="password-confirm" id="password-confirmid" placeholder="Confirm password" class="' . $passwordConfirmClass . '">
        <div class="error" id="password-confirm-error">' . ($passwordConfirmError ? '* ' . $passwordConfirmError : '') . '</div>';

    echo '<div class="error" id="csrf-error">' . htmlspecialchars($_SESSION["signup_errors"]["csrf_error"] ?? '') . '</div>';

    unset($_SESSION['signup_errors']);
    unset($_SESSION['signup_data']);
}