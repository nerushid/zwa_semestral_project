<?php

declare(strict_types=1);

function get_email(object $pdo, string $email) {
    $query = 'SELECT email FROM users WHERE email = :email';
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $firstName, string $surname, string $email, string $pwd) {
    $query = 'INSERT INTO users (firstName, surname, email, pwd) VALUES (:firstName, :surname, :email, :pwd);';
    $stmt = $pdo->prepare($query);
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pwd', $hashedPwd);
    $stmt->execute();
}