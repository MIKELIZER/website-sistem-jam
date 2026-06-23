<?php
$host = '127.0.0.1';
$port = '5432';
$user = 'postgres';
$password = '1234';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE watch_store");
    echo "Database created successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
