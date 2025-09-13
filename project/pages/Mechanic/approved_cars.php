<?php
// Dummy data for approved cars (can be replaced with database fetch)
$approvedCars = [
    ["id" => "101", "model" => "Cadillac Eldorado", "condition" => "Excellent", "date" => "2025-09-10"],
    ["id" => "103", "model" => "Ford Mustang", "condition" => "Very Good", "date" => "2025-09-13"],
    ["id" => "110", "model" => "BMW M3 E30", "condition" => "Good", "date" => "2025-09-14"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approved Cars - Retrorides</title>

  <!-- CSS Files -->
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/Admin/dashboard.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
</head>

<body>
<div class="full-container">    

  <!-- Sidebar -->
  <aside class="sidebar"> 
    <header class="sidebar-header">
      <div class="sidebar-panel-name">
        <div class="sidebar-logo">
          <img src="/Web-Tech-Summer/assets/images/logo.png" alt="logo">
        </div>
        <h2> Welcome Inspector </h2>
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
        <li class="nav-item"><a href="dashboard.php" class="nav-link"><span class="nav-icon material-symbols-rounded">dashboard</span><span class="nav-label">Dashboard</span></a></li>
        <li class="nav-item"><a href="flagged_cars.php" class="nav-link"><span class="nav-icon material-symbols-rounded">report_problem</span><span class="nav-label">Flagged Cars</span></a></li>
        <li class="nav-item"><a href="approved_cars.php" class="nav-link active"><span class="nav-icon material-symbols-rounded">check_circle</span><span class="nav-label">Approved Cars</span></a></li>
      </ul>
      <ul class="nav-list secondary-nav">
        <li class="nav-item"><a href="profile.php" class="nav-link"><span class="nav-icon material-symbols-rounded">account_circle</span><span class="nav-label">Profile</span></a></li>
        <li class="nav-item"><a href="/Web-Tech-Summer/project/pages/logout.php" class="nav-link"><span class="nav-icon material-symbols-rounded">logout</span><span class="nav-label">Logout</span></a></li>
      </ul>
    </nav>
  </aside>

  <!-- Main Section -->
  <main>
    <header class="topbar">
      <h1>Approved Cars</h1>
      <p> View and manage approved vehicle listings</p>
    </header>

    <!-- Summary Cards -->
    <section class="summarisation-cards">
        <div class="card"><h3>Total Approved</h3><span><?php echo count($approvedCars); ?></span></div>
        <div class="card"><h3>Approved Today</h3><span>1</span></div>
        <div class="card"><h3>In Marketplace</h3><span>3</span></div>
        <div class="card"><h3>Tips Added</h3><span>2</span></div>
    </section>

    <!-- Approved Car List -->
    <section class="table-grid">
        <div class="panel">
            <h3>Approved Cars</h3>
            <?php foreach ($approvedCars as $car): ?>
                <div class="row">
                    <span><strong>ID:</strong> <?php echo htmlspecialchars($car['id']); ?></span>
                    <span><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></span>
                    <span><strong>Condition:</strong> <?php echo htmlspecialchars($car['condition']); ?></span>
                    <span><strong>Approved on:</strong> <?php echo htmlspecialchars($car['date']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tips Panel -->
        <div class="panel">
            <h3>Common Maintenance Tips</h3>
            <div class="row">🛠️ Replace oil every 5,000km</div>
            <div class="row">🛠️ Rotate tires every 10,000km</div>
            <div class="row">🛠️ Keep coolant level checked</div>
        </div>

        <!-- Actions Panel -->
        <div class="panel">
            <h3>Quick Actions</h3>
            <div class="row">✅ Unapprove if error</div>
            <div class="row">✏️ Update Condition History</div>
            <div class="row">📤 Push to Buyer Listings</div>
        </div>
    </section>
  </main>
</div>

<script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>
