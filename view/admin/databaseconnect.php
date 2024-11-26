<?php
// databaseconnect.php

// Database connection settings
$host = 'localhost';  // Database host
$db = 'villain';      // Database name
$user = 'root';       // Database username
$pass = '';           // Database password

try {
    // Create a new PDO instance with charset set to UTF-8
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);

    // Set PDO attributes for error handling and fetch mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Log error to a file for debugging
    file_put_contents('db_errors.log', date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", FILE_APPEND);

    // Show a generic error message to the user
    echo 'Database connection error. Please try again later.';
    exit;
}
