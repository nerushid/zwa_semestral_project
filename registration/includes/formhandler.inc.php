<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO users (firstname, surname, email, pwd) VALUES (?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$firstname, $surname, $email, $pwd]);
        header("Location: ../../mainpage/index.html");
    } catch(PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../registration.html");
}