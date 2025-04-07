<?php
// includes/book_functions.php

function addBook($pdo, $userId, $title, $author, $year, $recommendations) {
    $stmt = $pdo->prepare("
        INSERT INTO books (user_id, title, author, year_of_publish, recommendations)
        VALUES (?, ?, ?, ?, ?)
    ");
    return $stmt->execute([$userId, $title, $author, $year, $recommendations]);
}

function getBookById($pdo, $userId, $bookId) {
    $stmt = $pdo->prepare("
        SELECT id, title, author, year_of_publish, recommendations
        FROM books
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$bookId, $userId]);
    return $stmt->fetch();
}

function updateBook($pdo, $userId, $bookId, $title, $author, $year, $recommendations) {
    $stmt = $pdo->prepare("
        UPDATE books
        SET title = ?, author = ?, year_of_publish = ?, recommendations = ?
        WHERE id = ? AND user_id = ?
    ");
    return $stmt->execute([$title, $author, $year, $recommendations, $bookId, $userId]);
}

function deleteBook($pdo, $userId, $bookId) {
    $stmt = $pdo->prepare("
        DELETE FROM books
        WHERE id = ? AND user_id = ?
    ");
    return $stmt->execute([$bookId, $userId]);
}
