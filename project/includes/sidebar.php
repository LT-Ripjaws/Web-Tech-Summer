<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RetroRides-Admin</title>
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
        <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
        <!-- google icons -->
         <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    </head>
    <body>
        <aside class="sidebar">
            <header class="sidebar-header">
                <div class="sidebar-panel-name">
                    <div class="sidebar-logo">
                        <img src="/Web-Tech-Summer/project/assets/images/logo.png" alt="logo">
                    </div>
                    <h2>Admin Panel</h2>
                </div>
                <button class="toggler sidebar-toggle">
                    <span class="material-symbols-rounded">chevron_left</span>
                </button>
                <button class="toggler menu-toggle">
                    <span class="material-symbols-rounded">menu</span>
                </button>
            </header>
            <nav class="sidebar-nav">
                <!--primary top nav-->
                <ul class="nav-list primary-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">dashboard</span>
                            <span class="nav-label">Dashboard</span>
                        </a>
                        <span class="nav-tooltip">Dashboard</span>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">group</span>
                            <span class="nav-label">Team</span>
                        </a>
                        <span class="nav-tooltip">Team</span>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">car_rental</span>
                            <span class="nav-label">Manage Cars</span>
                        </a>
                        <span class="nav-tooltip">Manage Cars</span>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">event_upcoming</span>
                            <span class="nav-label">Bookings</span>
                        </a>
                        <span class="nav-tooltip">Bookings</span>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">analytics</span>
                            <span class="nav-label">Analytics</span>
                        </a>
                        <span class="nav-tooltip">Analytics</span>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">settings</span>
                            <span class="nav-label">Settings</span>
                        </a>
                        <span class="nav-tooltip">Settings</span>
                    </li>
                </ul>

                <!--Secondary bottom nav-->
                <ul class="nav-list secondary-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">account_circle</span>
                            <span class="nav-label">Profile</span>
                        </a>
                        <span class="nav-tooltip">Profile</span>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon material-symbols-rounded">logout</span>
                            <span class="nav-label">Logout</span>
                        </a>
                        <span class="nav-tooltip">Logout</span>
                    </li>
                </ul>
            </nav>
        </aside>
        <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
    </body>
</html>
