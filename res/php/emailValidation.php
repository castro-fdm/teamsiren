<?php
include '../php/db.php'; // Include the database connection

// Check if the email is provided
if (isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // If email exists, return 'taken'
        echo 'taken';
    } else {
        // If email does not exist, return 'available'
        echo 'available';
    }
}
?>
