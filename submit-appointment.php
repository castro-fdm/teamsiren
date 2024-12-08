<?php
    session_start();
    include 'db.php';

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit("You must be logged in to book an appointment.");
    }

    // Get the submitted form data
    $user_id = $_POST['user_id'];
    $service_id = $_POST['service_id'];
    $therapist_id = $_POST['therapist_id'];
    $availability_id = $_POST['availability_id'];

    // Get the details of the selected availability
    $stmt = $conn->prepare("SELECT * FROM Availability WHERE availability_id = ?");
    $stmt->bind_param("i", $availability_id);
    $stmt->execute();
    $availability = $stmt->get_result()->fetch_assoc();

    if ($availability) {
        // Get the start time and end time from the availability
        $appointment_date = $availability['date'];
        $start_time = $availability['start_time'];
        $end_time = $availability['end_time'];

        // Insert the new appointment into the database
        $stmt = $conn->prepare("INSERT INTO Appointments (user_id, therapist_id, service_id, appointment_date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("iiisss", $user_id, $therapist_id, $service_id, $appointment_date, $start_time, $end_time);
        if ($stmt->execute()) {
            header("Location: profile.php");  // Redirect to confirmation page
            exit();
        } else {
            echo "Error booking appointment.";
        }
    } else {
        echo "Invalid time slot selected.";
    }
?>
