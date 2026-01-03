<?php
/**
 * Edit Profile Controller
 * 
 * Contains validation functions for profile editing.
 * 
 * @package NestlyHomes\Controllers
 */

declare(strict_types=1);

/**
 * Checks if email is already registered
 * 
 * @param object $pdo PDO database connection instance
 * @param string $email Email address to check
 * @return bool True if email exists, false otherwise
 */
function is_email_registered(object $pdo, string $email): bool {
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Validates first name format
 * 
 * Checks if name contains only letters, spaces, hyphens, and apostrophes.
 * Supports Unicode characters for international names.
 * 
 * @param string $firstname First name to validate
 * @return bool True if invalid, false if valid
 */
function is_name_invalid(string $firstname): bool {
    if (!preg_match("/^[\p{L}\s'-]+$/u", $firstname)) {
        return true;
    }
    return false;
}

/**
 * Validates surname format
 * 
 * Checks if surname contains only letters, spaces, hyphens, and apostrophes.
 * Supports Unicode characters for international names.
 * 
 * @param string $surname Surname to validate
 * @return bool True if invalid, false if valid
 */
function is_surname_invalid(string $surname): bool {
    if (!preg_match("/^[\p{L}\s'-]+$/u", $surname)) {
        return true;
    }
    return false;
}



