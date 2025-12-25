<?php
declare(strict_types=1);

function is_user_admin(object $pdo, int $userId): bool {
    $query = "SELECT role FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result && $result['role'] === 'admin';
}
