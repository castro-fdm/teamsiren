<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <title>Test User Creation</title>
    <link rel="stylesheet" href="/res/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>The Spa</h1>
            <nav class="nav-links">
                <a href="#services">Services</a>
                <a href="#feedback">Feedback</a>
                <a href="/login.php">Login</a>
            </nav>
        </div>
    </header>
    <section id="signup" class="signup-section">
        <h1>User Registration Form</h1>
        <form action="userAdd.php" method="POST" class="signup-form">
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br><span id="emailError" style="color: red; display: none;">Email is already taken, please choose another one.</span><br><br>
            
            <label for="phone_number">Phone Number:</label><br>
            <input type="text" id="phone_number" name="phone_number" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="role">Role:</label><br>
            <select id="role" name="role" required>
                <option value="customer">Customer</option>
                <option value="therapist">Therapist</option>
                <option value="admin">Admin</option>
            </select><br><br>
            
            <button type="submit">Submit</button>
        </form>
    </section>
    <!-- script to check for email duplication -->
    <script>
        // Check if the email is already taken as the user types
        $(document).ready(function() {
            $('#email').on('keyup', function() {
                var email = $(this).val();
                if (email) {
                    $.ajax({
                        url: 'emailValidation.php', // The PHP script to check email
                        type: 'POST',
                        data: { email: email },
                        success: function(response) {
                            if (response === 'taken') {
                                $('#emailError').show(); // Show error message
                            } else {
                                $('#emailError').hide(); // Hide error message
                            }
                        }
                    });
                } else {
                    $('#emailError').hide(); // Hide error message if email field is empty
                }
            });
        });
    </script>
</body>
</html>