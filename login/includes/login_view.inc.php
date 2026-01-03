<?php
/**
 * Login View Helper
 * 
 * Contains functions for rendering login form elements
 * with error handling and value persistence.
 * 
 * @package NestlyHomes\Views
 */

declare(strict_types=1);

/**
 * Prints login form input fields
 * 
 * Renders email and password input fields with error messages
 * and value persistence from session data. Handles display
 * of validation errors and CSRF errors.
 * 
 * @return void
 */
function print_inputs(): void {
    $emailValue = $_SESSION["login_data"]["email"] ?? '';
    $emailError = $_SESSION["login_errors"]["email_error"] ?? '';
    $passwordError = $_SESSION["login_errors"]["password_error"] ?? '';
    $loginError = $_SESSION["login_errors"]["login_error"] ?? '';
    
    $emailClass = $emailError ? ' error-input' : '';
    $passwordClass = ($passwordError || $loginError) ? ' error-input' : '';
    
    echo '<label for="emailid">Email: <span class="required">*</span></label>
    <input type="text" name="email" class="email' . $emailClass . '" id="emailid" placeholder="Your email address" 
    value="' . htmlspecialchars($emailValue) . '">
    <div class="error" id="email-error">' . ($emailError ? '* ' . $emailError : '') . '</div>';

    echo '<label for="passwordid">Password: <span class="required">*</span></label>
    <input type="password" name="password" id="passwordid" placeholder="Password" class="' . $passwordClass . '">
    <div class="error" id="password-error">' . ($passwordError ? '* ' . $passwordError : ($loginError ? '* ' . $loginError : '')) . '</div>';

    echo '<div class="error" id="csrf-error">' . htmlspecialchars($_SESSION["login_errors"]["csrf_error"] ?? '') . '</div>';

    unset($_SESSION['login_errors']);
    unset($_SESSION['login_data']);
}