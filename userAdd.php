<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    include 'db.php'; // Include the database connection file

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Check if email or username already exists
        $checkQuery = "SELECT * FROM Users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email or Username already taken
            echo "Email or Username is already taken.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into the database
            $insertQuery = "INSERT INTO Users (username, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param('sssss', $username, $email, $phone_number, $hashedPassword, $role);

            if ($stmt->execute()) {
                echo "User successfully registered!";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
?>
