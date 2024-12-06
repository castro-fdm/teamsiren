<?php
    // Include database connection
    include 'db.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and retrieve the form input values
        $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $duration = (int) $_POST['duration'];
        $price = (float) $_POST['price'];

        // Insert the new service into the database
        $sql = "INSERT INTO Services (service_name, description, duration, price) 
                VALUES ('$service_name', '$description', $duration, $price)";

        if ($conn->query($sql) === TRUE) {
            header("Location: admin-dashboard.php?category=Services");
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
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
            <li><a href="signUp.html" style="margin-right: 40px;">Logout</a></li>
        </ul>
    </section>

    <section id="main">
        <div class="info-category">
            <div class="category-title">
                <h2>Add Service</h2>
            </div>
            <form action="addService.php" method="POST">
                <div class="form-group">
                    <label for="service_name">Service Name:</label>
                    <input type="text" id="service_name" name="service_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="duration">Duration (in minutes):</label>
                    <input type="number" id="duration" name="duration" min="1" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <button type="submit">Add Service</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
