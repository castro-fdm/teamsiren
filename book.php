<?php
    session_start();
    include 'db.php';

    // Fetch the available services and therapists
    $service_id = $_GET['service_id'] ?? null;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <div id="availability-section">
                    <p>Select a therapist to view their available time slots.</p>
                </div>

                <h2>3. Submit your Appointment</h2>
                <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                <!-- Hidden fields for therapist and availability -->
                <input type="hidden" name="therapist_id" id="therapist-id">
                <input type="hidden" name="availability_id" id="availability-id">

                <button type="submit">Book Appointment</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 The Spa-la-la-la. All rights reserved.</p>
    </footer>

    <script>
        // Handle therapist selection with AJAX
        $(document).on('click', '.therapist-btn', function() {
            var therapistId = $(this).data('therapist-id');
            
            // Set the therapist_id hidden field value
            $('#therapist-id').val(therapistId);

            // Make an AJAX call to get the availability for the selected therapist
            $.ajax({
                url: 'fetch-availability.php',
                method: 'GET',
                data: { therapist_id: therapistId },
                success: function(response) {
                    // Display the availability of the therapist
                    $('#availability-section').html(response);
                }
            });
        });

        // Handle time slot selection
        $(document).on('change', 'input[name="appointment_time"]', function() {
            var availabilityId = $(this).val();
            
            // Set the availability_id hidden field value
            $('#availability-id').val(availabilityId);
        });
    </script>
</body>
</html>