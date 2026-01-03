<?php
/**
 * Password Validation Module
 * 
 * Provides password validation against security requirements.
 * Enforces minimum length, maximum length, and character composition rules.
 * 
 * @package NestlyHomes
 * @subpackage Validation
 */

declare(strict_types=1);

/**
 * Validates password against security requirements
 * 
 * Checks password for:
 * - Minimum 8 characters
 * - Maximum 72 characters (bcrypt limit)
 * - At least one letter
 * - At least one number
 * 
 * @param string $pwd The password to validate
 * @return string|null Error message if invalid, null if valid
 */
function is_password_invalid(string $pwd): ?string {
    $errors = [];
    
    if (strlen($pwd) < 8) {
        $errors[] = "at least 8 characters";
    }
    
    if (strlen($pwd) > 72) {
        $errors[] = "maximum 72 characters";
    }
    
    if (!preg_match('/[a-zA-Z]/', $pwd)) {
        $errors[] = "at least one letter";
    }
    
    if (!preg_match('/[0-9]/', $pwd)) {
        $errors[] = "at least one number";
    }
    
    if (!empty($errors)) {
        return "Password must contain: " . implode(", ", $errors) . ".";
    }
    
    return null;
}
