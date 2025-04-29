<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $book_id = $_POST['delete'];
    $conn->query("DELETE FROM books WHERE book_id = $book_id");

    $check = $conn->query("SELECT COUNT(*) as total FROM books");
    $row = $check->fetch_assoc();
    if ($row['total'] == 0) {
        $conn->query("ALTER TABLE books AUTO_INCREMENT = 1");
    }
}

header("Location: main.php");
exit;
