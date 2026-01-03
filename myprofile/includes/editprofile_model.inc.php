<?php
/**
 * Edit Profile Model
 * 
 * Contains database functions for profile editing operations.
 * 
 * @package NestlyHomes\Models
 */

declare(strict_types=1);

/**
 * Retrieves email from database
 * 
 * Checks if an email address is already registered.
 * 
 * @param object $pdo PDO database connection instance
 * @param string $email Email address to check
 * @return array Array of matching records (empty if not found)
 */
function get_email(object $pdo, string $email): array {
    $query = 'SELECT email FROM users WHERE email = :email';
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * Updates user profile information
 * 
 * @param object $pdo PDO database connection instance
 * @param int $userId User ID to update
 * @param string $firstName New first name
 * @param string $surname New surname
 * @param string $email New email address
 * @return void
 */
function update_user_profile(object $pdo, int $userId, string $firstName, string $surname, string $email): void {
    $query = "UPDATE users SET firstname = :firstName, surname = :surname, email = :email WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
}