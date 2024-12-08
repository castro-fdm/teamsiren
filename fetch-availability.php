<?php
    include 'db.php';

    if (isset($_GET['therapist_id'])) {
        $therapist_id = $_GET['therapist_id'];

        // Query to fetch availability for the therapist
        $stmt = $conn->prepare("SELECT * FROM Availability WHERE therapist_id = ?");
        $stmt->bind_param("i", $therapist_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are available time slots
        if ($result && $result->num_rows > 0) {
            echo '<h3>Available Time Slots:</h3>';
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                $start_time = date('h:i A', strtotime($row['start_time']));
                $end_time = date('h:i A', strtotime($row['end_time']));
                echo '<li style="margin-bottom: 10px; color: #000">';
                echo '<input type="radio" name="appointment_time" value="' . $row['availability_id'] . '"> ';
                echo $start_time . ' - ' . $end_time;
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No available time slots for this therapist.</p>';
        }
    }
?>
