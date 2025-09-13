<?php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['car']) || empty($_POST['date']) || empty($_POST['time']) || empty($_POST['location'])) {
        $error = "⚠️ Please fill out all fields.";
    } else {
        $car = htmlspecialchars($_POST['car']);
        $date = htmlspecialchars($_POST['date']);
        $time = htmlspecialchars($_POST['time']);
        $driver = htmlspecialchars($_POST['driver']);
        $location = htmlspecialchars($_POST['location']);

        $success = "✅ Test drive booked for <b>$car</b> on <b>$date</b> at <b>$time</b>, Driver: <b>$driver</b>, Location: <b>$location</b>.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Test Drive - RetroRides</title>

  <!-- Project CSS -->
  <link rel="stylesheet" href="../../assets/css/customer.css">
  <link rel="stylesheet" href="../../assets/css/base.css">
  <link rel="stylesheet" href="../../assets/css/components.css">
  <link rel="stylesheet" href="../../assets/css/sidebar.css">
  <link rel="stylesheet" href="../../assets/css/Admin/dashboard.css">
</head>
<body>
<div class="full-container">
  <?php include("sidebar.php"); ?>
  

  <main>
    <div class="glass-box animate__animated animate__fadeIn">
        <header class="topbar">
          <h1 style="color:#f39c12;">Book Test Drive</h1>
        </header><br>
       <p style="color:#f39c12;">Schedule A Test Drive.</p><br>


      <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
      <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

      <form method="post" action="book_testdrive.php">
        <label>Select car</label>
        <select name="car" required>
            <option value="">-- Choice a car--</option>
            <option value="Corvette Split">Corvette Split</option>
            <option value="Rocking Ragtop">Rocking Ragtop</option>
            <option value="Cadillac">Cadillac</option>
            <option value="Chevrolet">Chevrolet</option>
        </select>
        <br><br>

        <label>Preferred Date:</label>
        <input type="date" name="date" required placeholder="mm/dd/yyyy">
        <br><br>

        <label>Time Slot:</label>
        <select name="time" required>
            <option value="1 PM">1 PM</option>
            <option value="3 PM">3 PM</option>
            <option value="4 PM">4 PM</option>
        </select>
        <br><br>
        <label>Driver Preference:</label>
        <select name="driver" required>
            <option value="Self Drive">Self Drive</option>
            <option value="Company Driver">Company Driver</option>
        </select>
        <br><br>

         <label>Location:</label>
        <input type="text" name="location" placeholder="Enter Your Location" required>
        <br><br>

         <button type="submit" class="btn-main">Book Test Drive</button><br>
      </form>
    </div>
  </main>
</div>

<script src="../../assets/js/sidebar.js"></script>
</body>
</html>



