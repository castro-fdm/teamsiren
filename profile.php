<?php
    session_start();
    include 'db.php';

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['role'];  // Assume the role is stored in the session

    // Fetch user profile details
    $sql = "SELECT * FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();

    // Fetch appointments based on user role
    if ($user_role == 'customer') {
        // Fetch the user's appointments
        $sql_appointments = "SELECT a.appointment_id, s.service_name, a.appointment_date, a.start_time, a.end_time, a.status 
                            FROM Appointments a
                            JOIN Services s ON a.service_id = s.service_id
                            WHERE a.user_id = ?";
        $stmt_appointments = $conn->prepare($sql_appointments);
        $stmt_appointments->bind_param("i", $user_id);
        $stmt_appointments->execute();
        $appointments_result = $stmt_appointments->get_result();
    } elseif ($user_role == 'therapist') {
        // Fetch upcoming appointments for the therapist
        $sql_appointments = "SELECT a.appointment_id, u.username, s.service_name, a.appointment_date, a.start_time, a.end_time, a.status
                            FROM Appointments a
                            JOIN Users u ON a.user_id = u.user_id
                            JOIN Services s ON a.service_id = s.service_id
                            WHERE a.therapist_id = ? AND a.appointment_date >= CURDATE()";
        $stmt_appointments = $conn->prepare($sql_appointments);
        $stmt_appointments->bind_param("i", $user_id);
        $stmt_appointments->execute();
        $appointments_result = $stmt_appointments->get_result();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/res/css/dash_styles.css">
    <title>User Profile</title>
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

        /* Profile Page Styles */
        .profile-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            font-size: 2rem;
            color: #4CAF50;
            text-align: center;
        }

        .account-details {
            margin-bottom: 30px;
        }

        .account-details h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .account-details form {
            display: flex;
            flex-direction: column;
        }

        .account-details label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .account-details input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .account-details button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .account-details button:hover {
            background-color: #45a049;
        }

        /* Appointments Table */
        .appointments {
            margin-top: 40px;
        }

        .appointments h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .appointments table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .appointments th, .appointments td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .appointments th {
            background-color: #f4f4f4;
        }

        .appointments tr:hover {
            background-color: #f9f9f9;
        }

        .appointments select, .appointments button {
            padding: 8px;
            font-size: 1rem;
            border-radius: 4px;
        }

        .appointments select {
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .appointments button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .appointments button:hover {
            background-color: #45a049;
        }

        /* Footer */
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            bottom: 0;
            width: 100%;
        }
    </style>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="index.php" style="text-decoration: none; color: #fff;"><h1>The Spa-la-la-la</h1></a>
            <nav class="nav-links">
                <?php if ($user_role === 'customer'): ?>
                    <a href="services.php">Services</a>
                <?php else: $user_role === 'therapist'; ?>
                    <p></p>
                <?php endif; ?>
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
        <div class="profile-container">
            <h2>Welcome, <?= htmlspecialchars($user['username']) ?>!</h2>

            <!-- User account details for editing -->
            <div class="account-details">
                <h3>Account Details</h3>
                <form action="update-profile.php" method="POST">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

                    <label for="phone">Phone</label>
                    <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" required>

                    <button type="submit" class="update-btn">Update Profile</button>
                </form>
            </div>

            <!-- Display user appointments for customer -->
            <?php if ($user_role == 'customer'): ?>
                <div class="appointments">
                    <h3>Your Appointments</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                                    <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                    <td><?= htmlspecialchars($appointment['start_time']) ?></td>
                                    <td><?= htmlspecialchars($appointment['end_time']) ?></td>
                                    <td><?= htmlspecialchars($appointment['status']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Display therapist's upcoming appointments -->
            <?php if ($user_role == 'therapist'): ?>
                <div class="appointments">
                    <h3>Upcoming Appointments</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appointment['username']) ?></td>
                                    <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                                    <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                    <td><?= htmlspecialchars($appointment['start_time']) ?></td>
                                    <td><?= htmlspecialchars($appointment['end_time']) ?></td>
                                    <td><?= htmlspecialchars($appointment['status']) ?></td>
                                    <td>
                                        <form action="update-appointment-status.php" method="POST">
                                            <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                                            <select name="status" required>
                                                <option value="pending" <?= $appointment['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="confirmed" <?= $appointment['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                <option value="canceled" <?= $appointment['status'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                                            </select>
                                            <button type="submit" class="update-btn">Update Status</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p> 2024 Therapeutic Spa Center. All rights reserved.</p>
    </footer>
</body>
</html>