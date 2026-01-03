<?php
/**
 * Change Password Model
 * 
 * Contains database functions for password management.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Retrieves user's current password hash
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID
 * @return string The hashed password
 */
function get_pwd(object $pdo, int $userId): string {
    $query = "SELECT pwd FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['pwd'];
}

/**
 * Updates user's password
 * 
 * Hashes the new password using bcrypt and stores it.
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to update
 * @param string $newPassword New plaintext password to hash and store
 * @return void
 */
function update_user_password(object $pdo, int $userId, string $newPassword): void {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $query = "UPDATE users SET pwd = :pwd WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':pwd', $hashedPassword);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
}