<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Spa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
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

    <!-- Banner -->
    <section class="banner">
        <div class="banner-text">
            <h2>Relax. Refresh. Renew.</h2>
            <p>Your ultimate destination for rejuvenation and relaxation.</p>
            <button onclick="alert('Booking system coming soon!')">Book Now</button>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="services">
        <h2>Our Services</h2>
        <div class="service-card-container">
            <div class="service-card">
            <img src="https://media.istockphoto.com/id/469916170/photo/young-woman-relaxing-during-back-massage-at-the-spa.jpg?s=612x612&w=0&k=20&c=E96oMIIPfdq4sOhC3frI7x2uWFrOw71Bw5hih-BxaaY=" alt="Massage Therapy" class="service-image">
            <h3>Massage Therapy</h3>
            <p>Relax and unwind with our professional massage services.</p>
            <button>Book Now</button>
            </div>
            <div class="service-card">
                <img src="https://media.istockphoto.com/id/1399469980/photo/close-up-portrait-of-anorganic-facial-mask-application-at-spa-salon-facial-treatment-skin.jpg?s=612x612&w=0&k=20&c=ZvZi_bdGLicsykUtlrHgQe70ftZzd_xPKvq2vzfOyV0=" alt="Facial Treatment">
                <h3>Facial Treatment</h3>
                <p>Rejuvenate your skin with our personalized facial care.</p>
                <button>Book Now</button>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/300x200" alt="Spa Packages">
                <h3>Spa Packages</h3>
                <p>Enjoy exclusive packages tailored to your relaxation needs.</p>
                <button>Book Now</button>
            </div>
        </div>
    </section>

    <!-- Customer Feedback -->
    <section id="feedback" class="feedback">
        <h2>Customer Feedback</h2>
        <div class="feedback-card-container">
            <div class="feedback-card">
                <p>"The best spa experience ever!"</p>
                <span>- Franz Castro</span>
            </div>
            <div class="feedback-card">
                <p>"Amazing staff and services. Highly recommend!"</p>
                <span>- Paul Valera</span>
            </div>
            <div class="feedback-card">
                <p>"Truly relaxing and refreshing."</p>
                <span>- Alvic palongyas</span>
            </div>
        </div>
    </section>

    <!-- Login Section -->
    <section id="login" class="login-section">
        <h2>Login</h2>
        <form action="process_login.php" method="POST" class="login-form">
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

    <footer>
        <p>&copy; 2024 The Spa. All rights reserved.</p>
    </footer>
</body>
</html>
