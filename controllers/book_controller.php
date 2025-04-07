<?php
// controllers/book_controller.php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../includes/book_functions.php';

$action = $_GET['action'] ?? '';

if (!isLoggedIn()) {
    header("Location: /views/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $year = $_POST['year_of_publish'] ?? '';
        $recommendations = $_POST['recommendations'] ?? '';

        if (empty($title) || empty($author)) {
            header("Location: /views/books/add.php?error=Title and Author are required");
            exit;
        }

        if (addBook($pdo, getUserId(), $title, $author, $year, $recommendations)) {
            // Redirect to add.php with success message
            header("Location: /views/books/add.php?success=Book added successfully");
            exit;
        } else {
            header("Location: /views/books/add.php?error=Failed to add book");
            exit;
        }
    } elseif ($action === 'edit') {
        $bookId = $_POST['book_id'] ?? '';
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $year = $_POST['year_of_publish'] ?? '';
        $recommendations = $_POST['recommendations'] ?? '';

        if (empty($bookId) || empty($title) || empty($author)) {
            header("Location: /views/books/edit.php?book_id=$bookId&error=Book ID, Title, and Author are required");
            exit;
        }

        if (updateBook($pdo, getUserId(), $bookId, $title, $author, $year, $recommendations)) {
            // Redirect to edit.php with success message
            header("Location: /views/books/edit.php?book_id=$bookId&success=Book updated successfully");
            exit;
        } else {
            header("Location: /views/books/edit.php?book_id=$bookId&error=Failed to update book");
            exit;
        }
    }
} elseif ($action === 'delete') {
    $bookId = $_GET['id'] ?? '';
    if (empty($bookId)) {
        header("Location: /views/dashboard.php?error=No book ID provided");
        exit;
    }

    if (deleteBook($pdo, getUserId(), $bookId)) {
        // Redirect to dashboard.php with success message
        header("Location: /views/dashboard.php?success=Book deleted successfully");
        exit;
    } else {
        header("Location: /views/dashboard.php?error=Failed to delete book");
        exit;
    }
}

// If no valid action is provided, redirect to dashboard with an error
header("Location: /views/dashboard.php?error=Invalid action");
exit;
