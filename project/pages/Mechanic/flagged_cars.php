<?php
// Dummy data for flagged cars (replace with DB logic later)
$flaggedCars = [
    ["id" => "102", "model" => "Chevrolet Impala", "issue" => "Engine noise", "date" => "2025-09-11"],
    ["id" => "108", "model" => "Volkswagen Beetle", "issue" => "Brake wear", "date" => "2025-09-12"],
    ["id" => "115", "model" => "Mustang Shelby GT", "issue" => "Rust under chassis", "date" => "2025-09-13"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Flagged Cars - Retrorides</title>

  <!-- CSS Links -->
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
  <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css//Admin/dashboard.css">
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
        <li class="nav-item"><a href="flagged_cars.php" class="nav-link active"><span class="nav-icon material-symbols-rounded">report_problem</span><span class="nav-label">Flagged Cars</span></a></li>
        <li class="nav-item"><a href="approved_cars.php" class="nav-link"><span class="nav-icon material-symbols-rounded">check_circle</span><span class="nav-label">Approved Cars</span></a></li>
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
      <h1>Flagged Cars</h1>
      <p> Review and verify flagged vehicles before approval.</p>
    </header>

    <!-- Summary Cards -->
    <section class="summarisation-cards">
        <div class="card"><h3>Total Flagged</h3><span><?php echo count($flaggedCars); ?></span></div>
        <div class="card"><h3>Resolved</h3><span>1</span></div>
        <div class="card"><h3>Pending</h3><span><?php echo count($flaggedCars) - 1; ?></span></div>
        <div class="card"><h3>High Priority</h3><span>2</span></div>
    </section>

    <!-- Flagged Car List -->
    <section class="table-grid">
        <div class="panel">
            <h3>Flagged Cars List</h3>
            <?php foreach ($flaggedCars as $car): ?>
                <div class="row">
                    <span><strong>ID:</strong> <?php echo htmlspecialchars($car['id']); ?></span>
                    <span><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></span>
                    <span><strong>Issue:</strong> <?php echo htmlspecialchars($car['issue']); ?></span>
                    <span><strong>Date:</strong> <?php echo htmlspecialchars($car['date']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tips for Review -->
        <div class="panel">
            <h3>Review Tips</h3>
            <div class="row">✅ Check service records thoroughly</div>
            <div class="row">✅ Verify underbody & chassis conditions</div>
            <div class="row">✅ Always test drive flagged vehicles</div>
            <div class="row">✅ Record photographic evidence of issues</div>
        </div>

        <!-- Action Panel -->
        <div class="panel">
            <h3>Actions</h3>
            <div class="row">📋 Reassign to Senior Inspector</div>
            <div class="row">🛠️ Mark as Resolved</div>
            <div class="row">📤 Notify Seller for Clarification</div>
        </div>
    </section>
  </main>
</div>

<script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>
