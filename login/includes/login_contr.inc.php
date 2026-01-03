<?php
/**
 * Login Controller
 * 
 * Contains validation functions for login form processing.
 * 
 * @package NestlyHomes\Controllers
 */

declare(strict_types=1);

/**
 * Checks if login inputs are empty
 * 
 * @param string $email The email input value
 * @param string $pwd The password input value
 * @return bool True if either input is empty, false otherwise
 */
function is_inputs_empty(string $email, string $pwd): bool {
    if (empty($email) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if user lookup returned no results
 * 
 * @param array|bool $result The result from user database lookup
 * @return bool True if user was not found, false otherwise
 */
function is_user_wrong(array|bool $result): bool {
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

/**
 * Verifies password against stored hash
 * 
 * @param string $pwd The plaintext password to verify
 * @param string $hashedPwd The stored password hash
 * @return bool True if password is incorrect, false if correct
 */
function is_password_wrong(string $pwd, string $hashedPwd): bool {
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}