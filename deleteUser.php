<?php
    // deleteUser.php
    include 'db.php';

    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        // Delete the user
        $stmt = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
        
        // Bind the parameter as an integer
        $stmt->bind_param("i", $user_id);  // 'i' denotes the type is an integer

        // Execute the statement
        $stmt->execute();

        header("Location: admin-dashboard.php?category=Users");
        exit();
    } else {
        die("Invalid request.");
    }
?>
