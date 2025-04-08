<?php require_once("../../private/functions/initialization.php") ?>

<?php
$page_styles = [
    PUBLIC_PATH . '/css/header.css',
    PUBLIC_PATH . '/css/homepage.css',
    PUBLIC_PATH . '/css/font.css',
    PUBLIC_PATH . '/css/grid.css',
    PUBLIC_PATH . '/css/footer.css',
    PUBLIC_PATH . '/css/about_us.css', // Add the about_us.css here
];

require_once(ROOT_PATH . SHARED_PATH . '/header.php');
?>

<body>
    <div class="about-us-container">
        <div class="about-us-header">
            <h1>Welcome to FurEver Friends!</h1>
            <p>A platform designed to help you post and adopt adorable pets in the Greater Vancouver area.</p>
        </div>

        <div class="about-us-content">
            <div class="about-us-image">
                <img src="../images/assets/aboutus.png" width="1284" height="690" alt="FurEver Friends Image"/>
            </div>

            <div class="about-us-text">
                <h2>Our Mission</h2>
                <p>We believe that every animal deserves a warm and sweet home, and we also believe that happy pets bring happy owners. That's why we're here to facilitate free adoptions and connect loving families with wonderful pets!</p>
                <p>What are you waiting for? Become a member today and start your pet adoption adventure!</p>
            </div>
        </div>

        <div class="contact-us">
            <h2>Contact Us</h2>
            <div class="detail">
                <div class="contact-info">
                    <p><strong>Phone:</strong> (604) 123-4567</p>
                    <p><strong>Email:</strong> hello@fureverfriends.com</p>
                    <p><strong>Address:</strong> 123 Pet Adoption Ave, Burnaby, BC</p>
                </div>

                <div class="hours-info">
                    <p><span class="day">Monday-Friday:</span> 10am-6pm</p>
                    <p><span class="day">Saturday:</span> 10am-4pm</p>
                    <p><span class="day">Sunday:</span> Closed</p>
                </div>
            </div>
        </div>

    </div>

    <?php require_once(ROOT_PATH . SHARED_PATH . '/footer.php'); ?>
</body>
</html>
