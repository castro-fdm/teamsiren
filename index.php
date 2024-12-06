<?php
    session_start();
    include 'db.php';

    $user_role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Spa-la-la-la</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/res/css/landing.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="index.php" style="text-decoration: none; color: #fff;"><h1>The Spa-la-la-la</h1></a>
            <nav class="nav-links">
                <?php if ($user_role === 'customer'): ?>
                    <a href="services.php">Services</a>
                <?php else: $user_role === 'therapist'; ?>
                    <p></p>
                <?php endif; ?>
                <a href="#feedback">Feedback</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php"><?= htmlspecialchars($_SESSION['username']) ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Banner -->
    <section class="banner">
        <div class="banner-text">
            <h2>Relax. Refresh. Renew.</h2>
            <p>Your ultimate destination for rejuvenation and relaxation.</p>
            <a href="services.php" class="cta-button"><button>Book Now</button></a>
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
                <span>- Alvic Palongyas</span>
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Spa-la-la-la. All rights reserved.</p>
    </footer>
</body>
</html>
