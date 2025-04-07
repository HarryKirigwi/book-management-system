<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../includes/book_functions.php';

if (!isLoggedIn()) {
    header("Location: /views/auth/login.php");
    exit;
}

$userId = getUserId();
$query = $pdo->prepare("SELECT username FROM users WHERE id = :user_id");
$query->execute(['user_id' => $userId]);
$user = $query->fetch();

$booksQuery = $pdo->prepare("SELECT id, title, author FROM books WHERE user_id = :user_id");
$booksQuery->execute(['user_id' => $userId]);
$books = $booksQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($_GET['success'])): ?>
        <meta http-equiv="refresh" content="2;url=/views/dashboard.php">
    <?php endif; ?>
    <title>Dashboard - Book Management System</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/css/popup.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Welcome, <span><?php echo htmlspecialchars($user['username']); ?></span>!</h1>
            <p class="welcome-msg">You are logged in!</p>
            <a href="/controllers/auth_controller.php?action=logout" class="btn btn-logout">Logout</a>
        </header>
        
        <main class="dashboard-main">
            <section class="books-section">
                <div class="books-header">
                    <h2>Your Books</h2>
                    <a href="/views/books/add.php" class="btn btn-add">Add Book</a>
                </div>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="success-popup">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                
                <?php if (count($books) > 0): ?>
                    <div class="books-grid">
                        <?php foreach ($books as $book): ?>
                            <article class="book-card">
                                <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                                <p class="book-author">Author: <?php echo htmlspecialchars($book['author']); ?></p>
                                <div class="book-actions">
                                    <a href="/views/books/edit.php?book_id=<?php echo $book['id']; ?>" class="btn btn-edit">Edit</a>
                                    <a href="/controllers/book_controller.php?action=delete&id=<?php echo $book['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this book?');" 
                                       class="btn btn-delete">Delete</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-books">
                        <p>No books yet. Start building your collection!</p>
                    </div>
                <?php endif; ?>
            </section>
        </main>
        
        <footer class="footer">
            <p>Book Management System © <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html> 
