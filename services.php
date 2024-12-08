<?php
    session_start();
    include 'db.php'; // Ensure db.php contains your database connection

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    } elseif ($_SESSION['role'] == 'therapist') {
        echo "<script>
                alert('You are not authorized to access this page.');
                window.location.href = 'index.php'; // Redirect to the profile page
            </script>";
        exit();
    }

    // Fetch services based on price range filter
    $minPrice = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? intval($_GET['min_price']) : 0;
    $maxPrice = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? intval($_GET['max_price']) : 10000;

    $query = "SELECT * FROM Services WHERE price BETWEEN $minPrice AND $maxPrice";
    $result = $conn->query($query);

    // Check if services were found
    $services = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
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

        #services-section {
            display: flex;
            padding: 20px;
        }

        .sidebar {
            width: 250px;
            background: #fff;
            padding: 20px;
            margin-right: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar form label {
            display: block;
            margin: 10px 0 5px;
        }

        .sidebar form input {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .sidebar form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }

        .services-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            flex-grow: 1;
        }

        .service-item {
            width: 300px;
            background: white;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .service-item h3 {
            margin: 10px 0;
        }

        .service-item p {
            margin: 5px 0;
        }

        .btn-book-now {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .services-title {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .card-section {
            flex-grow: 1;
        }

        /* Add slider-specific styles */
        .slider-container {
            width: calc(100% - 20px);
            margin-top: 20px;
        }

        .slider-label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        .price-range {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        #price-slider {
            width: 100%;
            -webkit-appearance: none;
            appearance: none;
            height: 8px;
            background: #ddd;
            border-radius: 5px;
            outline: none;
            cursor: pointer;
        }

        #price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #4CAF50;
            border-radius: 50%;
            cursor: pointer;
        }

        #price-slider::-moz-range-thumb {
            width: 16px;
            height: 16px;
            background: #4CAF50;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body>
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
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Filter by Price</h3>
            <form method="GET" action="services.php" id="price-form">
                <div class="slider-container">
                    <label for="price-slider" class="slider-label">Select Price Range:</label>
                    <input type="range" id="price-slider" name="max_price" min="0" max="10000" step="500" value="<?= htmlspecialchars($maxPrice) ?>" 
                           oninput="updatePriceDisplay(this.value)">
                    <div class="price-range">
                        <span>₱0</span>
                        <span id="price-display">₱<?= htmlspecialchars($maxPrice) ?></span>
                    </div>
                </div>
                <input type="hidden" name="min_price" value="0">
                <button type="submit">Apply Filters</button>
            </form>
        </div>
        <div class="card-section">
            <div class="services-title">
                <h1>Our Services</h1>
            </div>
            <div class="services-card">
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <div class="service-item">
                            <h3><?= htmlspecialchars($service['service_name']) ?></h3>
                            <p><?= htmlspecialchars($service['description']) ?></p>
                            <p>Duration: <?= htmlspecialchars($service['duration']) ?> mins</p>
                            <p>Price: ₱<?= number_format($service['price'], 2) ?></p>
                            <a href="book.php?service_id=<?= $service['service_id'] ?>" class="btn-book-now">Book Now</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No services available within the selected price range.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <script>
        function updatePriceDisplay(value) {
            document.getElementById('price-display').textContent = `₱${value}`;
        }
    </script>
</body>
</html>
