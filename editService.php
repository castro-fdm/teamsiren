<?php
    // editService.php
    include 'db.php';

    if (isset($_GET['service_id'])) {
        $service_id = $_GET['service_id'];

        // Fetch the service data
        $stmt = $pdo->prepare("SELECT * FROM Services WHERE service_id = :service_id");
        $stmt->execute(['service_id' => $service_id]);
        $service = $stmt->fetch();

        if (!$service) {
            die("Service not found.");
        }
    } else {
        die("Invalid request.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $service_name = $_POST['service_name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];

        // Update the service in the database
        $stmt = $pdo->prepare("UPDATE Services SET service_name = :service_name, description = :description, duration = :duration, price = :price WHERE service_id = :service_id");
        $stmt->execute([
            'service_name' => $service_name,
            'description' => $description,
            'duration' => $duration,
            'price' => $price,
            'service_id' => $service_id
        ]);

        header("Location: admin-dashboard.php?category=Services");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="service_name" value="<?= $service['service_name'] ?>" required>
        <textarea name="description"><?= $service['description'] ?></textarea>
        <input type="number" name="duration" value="<?= $service['duration'] ?>" required>
        <input type="number" step="0.01" name="price" value="<?= $service['price'] ?>" required>
        <button type="submit">Update Service</button>
    </form>
</body>
</html>