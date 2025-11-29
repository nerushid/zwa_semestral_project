<?php
declare(strict_types=1);

function get_pwd(object $pdo, int $userId) {
    $query = "SELECT pwd FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['pwd'];
}

function update_user_password(object $pdo, int $userId, string $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $query = "UPDATE users SET pwd = :pwd WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':pwd', $hashedPassword);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
}