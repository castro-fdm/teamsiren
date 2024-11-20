<?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost";
    $username = "root";
    $password = "Hotwheels06"; // change this to your password
    $dbname = "spa_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>