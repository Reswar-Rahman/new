<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// You can retrieve user details from the database here if needed
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
          <a class="nav-link active" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage-books.php">Manage Books</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar (optional) -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
                <a href="manage-books.php" class="list-group-item list-group-item-action">Manage Books</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p class="card-text">This is your dashboard. You can manage books, view settings, and more!</p>
                    <a href="manage-books.php" class="btn btn-primary">Manage Books</a>
                </div>
            </div>

            <!-- Example of Recent Activity (optional) -->
            <div class="mt-4">
                <h3>Recent Activity</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Activity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Book Added</td>
                            <td>2025-05-11</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Book Edited</td>
                            <td>2025-05-10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
