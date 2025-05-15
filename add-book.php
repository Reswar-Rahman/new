<?php
session_start();
include 'db.php'; // Include the database connection

// Redirect to login if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Handle form submission to add a new book
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $isbn = $_POST['isbn'];

    // Prepare the SQL statement to insert the new book into the database
    $stmt = $conn->prepare("INSERT INTO books (title, author, genre, isbn) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $author, $genre, $isbn);

    // Execute the statement and check if the book was added successfully
    if ($stmt->execute()) {
        // Redirect to the manage books page after successfully adding the book
        header("Location: manage-books.php");
        exit;
    } else {
        // If there was an error adding the book, display an error message
        echo "<div class='alert alert-danger'>Error adding book. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
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

<!-- Add New Book Form -->
<div class="container mt-4">
    <h2>Add New Book</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
