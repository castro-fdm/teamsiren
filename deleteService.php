<?php
    // deleteService.php
    include 'db.php';

    if (isset($_GET['service_id'])) {
        $service_id = $_GET['service_id'];

        // Delete the service
        $stmt = $pdo->prepare("DELETE FROM Services WHERE service_id = :service_id");
        $stmt->execute(['service_id' => $service_id]);

        header("Location: admin-dashboard.php?category=Services");
        exit();
    } else {
        die("Invalid request.");
    }
?>