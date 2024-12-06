<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'db.php'; // Include the database connection

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $password = trim($_POST['password']);
        $role = trim($_POST['role']);

        // Check if email or username already exists
        $checkQuery = "SELECT * FROM Users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Redirect with error if email or username already exists
            header("Location: signup.php?error=Email or username already exists");
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $insertQuery = "INSERT INTO Users (username, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('sssss', $username, $email, $phone_number, $hashedPassword, $role);

        if ($stmt->execute()) {
            // Redirect to index.php upon successful registration
            header("Location: signup.php?success=1");
        } else {
            header("Location: signup.php?error=Failed to register user");
        }
        $stmt->close();
        $conn->close();
    } else {
        header("Location: signup.php?error=Invalid request method");
    }
    exit();
?>