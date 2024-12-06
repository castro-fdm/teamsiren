<?php
    // Include database connection
    include 'db.php';

    // Check if the user is logged in and is an admin
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: login.php");
        exit("Access denied");
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
        $role = $_POST['role'];
        $phone_number = $_POST['phone_number'];

        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM Users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email); // Bind the email parameter
        $stmt->execute();
        $stmt->store_result(); // Store the result so we can check row count
        $rowCount = $stmt->num_rows;

        if ($rowCount > 0) {
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
        } else {
            // Prepare SQL statement to insert user data
            $sql = "INSERT INTO Users (username, email, phone_number, password, role) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $username, $email, $phone_number, $password, $role); // Bind all parameters
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: admin-dashboard.php?category=Users");
                exit();
            } else {
                echo "<script>alert('Failed to add user. Please try again.');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>
<style>
        * {
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        section[id="navbar"] {
            display: flex;
            align-items: center;
            position: fixed;
            width: 100%;
            height: 50px;
            background-color: #333;
            z-index: 1;

        }

        section[id="navbar"] ul {
            list-style: none;
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin: 10px;
        }

        section[id="navbar"] a {
            color: white;
            text-decoration: none;
        }

        section[id="main"] {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 50px);
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #navbar {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        #navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        #navbar ul li {
            display: inline;
            margin-right: 20px;
        }

        #navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        #navbar ul li a:hover {
            text-decoration: underline;
        }

        #main {
            display: flex;
            justify-content: center;
            padding: 30px;
        }

        .info-category {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 50%;
            margin: 20px;
        }

        .category-title h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 100%;
            max-width: calc(100% - 20px);
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
        }

        .form-group input, .form-group textarea {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .form-group button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        p {
            font-size: 14px;
            color: #333;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    
    </style>
    <section id="navbar">
        <ul>
            <li><a href="admin-dashboard.php">Admin</a></li>
            <li><a href="login.php" style="margin-right: 40px;">Logout</a></li>
        </ul>
    </section>
    <section id="main">
        <div class="info-category">
            <div class="category-title">
                <h2>Add New User</h2>
            </div>
            <form action="addUser.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="customer">Customer</option>
                        <option value="therapist">Therapist</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" required>
                </div>
                <div class="form-group">
                    <button type="submit">Add User</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
