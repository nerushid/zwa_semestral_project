<?php
declare(strict_types=1);

function delete_user(object $pdo, int $userId) {
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
}