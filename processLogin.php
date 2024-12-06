<?php
    // Start the session
    session_start();
    include 'db.php';

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get user inputs
        $role = $_POST['role'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Ensure all fields are filled
        if (empty($role) || empty($username) || empty($password)) {
            header("Location: index.php?error=empty_fields");
            exit;
        }

        // Validate user credentials based on role
        if ($role == 'admin' || $role == 'therapist' || $role == 'user') {
            // Prepare SQL query
            $stmt = $conn->prepare("SELECT user_id, username, password, role FROM Users WHERE username = ?");
            $stmt->bind_param("s", $username);  // Bind username parameter

            // Execute query
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Fetch user data
                $user = $result->fetch_assoc();

                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Store session data
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect to role-specific pages
                    if ($user['role'] == 'admin') {
                        // Check if the user exists and is an admin
                        $stmt = $conn->prepare("SELECT user_id, password, role FROM Users WHERE username = ?");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $stmt->bind_result($id, $hashedPassword, $role);
                        $stmt->fetch();
                        $stmt->close();

                        // Validate credentials and role
                        if ($role === 'admin' && password_verify($password, $hashedPassword)) {
                            // Set session variables
                            $_SESSION['user_id'] = $id;
                            $_SESSION['role'] = $role;

                            // Redirect to the admin dashboard
                            header("Location: admin-dashboard.php");
                            exit();
                        } else {
                            $error = "Invalid admin credentials or not an admin.";
                        }
                    } elseif ($user['role'] == 'therapist') {
                        header("Location: index.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    // Invalid password
                    header("Location: login.php?error=invalid_password");
                    exit;
                }
            } else {
                // User not found
                header("Location: login.php?error=user_not_found");
                exit;
            }

            // Close statement
            $stmt->close();
        } else {
            // Invalid role
            header("Location: index.php?error=invalid_role");
            exit;
        }
    }
?>
