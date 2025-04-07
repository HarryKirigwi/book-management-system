<?php
// config/database.php

// Function to load .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        die("Error: .env file not found at $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        list($key, $value) = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
    }
}

// Load environment variables from .env
loadEnv(__DIR__ . '/../.env');

// Retrieve database configuration from environment variables
$dbConfig = [
    'host'     => getenv('DB_HOST'),
    'port'     => getenv('DB_PORT'),
    'dbname'   => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
];

$dsn = "pgsql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']}";

try {
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("PostgreSQL connection failed: " . $e->getMessage());
}

return $pdo;
