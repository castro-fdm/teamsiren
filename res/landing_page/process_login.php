<?php
$role = $_POST['role'];
$username = $_POST['username'];
$password = $_POST['password'];

if ($role == 'admin' && $username == 'admin' && $password == 'admin123') {
    header("Location: admin.html");
    exit;
} else {
    header("Location: index.html?error=invalid_credentials");
    exit;
}
?>
