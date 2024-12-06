<?php
    // deleteUser.php
    include 'db.php';

    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        // Delete the user
        $stmt = $pdo->prepare("DELETE FROM Users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        header("Location: admin-dashboard.php?category=Users");
        exit();
    } else {
        die("Invalid request.");
    }
?>
