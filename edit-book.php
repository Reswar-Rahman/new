<?php
session_start();
include 'db.php'; // Include the database connection

// Redirect to login if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Get the book id from URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the book details from the database
    $stmt = $conn->prepare("SELECT title, author, genre, isbn FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($title, $author, $genre, $isbn);
    $stmt->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_title = $_POST['title'];
        $new_author = $_POST['author'];
        $new_genre = $_POST['genre'];
        $new_isbn = $_POST['isbn'];

        // Update book details in the database
        $update_stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, genre = ?, isbn = ? WHERE id = ?");
        $update_stmt->bind_param("ssssi", $new_title, $new_author, $new_genre, $new_isbn, $book_id);
        if ($update_stmt->execute()) {
            header("Location: manage-books.php"); // Redirect to the manage books page after update
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error updating book.</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>Book not found.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="manage-books.php">Manage Books</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Edit Book Form -->
<div class="container mt-4">
    <h2>Edit Book</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($genre); ?>" required>
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
s