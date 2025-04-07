<?php

// Start the session
session_start();

// Include database connection
$pdo = require_once __DIR__ . '/database.php';

// Define base path constant
define('BASE_PATH', __DIR__ . '/..');

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to get current user ID
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}
