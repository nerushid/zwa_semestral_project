<?php
/**
 * Database Handler
 * 
 * Establishes PDO connection to MySQL database with secure settings.
 * Configures error mode to throw exceptions and disables emulated prepared statements
 * for true prepared statement support preventing SQL injection.
 * 
 * @package NestlyHomes
 * 
 * @var string $dsn Data Source Name for MySQL connection
 * @var string $dbusername Database username
 * @var string $dbpassword Database password
 * @var PDO $pdo PDO connection instance
 */

$dsn = "mysql:host=localhost;dbname=shcheiva";
$dbusername = "shcheiva";
$dbpassword = "webove aplikace";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}