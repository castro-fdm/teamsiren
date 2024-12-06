<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'db.php';

    // Retrieve error and success messages from query parameters
    $error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
    $success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Sign Up</title>
</head>
<body>
    <style>
        /* General Styles */
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            line-height: 1.6;
            background-color: #f7f7f7;
            color: #333;
        }

        h1, h2 {
            font-family: 'Roboto', sans-serif;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Header */
        header {
            background-color: #4CAF50;  /* Soft green */
            color: white;
            padding: 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: auto;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
        }

        .nav-links a, li {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            list-style: none;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }
        /* Login Section */
        .login-section,
        .signup-section {
            background-color: #f0f8ff;
            padding: 40px 20px;
            text-align: center;
        }

        .login-form,
        .signup-form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-form select,
        .login-form input,
        .signup-form select,
        .signup-form input {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .login-form button,
        .signup-form button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-form button:hover,
        .signup-form button:hover {
            background-color: #388e3c;
            transform: scale(1.05);
        }
    </style>
    <header>
        <div class="header-container">
            <a href="index.php" style="text-decoration: none; color: #fff;"><h1>The Spa-la-la-la</h1></a>
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
            <input type="email" id="email" name="email" required><br>
            <span id="emailError" style="color: red; display: none;">Email is already taken, please choose another one.</span><br><br>
            
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

    <?php if ($error): ?>
        <script>
            alert("Error: <?php echo $error; ?>");
        </script>
    <?php elseif ($success): ?>
        <script>
            alert("Signup successful!");
            window.location.href = "login.php";
        </script>
    <?php endif; ?>

    <script>
        // Email duplication check using AJAX
        $(document).ready(function() {
            $('#email').on('keyup', function() {
                const email = $(this).val();
                if (email) {
                    $.ajax({
                        url: 'emailValidation.php',
                        type: 'POST',
                        data: { email: email },
                        success: function(response) {
                            if (response === 'taken') {
                                $('#emailError').show();
                            } else {
                                $('#emailError').hide();
                            }
                        }
                    });
                } else {
                    $('#emailError').hide();
                }
            });
        });
    </script>
</body>
</html>