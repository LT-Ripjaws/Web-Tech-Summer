<?php 

$car_id = $condition = $tip = $status = $error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["car_id"]) || empty($_POST["condition"]) || empty($_POST["status"])) {
        $error = "All fields marked with * are required.";
    } else {
        $car_id = trim($_POST["car_id"]);
        $condition = trim($_POST["condition"]);
        $tip = trim($_POST["tip"]);
        $status = trim($_POST["status"]);
        
        
        $success = "Car inspection data for Car ID $car_id successfully updated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inspector Dashboard - Retrorides</title>

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
                  <img src="/Web-Tech-Summer/project/assets/images/logo.png" alt="logo">
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
            <li class="nav-item"><a href="dashboard.php" class="nav-link active"><span class="nav-icon material-symbols-rounded">dashboard</span><span class="nav-label">Dashboard</span></a></li>
            <li class="nav-item"><a href="flagged_cars.php" class="nav-link"><span class="nav-icon material-symbols-rounded">report_problem</span><span class="nav-label">Flagged Cars</span></a></li>
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
        <h1> Inspector Dashboard</h1>
        <p> Manage inspection and approval of cars</p>
    </header>

    <!-- Summary Cards -->
    <section class="summarisation-cards">
        <div class="card"><h3>Cars Inspected</h3><span>12</span></div>
        <div class="card"><h3>Approved Cars</h3><span>9</span></div>
        <div class="card"><h3>Pending Verifications</h3><span>3</span></div>
        <div class="card"><h3>Tips Suggested</h3><span>15</span></div>
    </section>

    <!-- Panels -->
    <section class="table-grid">

        <!-- Upload Inspection Report Panel -->
        <div class="panel">
            <h3>Update Car Inspection</h3>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
            <form method="post" action="inspector_dashboard.php">
                <label>Car ID *</label>
                <input type="text" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>" required>

                <label>Condition *</label>
                <textarea name="condition" rows="3" required><?php echo htmlspecialchars($condition); ?></textarea>

                <label>Maintenance Tip (optional)</label>
                <textarea name="tip" rows="2"><?php echo htmlspecialchars($tip); ?></textarea>

                <label>Status *</label>
                <select name="status" required>
                    <option value="">--Select--</option>
                    <option value="Approved" <?php if($status == "Approved") echo "selected"; ?>>Approve</option>
                    <option value="Flagged" <?php if($status == "Flagged") echo "selected"; ?>>Flag for Verification</option>
                </select>
                <br><br>
                <button type="submit" class="btn-main">Submit Inspection</button>
            </form>
        </div>

        <!-- Dummy Car List -->
        <div class="panel">
            <h3>Recently Inspected Cars</h3>
            <div class="row"><span>ID: 101</span><span>Approved</span><span>2025-09-10</span></div>
            <div class="row"><span>ID: 102</span><span>Flagged</span><span>2025-09-11</span></div>
            <div class="row"><span>ID: 103</span><span>Approved</span><span>2025-09-13</span></div>
        </div>

        <!-- Tips Panel -->
        <div class="panel">
            <h3>Recent Maintenance Tips</h3>
            <div class="row">🛠️ Check tire pressure weekly.</div>
            <div class="row">🛠️ Change oil every 5,000km.</div>
            <div class="row">🛠️ Clean battery terminals monthly.</div>
        </div>
    </section>
  </main>
</div>

<script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>
