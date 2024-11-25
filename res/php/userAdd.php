<?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../php/db.php'; // Connects to database

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize user input
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $role = $conn->real_escape_string($_POST['role']);

        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT * FROM Users WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            // If email already exists, redirect to the form with an error message
            echo "The email '$email' is already taken. Please choose a different email.";
        } else {
            // If email is not taken, insert the new user
            $sql = "INSERT INTO Users (full_name, email, phone_number, password, role) 
                    VALUES ('$full_name', '$email', '$phone_number', '$password', '$role')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully"; 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>
