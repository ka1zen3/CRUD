<?php
include 'database.php';

// Initialize $edit variable
$edit = false;
$book = [];

// EDIT (preload data) - changed to POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit']) && is_numeric($_POST['edit'])) {
    $edit = true;
    $book_id = $_POST['edit'];
    $result = $conn->query("SELECT * FROM books WHERE book_id=$book_id");

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "<script>alert('Book not found'); window.location.href = 'main.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PLP Library</title>
  <link rel="stylesheet" href="main-style.css" />
 <link rel="icon" type="image/png" href="plp-logo.png">
 <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>
<body>

<div class="welcome-banner">
  <h2>Welcome to the PLP Library Portal</h2>
  <p>Check Availability. Borrow Responsibly. Learn Continuously.</p>
</div>

<div class="container">
  <div class="header">
    <h1>PLP Library Books Management</h1>
  </div>

  <div class="main-wrapper">
    <!-- Form Section -->
    <div class="book-details">
      <form id="book-form" method="POST" action="<?= $edit ? 'update.php' : 'insert.php' ?>">
        <div class="section-heading"><?= $edit ? 'Edit Book' : 'Add Book' ?></div>
        <input type="hidden" name="book_id" value="<?= $edit ? $book['book_id'] : '' ?>">
        <div class="form-grid">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= $edit ? $book['title'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" value="<?= $edit ? $book['author'] : '' ?>" required>
          </div>
          <div class="form-group">
            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
              <option value="" disabled <?= !$edit ? 'selected' : '' ?>>Select Genre</option>
              <option value="fiction" <?= $edit && $book['genre'] == 'fiction' ? 'selected' : '' ?>>Fiction</option>
              <option value="non-fiction" <?= $edit && $book['genre'] == 'non-fiction' ? 'selected' : '' ?>>Non-fiction</option>
              <option value="mystery" <?= $edit && $book['genre'] == 'mystery' ? 'selected' : '' ?>>Mystery</option>
              <option value="fantasy" <?= $edit && $book['genre'] == 'fantasy' ? 'selected' : '' ?>>Fantasy</option>
              <option value="science-fiction" <?= $edit && $book['genre'] == 'science-fiction' ? 'selected' : '' ?>>Science-fiction</option>
              <option value="biography" <?= $edit && $book['genre'] == 'biography' ? 'selected' : '' ?>>Biography</option>
              <option value="history" <?= $edit && $book['genre'] == 'history' ? 'selected' : '' ?>>History</option>
            </select>
          </div>
          <div class="form-group">
            <label for="year_published">Year Published</label>
            <input type="number" id="year_published" name="year_published" value="<?= $edit ? $book['year_published'] : '' ?>" required>
          </div>
          <div class="form-group full-width">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="Available" <?= $edit && $book['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
              <option value="Borrowed" <?= $edit && $book['status'] == 'Borrowed' ? 'selected' : '' ?>>Borrowed</option>
            </select>
          </div>
        </div>

        <div class="button-group">
          <button type="submit" name="save"><?= $edit ? 'Update Book' : 'Save Book' ?></button>
        </div>
      </form>
    </div>

    <!-- Book Table Section -->
    <div class="book-table">
      <div class="section-heading">Stored Books</div>
      <table>
        <thead>
          <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM books");

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['book_id']}</td>
                          <td>{$row['title']}</td>
                          <td>{$row['author']}</td>
                          <td>{$row['genre']}</td>
                          <td>{$row['year_published']}</td>
                          <td>{$row['status']}</td>
                          <td>
                            <form method='POST' action='main.php' style='display:inline'>
                              <input type='hidden' name='edit' value='{$row['book_id']}'>
                              <button type='submit'>Edit</button>
                            </form>
                            |
                            <form method='POST' action='delete.php' style='display:inline' onsubmit='return confirm(\"Delete this book?\")'>
                              <input type='hidden' name='delete' value='{$row['book_id']}'>
                              <button type='submit'>Delete</button>
                            </form>
                          </td>
                      </tr>";
              }
          } else {
              echo "<tr><td colspan='7'>No books found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
