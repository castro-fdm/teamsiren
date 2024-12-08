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
        $role = trim($_POST['role']);  // Ensure the role is passed correctly

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
            // Get the last inserted user_id
            $user_id = $stmt->insert_id;

            if ($role === 'customer') {
                // Additional logic for customers can be added here if needed
                // Currently, just redirect after successful registration
                header("Location: signup.php?success=1");
            } elseif ($role === 'therapist') {
                // Handle therapist-specific logic
                if (isset($_POST['availability_date']) && isset($_POST['start_time']) && isset($_POST['end_time'])) {
                    $availability_date = trim($_POST['availability_date']);
                    $start_time = trim($_POST['start_time']);
                    $end_time = trim($_POST['end_time']);
                    
                    // Insert availability into Availability table
                    $availabilityQuery = "INSERT INTO Availability (therapist_id, date, start_time, end_time) VALUES (?, ?, ?, ?)";
                    $stmtAvailability = $conn->prepare($availabilityQuery);
                    $stmtAvailability->bind_param('isss', $user_id, $availability_date, $start_time, $end_time);
                    
                    if (!$stmtAvailability->execute()) {
                        // Handle failure in inserting availability
                        header("Location: signup.php?error=Failed to add therapist availability");
                        exit();
                    }
                    $stmtAvailability->close();
                } else {
                    // Redirect if availability data is not provided
                    header("Location: signup.php?error=Availability data missing");
                    exit();
                }
            }

            // Redirect to signup page with success message
            header("Location: signup.php?success=1");
        } else {
            // Registration failed
            header("Location: signup.php?error=Failed to register user");
        }

        // Close the statements and connection
        $stmt->close();
        $conn->close();
    } else {
        header("Location: signup.php?error=Invalid request method");
    }
    exit();
?>
