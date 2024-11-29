<?php

    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $host = 'localhost'; // Change as needed
    $username = 'root'; // Change as needed
    $password = ''; // Change as needed
    $database = 'spa_db';

    // Establish the connection using MySQLi
    $conn = new mysqli($host, $username, $password);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create the database
    if ($conn->query("CREATE DATABASE IF NOT EXISTS $database") === TRUE) {
        echo "Database '$database' created successfully.\n";
    } else {
        die("Error creating database: " . $conn->error);
    }

    // Select the database
    $conn->select_db($database);

    // Define the SQL commands to create tables
    $tables = [
        "CREATE TABLE IF NOT EXISTS Users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            phone_number VARCHAR(15) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('customer', 'therapist', 'admin') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",

        "CREATE TABLE IF NOT EXISTS Services (
            service_id INT AUTO_INCREMENT PRIMARY KEY,
            service_name VARCHAR(100) NOT NULL,
            description TEXT,
            duration INT NOT NULL CHECK (duration > 0),
            price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",

        "CREATE TABLE IF NOT EXISTS Appointments (
            appointment_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            therapist_id INT NOT NULL,
            service_id INT NOT NULL,
            appointment_date DATE NOT NULL,
            start_time TIME NOT NULL,
            end_time TIME NOT NULL,
            status ENUM('pending', 'confirmed', 'completed', 'canceled') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_appointments_user FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
            CONSTRAINT fk_appointments_therapist FOREIGN KEY (therapist_id) REFERENCES Users(user_id) ON DELETE CASCADE,
            CONSTRAINT fk_appointments_service FOREIGN KEY (service_id) REFERENCES Services(service_id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS Payments (
            payment_id INT AUTO_INCREMENT PRIMARY KEY,
            appointment_id INT NOT NULL,
            amount DECIMAL(10,2) NOT NULL CHECK (amount >= 0),
            payment_method ENUM('cash', 'credit_card', 'paypal') NOT NULL,
            payment_status ENUM('paid', 'unpaid', 'refunded') DEFAULT 'unpaid',
            transaction_id VARCHAR(100),
            payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_payments_appointment FOREIGN KEY (appointment_id) REFERENCES Appointments(appointment_id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS Availability (
            availability_id INT AUTO_INCREMENT PRIMARY KEY,
            therapist_id INT NOT NULL,
            date DATE NOT NULL,
            start_time TIME NOT NULL,
            end_time TIME NOT NULL,
            CONSTRAINT fk_availability_therapist FOREIGN KEY (therapist_id) REFERENCES Users(user_id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS Reviews (
            review_id INT AUTO_INCREMENT PRIMARY KEY,
            appointment_id INT NOT NULL,
            user_id INT NOT NULL,
            rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
            comment TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_reviews_appointment FOREIGN KEY (appointment_id) REFERENCES Appointments(appointment_id) ON DELETE CASCADE,
            CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
        )",

        "CREATE TABLE IF NOT EXISTS Promotions (
            promo_id INT AUTO_INCREMENT PRIMARY KEY,
            promo_code VARCHAR(50) NOT NULL UNIQUE,
            description TEXT,
            discount_percent DECIMAL(5,2) NOT NULL CHECK (discount_percent >= 0 AND discount_percent <= 100),
            start_date DATE NOT NULL,
            end_date DATE NOT NULL
        )"
    ];

    // Execute each SQL command to create tables
    foreach ($tables as $query) {
        if ($conn->query($query) === TRUE) {
            header("Location: ../../admin.html");
        } else {
            echo "Error creating table: " . $conn->error . "\n";
        }
    }
?>