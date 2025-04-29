<?php
// Include the database connection
include 'database.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // Get the updated book details from the form
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year_published = $_POST['year_published'];
    $status = $_POST['status'];

    // Prepare the SQL query to update the book details
    $sql = "UPDATE books SET title=?, author=?, genre=?, year_published=?, status=? WHERE book_id=?";
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bind_param("sssisi", $title, $author, $genre, $year_published, $status, $book_id);

    // Execute the query
    if ($stmt->execute()) {
        // If successful, redirect to the main page
        header("Location: main.php");
        exit;
    } else {
        // If there was an error, you could display a message or handle the error
        echo "<script>alert('Error updating book'); window.location.href = 'main.php';</script>";
        exit;
    }
}
?>
