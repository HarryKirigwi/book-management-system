<?php
// includes/auth_functions.php

function registerUser($pdo, $username, $email, $password) {
    try {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare and execute the insert statement
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $success = $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
        
        return $success; // Returns true on success, false on failure
    } catch (PDOException $e) {
        // Log the error for debugging
        error_log("Registration failed: " . $e->getMessage());
        
        // Return false to indicate failure
        return false;
    }
}

function loginUser($pdo, $username, $password) {
    try {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Login failed: " . $e->getMessage());
        return false;
    }
}

function logoutUser() {
    session_unset();
    session_destroy();
    return true; // Indicate successful logout
}
