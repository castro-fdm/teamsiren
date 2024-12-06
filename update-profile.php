<?php
    session_start();
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];

        // Update user profile
        $sql = "UPDATE Users SET username = ?, email = ?, phone_number = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $phone_number, $user_id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Profile updated successfully!');
                    window.location.href = 'profile.php'; // Redirect to the profile page
                </script>";
        } else {
            echo "<script>
                    alert('Error updating profile. Please try again.');
                </script>";
        }
    }
?>
