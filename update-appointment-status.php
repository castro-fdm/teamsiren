<?php
    session_start();
    include 'db.php';

    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['role'];  // Assume the role is stored in the session

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        if ($user_role == 'therapist' || $user_role == 'customer') {
            header('Location: profile.php');
        } elseif ($user_role == 'admin') {
            header('Location: admin-dashboard.php');
        } else {
            header('Location: login.php');
        }
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $appointment_id = $_POST['appointment_id'];
        $status = $_POST['status'];

        // Update appointment status
        $sql = "UPDATE Appointments SET status = ? WHERE appointment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $appointment_id);


        if($user_role == 'therapist' || $user_role == 'customer') {
            if ($stmt->execute()) {
                echo "<script>
                        alert('Appointment status updated successfully!');
                        window.location.href = 'profile.php'; // Redirect to the profile page
                    </script>";
            } else {
                echo "<script>
                        alert('Error updating appointment status. Please try again.');
                    </script>";
            }
        } elseif ($user_role == 'admin') {
            if ($stmt->execute()) {
                echo "<script>
                        alert('Appointment status updated successfully!');
                        window.location.href = 'admin-dashboard.php'; // Redirect to the admin dashboard
                    </script>";
            } else {
                echo "<script>
                        alert('Error updating appointment status. Please try again.');
                    </script>";
            }
        }
    }
?>
