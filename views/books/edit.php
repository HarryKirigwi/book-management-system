<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../includes/book_functions.php';

if (!isLoggedIn()) {
    header("Location: /views/auth/login.php");
    exit;
}

$bookId = $_GET['book_id'] ?? '';
if (!$bookId) {
    header("Location: /views/dashboard.php?error=No book ID provided");
    exit;
}

$book = getBookById($pdo, getUserId(), $bookId);
if (!$book) {
    header("Location: /views/dashboard.php?error=Book not found or not yours");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($_GET['success'])): ?>
        <meta http-equiv="refresh" content="2;url=/views/dashboard.php">
    <?php endif; ?>
    <title>Edit Book - Book Management System</title>
    <link rel="stylesheet" href="/assets/css/edit-book.css">
    <link rel="stylesheet" href="/assets/css/popup.css">
</head>
<body>
    <div class="edit-container">
        <header class="edit-header">
            <h1>Edit Book</h1>
            <a href="/views/dashboard.php" class="btn btn-back">Back to Dashboard</a>
        </header>
        
        <main class="edit-main">
            <section class="edit-form-section">
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="success-popup">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php else: ?>
                    <form action="/controllers/book_controller.php?action=edit" method="POST" class="edit-form">
                        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="year_of_publish">Year of Publication</label>
                            <input type="number" id="year_of_publish" name="year_of_publish" 
                                   value="<?php echo htmlspecialchars($book['year_of_publish']); ?>" 
                                   min="1000" max="<?php echo date('Y'); ?>" step="1">
                        </div>
                        <div class="form-group">
                            <label for="recommendations">Recommendations</label>
                            <textarea id="recommendations" name="recommendations" rows="4"><?php echo htmlspecialchars($book['recommendations']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-submit">Update Book</button>
                    </form>
                <?php endif; ?>
            </section>
        </main>
        
        <footer class="footer">
            <p>Book Management System © <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>
