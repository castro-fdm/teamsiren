<?php
    session_start();
    include 'db.php'; // Include database connection
    $currentCategory = $_GET['category'] ?? 'Dashboard'; // Default to Dashboard if no category is specified

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: admin-login.php");
        exit("Access denied");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="res/css/admin.css">
    <script src="res/js/admin.js"></script>
    <title>Admin</title>
</head>
<body>
    <section id="navbar">
        <ul>
            <li><a href="admin-dashboard.php">Admin</a></li>
            <li><a href="login.php" style="margin-right: 40px;">Logout</a></li>
        </ul>
    </section>
    <section id="main">
        <div class="vertical-category">
            <div class="category-title">
                <h2>Utilities</h2>
            </div>
            <ul>
              <div class="category-container">
                <li><a href="#" onclick="displayUsers()">Users</a></li>
              </div>
              <div class="category-container">
                <li><a href="#" onclick="displayServices()">Services</a></li>
              </div>
              <div class="category-container">
                <li><a href="#" onclick="displayAppointments()">Appointments</a></li>
              </div>
              <div class="category-container">
                <li><a href="#" onclick="displayPayments()">Payments</a></li>
              </div>
              <div class="category-container">
                <li><a href="#" onclick="displayAvailability()">Availability</a></li>
              </div>
              <div class="category-container">
                <li><a href="#" onclick="displayReviews()">Reviews</a></li>
              </div>
            </ul>
          </div>
          <div class="info-category">
            <h2>Welcome Admin!</h2>
            <p></p>
          </div>
    </section>
</body>
</html>