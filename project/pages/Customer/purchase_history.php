<?php
// validation 
$error ="";
$success="";
$history= []; // initialize history

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['car'])) {
        $error = "Please Select a car to purchase.";
    } else {
        $car = htmlspecialchars($_POST['car']);
        $order_id = "#p" . rand(2500, 4534); 
        $date = date("Y-m-d");
        $amount = "$" . rand(2500, 500000);

        $history[] = [$order_id, $car, $date, $amount];
        $success = "✅ Purchase Succesful! Order $order_id for $car added.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Purchase History - Retrorides</title>

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
    <header class="topbar"><h1>Purchase History</h1></header>    
    <section class="panel">
      <h3>Completed Purchase</h3>
      <?php if (!empty($history)) { ?>
        <?php foreach ($history as $purchase) {?>
          <div class="row" style="margin-bottom:8px;">
            <span style="color:#f39c12;">Order ID: <?php echo $purchase[0]; ?></span> |           |
            <span style="color:#f39c12;">Car: <?php echo $purchase[1]; ?></span> |
            <span style="color:#f39c12;">Date: <?php echo $purchase[2]; ?></span> |
            <span style="color:#f39c12;">Amount: <?php echo $purchase[3]; ?></span>
          </div>
        <?php } ?>
      <?php } else { ?>
        <p style="color:#f39c12;">No Purchases yet.</p>
      <?php } ?>
    </section>

    <!-- new purchase form -->
    <section class="panel">
      <h3>Buy a car</h3>
      <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
      <?php if ($success) echo "<p style='color:lime;'>$success</p>"; ?>

      <form method="post" action="purchase_history.php">
        <label>Select Car</label>
        <select name="car" required>
          <option value="">-- Choose a Car --</option>
          <option value="Chevrolet">Chevrolet</option>
          <option value="Ford Mustang">Ford Mustang</option>
          <option value="Corvette Split">Corvette Split</option>
          <option value="Cadillac">Cadillac</option>
          
        </select><br><br>

        <button type="submit" class="btn-main">Purchase</button>
      </form>
    </section>
  </main>
</div>

<script src="../../assets/js/sidebar.js"></script>
</body>
</html>

