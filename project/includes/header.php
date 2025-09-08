<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RetroRides</title>
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/header.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/animations.css"> 
        

    </head>
    <body>
        <header>
            <nav class="navbar">
                <!-- Logo Section -->
                <div class="logo-section">
                    <a href="/Web-Tech-Summer/project/index.php"><img src="/Web-Tech-Summer/project/assets/images/logo.png" class="logo" alt="">RetroRides</a>
                </div>

                
                    <!-- Navigation Links -->
                    <ul class="nav-links">
                        <li><a class="<?php echo $current_page == 'index.php' ? 'active' : '' ?>" href="/Web-Tech-Summer/project/index.php">Home</a></li>
                        <li><a href="/Web-Tech-Summer/project/pages/collection.php" class="<?php echo $current_page == 'collection.php' ? 'active' : '' ?>">Collection</a></li>
                        <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : '' ?>">About</a></li>
                        <li><a href="contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : '' ?>">Contact Us</a></li>
                    </ul>
                

                <!-- Login Button -->
                <div class="nav-btn">
                    <a href="/Web-Tech-Summer/project/pages/login.php"><button class="btn-main">Login</button></a>
                </div>
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </header>

        <script>
            const hamburger = document.getElementById('hamburger');
            const navLinks = document.querySelector('.nav-links');
            const navBtn = document.querySelector('.nav-btn');

            hamburger.addEventListener('click', () => {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('open');
                navBtn.classList.toggle('open');
               
            });

           
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.navbar') && navLinks.classList.contains('open')) {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('open');
                    navBtn.classList.remove('open');
                    
                }
            });

            
            window.addEventListener('resize', () => {
                if (window.innerWidth > 992) {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('open');
                    navBtn.classList.remove('open');
                 
                }
            });
        </script>
