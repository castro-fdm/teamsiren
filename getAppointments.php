<?php
    include 'db.php';

    // Query to fetch appointment details
    $sql = "SELECT a.appointment_id, u.username AS client, t.username AS therapist, s.service_name AS service,
                a.appointment_date AS date, a.start_time, a.end_time, a.status
            FROM Appointments a
            JOIN Users u ON a.user_id = u.user_id
            JOIN Users t ON a.therapist_id = t.user_id
            JOIN Services s ON a.service_id = s.service_id";
    $result = $conn->query($sql);

    $appointments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    }

    // Return appointments as JSON
    echo json_encode($appointments);
?>
