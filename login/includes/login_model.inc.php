<?php
/**
 * Login Model
 * 
 * Contains database functions for user authentication.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Retrieves user data by email address
 * 
 * Fetches complete user record from database for authentication.
 * Uses prepared statements to prevent SQL injection.
 * 
 * @param object $pdo PDO database connection instance
 * @param string $email User's email address
 * @return array|false User data array if found, false otherwise
 */
function get_user(object $pdo, string $email): array|false {
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

