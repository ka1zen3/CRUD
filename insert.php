<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO books (title, author, genre, year_published, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $_POST['title'], $_POST['author'], $_POST['genre'], $_POST['year_published'], $_POST['status']);
    $stmt->execute();
}

header("Location: main.php");
exit;
