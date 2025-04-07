<?php
// controllers/auth_controller.php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../includes/auth_functions.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                header("Location: /views/auth/login.php?error=Username and password are required");
                exit;
            }

            if (loginUser($pdo, $username, $password)) {
                header("Location: /views/dashboard.php");
                exit;
            } else {
                header("Location: /views/auth/login.php?error=Invalid username or password");
                exit;
            }
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                header("Location: /views/auth/register.php?error=All fields are required");
                exit;
            }

            if ($password !== $confirm_password) {
                header("Location: /views/auth/register.php?error=Passwords do not match");
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: /views/auth/register.php?error=Invalid email format");
                exit;
            }

            if (registerUser($pdo, $username, $email, $password)) {
                header("Location: /views/auth/login.php?success=Registration successful! Please login.");
                exit;
            } else {
                // Check for specific error (e.g., duplicate) by querying the database
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
                $stmt->execute([':username' => $username, ':email' => $email]);
                if ($stmt->fetchColumn() > 0) {
                    header("Location: /views/auth/register.php?error=Username or email already exists");
                } else {
                    header("Location: /views/auth/register.php?error=Registration failed");
                }
                exit;
            }
        }
        break;

    case 'logout':
        logoutUser();
        header("Location: /views/auth/login.php");
        exit;

    default:
        header("Location: /views/auth/login.php?error=Invalid action");
        exit;
} 
