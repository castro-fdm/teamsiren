<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/res/css/style.css">
    <title>Login</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>The Spa</h1>
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
            echo "<p class='error'>Please fill in all fields.</p>";
        } elseif ($error == 'invalid_credentials') {
            echo "<p class='error'>Invalid username or password.</p>";
        } elseif ($error == 'invalid_role') {
            echo "<p class='error'>Invalid role selected.</p>";
        } elseif ($error == 'invalid_password') {
            echo "<p class='error'>Incorrect password. Please try again.</p>";
        } elseif ($error == 'user_not_found') {
            echo "<p class='error'>No user found with this username.</p>";
        }
    }
    ?>
    <form action="processLogin.php" method="POST" class="login-form">
        <select name="role" required>
            <option value="" disabled selected>Login As</option>
            <option value="admin">Admin</option>
            <option value="therapist">Therapist</option>
            <option value="user">User</option>
        </select>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</section>
</body>
</html>