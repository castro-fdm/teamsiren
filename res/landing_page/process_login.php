<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Placeholder logic for handling login
    if ($role === 'admin' && $username === 'admin' && $password === 'admin123') {
        echo "Welcome Admin!";
    } elseif ($role === 'therapist' && $username === 'therapist' && $password === 'therapist123') {
        echo "Welcome Therapist!";
    } elseif ($role === 'user' && $username === 'user' && $password === 'user123') {
        echo "Welcome User!";
    } else {
        echo "Invalid credentials or role. Please try again.";
    }
}
?>
