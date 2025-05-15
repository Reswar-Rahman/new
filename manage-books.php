<?php
session_start();
include 'db.php'; // Include the database connection

// Redirect to login if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Fetch all books from the database
$stmt = $conn->prepare("SELECT id, title, author, genre, isbn FROM books");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $title, $author, $genre, $isbn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
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
          <a class="nav-link" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="manage-books.php">Manage Books</a>
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

<!-- Manage Books Section -->
<div class="container mt-4">
    <h2>Manage Books</h2>
    <a href="add-book.php" class="btn btn-primary mb-3">Add New Book</a>

    <!-- Books Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>ISBN</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($title); ?></td>
                    <td><?php echo htmlspecialchars($author); ?></td>
                    <td><?php echo htmlspecialchars($genre); ?></td>
                    <td><?php echo htmlspecialchars($isbn); ?></td>
                    <td>
                        <!-- Edit button -->
                        <a href="edit-book.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <!-- Delete button -->
                        <a href="manage-books.php?delete=<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Handle delete action
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];

    // Delete the book from the database
    $delete_stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $delete_stmt->bind_param("i", $book_id);
    if ($delete_stmt->execute()) {
        header("Location: manage-books.php"); // Redirect to the same page to refresh the list
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error deleting book.</div>";
    }
}
?>
