<?php
    session_start();
    include 'db.php'; // Include database connection

    // Ensure the user is logged in and is an admin
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: admin-login.php");
        exit("Access denied");
    }

    // Fetch availability data
    $sql = "SELECT a.availability_id, u.username AS therapist_name, a.date, a.start_time, a.end_time
            FROM Availability a
            JOIN Users u ON a.therapist_id = u.user_id
            ORDER BY a.date, a.start_time";
    
    $result = $conn->query($sql);
    $availability = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $availability[] = $row;
        }
    }

    // Set the Content-Type to JSON and output only the data
    header('Content-Type: application/json');
    echo json_encode($availability);

    // Close the database connection
    $conn->close();
?>
