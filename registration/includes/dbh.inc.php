<?php

$dsn = "mysql:host=localhost;dbname=shcheiva";
$dbusername = "shcheiva";
$dbpassword = "webove aplikace";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}