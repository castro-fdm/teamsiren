<?php
    session_start();
    include 'db.php';

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit("You must log in to book an appointment.");
    }

    // Check if form data is received
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $therapist_id = $_POST['therapist_id'];  // This should be passed from book.php when selecting a therapist
        $appointment_date = $_POST['appointment_date'];  // Date selected for the appointment
        $start_time = $_POST['start_time'];  // Start time of the appointment
        $end_time = $_POST['end_time'];  // End time of the appointment

        // Validate required fields
        if (empty($user_id) || empty($service_id) || empty($therapist_id) || empty($appointment_date) || empty($start_time) || empty($end_time)) {
            die("All fields are required.");
        }

        // Prepare SQL statement to insert appointment
        $sql = "INSERT INTO Appointments (user_id, therapist_id, service_id, appointment_date, start_time, end_time, status)
                VALUES (?, ?, ?, ?, ?, ?, 'pending')";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iiisss", $user_id, $therapist_id, $service_id, $appointment_date, $start_time, $end_time);
            
            if ($stmt->execute()) {
                // Appointment successfully created
                echo "<script>
                        alert('Appointment booked successfully!');
                        window.location.href = 'profile.php'; // Redirect to profile or another page
                    </script>";
            } else {
                // Error in execution
                echo "<script>
                        alert('Error booking appointment. Please try again.');
                    </script>";
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
?>
