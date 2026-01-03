<?php
/**
 * User Model - Shared Functions
 * 
 * Contains shared database functions for user-related operations
 * used across multiple modules in the application.
 * 
 * @package NestlyHomes
 * @subpackage Models
 */

declare(strict_types=1);

/**
 * Checks if a user has administrator privileges
 * 
 * Queries the database to determine if the specified user
 * has the 'admin' role assigned.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId The ID of the user to check
 * @return bool True if user is an admin, false otherwise
 */
function is_user_admin(object $pdo, int $userId): bool {
    $query = "SELECT role FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result && $result['role'] === 'admin';
}
