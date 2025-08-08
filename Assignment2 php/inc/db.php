<?php
function getConnection() {
    $host = '172.31.22.43';
    $db   = 'Sukhmanpreet200625700';
    $user = 'Sukhmanpreet200625700';
    $pass = 'E2JaQre62E';

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>

