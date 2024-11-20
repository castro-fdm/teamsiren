<?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include '../php/db.php'; // Connects to database

    // Fetch all users
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    // Prepare the result in an associative array
    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        $users = []; // No users found
    }

    $conn->close();

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($users);
?>
