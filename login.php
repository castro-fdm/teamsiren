<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                <a href="#login">Login</a>
            </nav>
        </div>
    </header>
<!-- Login Section -->
<section id="login" class="login-section">
    <h2>Login</h2>
    <!-- Show error messages if any -->
    <?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error == 'empty_fields') {
            echo "<p class='error' style='color: red;'>Please fill in all fields.</p>";
        } elseif ($error == 'invalid_credentials') {
            echo "<p class='error' style='color: red;'>Invalid username or password.</p>";
        } elseif ($error == 'invalid_role') {
            echo "<p class='error' style='color: red;'>Invalid role selected.</p>";
        } elseif ($error == 'invalid_password') {
            echo "<p class='error' style='color: red;'>Incorrect password. Please try again.</p>";
        } elseif ($error == 'user_not_found') {
            echo "<p class='error' style='color: red;'>No user found with this username.</p>";
        }
    }
    ?>
    <form action="processLogin.php" method="POST" class="login-form">
        <select name="role" required>
            <option value="" disabled selected>Login As</option>
            <option value="admin">Admin</option>
            <option value="therapist">Therapist</option>
            <option value="user">Customer</option>
        </select>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <label for="signup"><a href="signup.php">Don't have an account? Sign up here.</a></label>
</section>
</body>
</html>