<?php
    // Include database connection
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include 'db.php';

    // Fetch services from the database
    $sql = "SELECT service_id, service_name, description, duration, price, created_at, updated_at FROM Services";
    $result = $conn->query($sql);

    // Check if there are any services
    if ($result->num_rows > 0) {
        $services = [];
        
        // Fetch all services and store them in an array
        while($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        
        // Return services as JSON
        echo json_encode($services);
    } else {
        // Return an empty array if no services are found
        echo json_encode([]);
    }

    $conn->close();
?>
