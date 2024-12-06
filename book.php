<?php
    session_start();
    include 'db.php';

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit("You must log in to book an appointment.");
    }

    // Fetch the available services and therapists
    $service_id = $_GET['service_id'] ?? null; // Assuming the service_id is passed as a GET parameter
    $service = null;
    if ($service_id) {
        $stmt = $conn->prepare("SELECT * FROM Services WHERE service_id = ?");
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $service = $stmt->get_result()->fetch_assoc();
    }

    // Fetch therapists
    $therapists = [];
    $stmt = $conn->prepare("SELECT * FROM Users WHERE role = 'therapist'");
    $stmt->execute();
    $therapists = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/res/css/dash_styles.css">
    <script defer src="dash_scripts.js"></script>
    <title>Book Appointment</title>
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
    </style>

    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="index.php" style="text-decoration: none; color: #fff;"><h1>The Spa</h1></a>
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

    <!-- Main content -->
    <main>
        <div class="booking-steps">
            <h2>Book Your Appointment</h2>
            <form action="submit-appointment.php" method="POST">
                <!-- Display the chosen service -->
                <?php if ($service): ?>
                    <div class="chosen-service">
                        <h3>Chosen Service: <?= htmlspecialchars($service['service_name']) ?></h3>
                        <p><?= htmlspecialchars($service['description']) ?></p>
                    </div>
                <?php else: ?>
                    <p>No service selected.</p>
                <?php endif; ?>

                <h2>1. Choose a Therapist</h2>
                <div class="therapist-selection">
                    <?php foreach ($therapists as $therapist): ?>
                        <button type="button" class="therapist-btn" data-therapist-id="<?= $therapist['user_id'] ?>">
                            <?= htmlspecialchars($therapist['username']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <h2>2. Choose a Schedule</h2>
                <div class="schedule-selection">
                    <!-- Date Picker for appointment date -->
                    <label for="appointment_date">Choose Appointment Date:</label>
                    <input type="date" id="appointment_date" name="appointment_date" required>

                    <!-- Time Picker for start time -->
                    <label for="start_time">Choose Start Time:</label>
                    <input type="time" id="start_time" name="start_time" required>

                    <!-- Time Picker for end time -->
                    <label for="end_time">Choose End Time:</label>
                    <input type="time" id="end_time" name="end_time" required>
                </div>
                <div class="continue-button">
                    <input type="hidden" name="service_id" value="<?= $service_id ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                    <input type="hidden" name="therapist_id" id="therapist_id" required>
                    <button class="book-btn" type="submit">
                        Continue to Date & Time
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        // JavaScript to handle therapist selection
        document.querySelectorAll('.therapist-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Store the therapist ID in the hidden input
                const therapistId = this.getAttribute('data-therapist-id');
                document.getElementById('therapist_id').value = therapistId;

                // Highlight the selected therapist (optional, for UX)
                document.querySelectorAll('.therapist-btn').forEach(btn => btn.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Form validation to ensure end time is later than start time
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;

            if (startTime >= endTime) {
                alert('End time must be later than start time.');
                event.preventDefault();  // Prevent form submission
            }
        });
    </script>
    <!-- Footer -->
    <footer>
        <p>2024 Therapeutic Spa Center. All rights reserved.</p>
    </footer>
</body>
</html>
