<?php 
//  handle profile update form submission with PHP validation
$name = $email = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["number"])) {
        $error = "All fields are required.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $number= trim($_POST["number"]);

        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Dashbaord - Retrorides</title>

  <!-- Project CSS -->
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/customer.css">

  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/dashboard.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
</head>

<body>
<div class="full-container">    


    <!-- Customer sidebar -->
    <aside class="sidebar"> 
    
        <header class="sidebar-header">
            <div class="sidebar-panel-name">
                <div class="sidebar-logo">
                    <img src="/Web-Tech-Summer/project/assets/images/logo.png" alt="logo">
                </div>
                <h2> Welcome Rider </h2>
            </div>
            <button class="toggler sidebar-toggle">
                <span class="material-symbols-rounded">chevron_left</span>
            </button>
            <button class="toggler menu-toggle">
                <span class="material-symbols-rounded">menu</span>
            </button>
        </header>
        <nav class="sidebar-nav">
    <ul class="nav-list primary-nav">
        <li class="nav-item"><a href="dashboard.php"class="nav-link active"><span class="nav-icon material-symbols-rounded">dashboard</span><span class="nav-label">Dashboard</span></a></li>
        <li class="nav-item"><a href="wishlist.php" class="nav-link"><span class="nav-icon material-symbols-rounded">favorite</span><span class="nav-label">Wishlist</span></a></li>
        <li class="nav-item"><a href="book_testdrive.php" class="nav-link"><span class="nav-icon material-symbols-rounded">directions_car</span><span class="nav-label">Book Test Drive</span></a></li>
        <li class="nav-item"><a href="purchase_history.php" class="nav-link"><span class="nav-icon material-symbols-rounded">receipt_long</span><span class="nav-label">Purchase History</span></a></li>
        <li class="nav-item"><a href="apply_mechanic.php" class="nav-link"><span class="nav-icon material-symbols-rounded">build</span><span class="nav-label">Apply For mechanic</span></a></li>
    </ul>
    <ul class="nav-list secondary-nav">
        <li class="nav-item"><a href="profile.php" class="nav-link"><span class="nav-icon material-symbols-rounded">account_circle</span><span class="nav-label">Profile</span></a></li>
        <li class="nav-item"><a href="/Web-Tech-Summer/project/pages/logout.php" class="nav-link"><span class="nav-icon material-symbols-rounded">logout</span><span class="nav-label">Logout</span></a></li>
    </ul>
</nav>

    </aside>

    <!-- Main Dashboard -->
    <main>
        <header class="topbar">
            <h1> Customer Dashboard</h1>
            <p> Custom-built center</p>
        </header>

        <!-- Quick Stats -->
        <section class="summarisation-cards">
            <div class="card"><h3>Confirmed Bookings</h3><span>2</span></div>
            <div class="card"><h3>Rented Cars</h3><span>3</span></div>
            <div class="card"><h3>Dream Car List</h3><span>4</span></div>
            <div class="card"><h3>Reviews</h3><span>7</span></div>
        </section>

        <!--panels-->
        <section class="table-grid">

            <div class="panel">
                <h3>Booking History</h3>
                <div class="row"><span>Cadillac</span><span>Completed</span><span>2025-02-04</span></div>
                <div class="row"><span>Chevrolet</span><span>Activated</span><span>2025-01-03</span></div>
                <div class="row"><span>Ford</span><span>Available</span><span>2025-04-05</span></div>
            </div>

            <div class="panel">
                <h3>Update Your Profile</h3>
                <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
                <form method="post" action= "dashboard.php">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                    <label>Number</label>
                    <input type="number"name="number" value="<?php echo htmlspecialchars($number);?>"required><br><br>
                    <button type="submit" class="btn-main">Save Changes</button>
                </form>
            </div>

            <div class="panel">
                <h3> Suggested Cars</h3>
                <div class="row">🚙Corvette Split Window Coupe</div>
                <div class="row">🚙Ford Mustang Fastback</div>
                <div class="row">🚙Mercedes-Benz 300 Sl Gullwing</div>
                <div class="row">🚙Rocking Ragtop VW Beetle</div>
            </div>
        </section>
    </main>
</div>

<script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>