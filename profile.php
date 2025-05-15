<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include 'db.php';  // Include the database connection

// Fetch user data (username, email, etc.)
$user_id = $_SESSION['user_id'];

// Fetch current user data from the database
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
if ($stmt === false) {
    // If query preparation fails, print an error message
    die('Error in query preparation: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $email);
$stmt->fetch();

// Handle form submission to update email
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];

    // Update the email in the database
    $update_stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    if ($update_stmt === false) {
        die('Error in query preparation: ' . $conn->error);
    }

    $update_stmt->bind_param("si", $new_email, $user_id);

    if ($update_stmt->execute()) {
        // Successfully updated
        echo "<div class='alert alert-success'>Email updated successfully!</div>";
        // Reload the page to reflect the changes
        header("Refresh: 2; url=profile.php");
    } else {
        echo "<div class='alert alert-danger'>Error updating email. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
          <a class="nav-link active" href="profile.php">Profile</a>
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

<!-- Profile Info -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Profile</h2>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
