<?php
$error = $sucess = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || empty($_POST["issue"]) ) {
        $error = "All fields are required.";
    } else {
        $name = htmlspecialchars($_POST["name"]);
        $issue = htmlspecialchars($_POST["issue"]);
        $information = htmlspecialchars($_POST["information"]);
        $details = htmlspecialchars($_POST["details"]);
        $success = "Mechanic request submitted by $name: $issue: $information: $details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
     <title>Apply for Mechanic - RetroRides</title>
  <link rel="stylesheet" href="../../assets/css/base.css">
  <link rel="stylesheet" href="../../assets/css/components.css">
  <link rel="stylesheet" href="../../assets/css/sidebar.css">
  <link rel="stylesheet" href="../../assets/css/Admin/dashboard.css">
  
</head>
<body>
<div class="full-container">
  <?php include("sidebar.php"); ?>

  <main>
    <header class="topbar"><h1>Apply for Mechanic</h1></header>

    <section class="panel">
      <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
      <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

      <form method="POST">
        <label style="color:#f39c12;">Your Name</label>
        <input type="text" name="name" placeholder="Enter your name"><br>
        <label style="color:#f39c12;">Car Issue</label>
        <textarea name="issue" placeholder="Describe the issue"></textarea><br>
        <label style="color:#f39c12;">Contact</label>
        <textarea name="Information" placeholder="Contact Information"></textarea><br>
        <label style="color:#f39c12;">Car Details</label>
        <textarea name="Details" placeholder="Describe car details"></textarea><br>
        <label style="color:#f39c12;">Service</label>
        <textarea name="service type" placeholder="Service type"></textarea><br>
        
        <button type="submit" class="btn-main">Submit Request</button><br>
      </form>
    </section>
  </main>
</div>
<script src="../../assets/js/sidebar.js"></script>
</body>
</html>








