<?php
    session_start();
    include 'db.php'; // Ensure db.php contains your database connection

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }elseif($_SESSION['role'] == 'therapist') {
        echo "<script>
                alert('You are not authorized to access this page.');
                window.location.href = 'index.php'; // Redirect to the profile page
            </script>";
        exit();
    } elseif ($_SESSION['role'] == 'customer') {
        echo '';
    }

    // Fetch services from the database
    $query = "SELECT * FROM Services";
    $result = $conn->query($query);


    // Check if services were found
    $services = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row; // Store the services in an array
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/res/css/services.css">
    <title>Services</title>
</head>
<body>
    <style>
        /* General Styles */
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            line-height: 1.6;
            background-color: #f7f7f7;
            color: #333;
        }

        h1, h2 {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Header */
        header {
            background-color: #4CAF50;  /* Soft green */
            color: white;
            padding: 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: auto;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
        }

        .nav-links a, li {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            list-style: none;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        /* Services Section */
        #services-section {
            height: 100vh;
            padding: 40px;
            background-color: #f7f7f7;
        }

        .services-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .service-item {
            background-color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .service-item h3 {
            font-size: 1.5rem;
            color: #333;
        }

        .service-item p {
            font-size: 1rem;
            color: #555;
            margin: 10px 0;
        }

        .service-item a {
            text-decoration: none;
        }

        .service-item button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .service-item button:hover {
            background-color: #45a049;
        }

        /* Book Now Button Styling */
        .btn-book-now {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }

        .btn-book-now:hover {
            background-color: #45a049;
        }
        /* Footer */
        footer {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="index.php" style="text-decoration: none; color: #fff;"><h1>The Spa-la-la-la</h1></a>
            <nav class="nav-links">
                <a href="#services">Services</a>
                <a href="#feedback">Feedback</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <section id="services-section">
        <h1>Our Services</h1>
        <div class="services-card">
            <?php
            if (!empty($services)) {
                foreach ($services as $service) {
                    echo '<div class="service-item">';
                    echo '<h3>' . htmlspecialchars($service['service_name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($service['description']) . '</p>';
                    echo '<p>Duration: ' . htmlspecialchars($service['duration']) . ' minutes</p>';
                    echo '<p>Price: ₱' . number_format($service['price'], 2) . '</p>';
                    echo '<a href="book.php?service_id=' . $service['service_id'] . '" class="btn-book-now">Book Now</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No services available at the moment.</p>';
            }
            ?>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 The Spa-la-la-la. All rights reserved.</p>
    </footer>
</body>
</html>