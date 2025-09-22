<?php
// db.php
 
$host = 'localhost';  // Assuming local setup; replace with actual host if remote (e.g., AWS RDS endpoint)
$db = 'dbokgd4gsauzcl';
$user = 'uws1gwyttyg2r';
$pass = 'k1tdlhq4qpsf';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("SET NAMES utf8mb4");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
