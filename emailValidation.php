<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        $query = "SELECT * FROM Users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        echo ($result->num_rows > 0) ? 'taken' : 'available';
    }
?>
