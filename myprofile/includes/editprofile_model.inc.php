<?php
declare(strict_types = 1);

function get_email(object $pdo, string $email) {
    $query = 'SELECT email FROM users WHERE email = :email';
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function update_user_profile(object $pdo, int $userId, string $firstName, string $surname, string $email) {
    $query = "UPDATE users SET firstname = :firstName, surname = :surname, email = :email WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
}