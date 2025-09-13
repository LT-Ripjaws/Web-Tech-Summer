<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Wishlist</title>
  
  <link rel="stylesheet" href="../../assets/css/customer.css">
  <link rel="stylesheet" href="../../assets/css/base.css">
  <link rel="stylesheet" href="../../assets/css/components.css">
  <link rel="stylesheet" href="../../assets/css/sidebar.css">
  <link rel="stylesheet" href="../../assets/css/Admin/dashboard.css">
  <link rel="stylesheet" href="../../assets/css/customer/sidebar.php"
</head>

<center>
<div class="panel animate__animated animate__fadeIn">
  
  <h2 style="color:#f39c12;">My Wishlist❤️</h2>
  <table id="wishlist-table">
    <tr>
     <th>Cars</th><br>
     <th>Attached on</th>
     <th>Favorite</th><br></tr>
     
    <tr>
      <td>Corvette Split Window Coupe</td> <td> 2024-05-02 </td>
      <td> <button class="fav-btn">⭐</button></td> 
      <td><button class="btn-main">Book</button> <button class="del-btn"></button></td>
    </tr>
    <tr>
      <td>Rocking Raptop-1962 VW Bettle</td> <td> 2024-06-01 </td>
      <td> <button class="fav-btn">⭐</button></td> 
      <td><button class="btn-main">Book</button> <button class="del-btn"></button</td>

    </tr>
    <tr>
      <td>Ford Mustang 1967</td> <td> 2024-07-04 </td>
      <td> <button class="fav-btn">⭐</button></td> 
      <td><button class="btn-main">Book</button> <button class="del-btn"></button></td>
    </tr>
    <tr>
      <td>Mercedes Benz 300 SL</td> <td> 2024-08-06 </td>
      <td> <button class="fav-btn">⭐</button></td> 
      <td><button class="btn-main">Book</button> <button class="del-btn"></button></td>
    </tr>
    <tr>
      <td>Chevrolet </td> <td> 2024-9-06</td>
      <td> <button class="fav-btn">⭐</button></td> 
      <td><button class="btn-main">Book</button> <button class="del-btn"></button></td>
    </tr>
  </table>

  <form method="post" class= "animate__animated animate__SlideInUp"><br>
   <label> Car Name </label>
    <input type="text" name="car" placeholder="Enter car name" required>
    <button type="submit" class="btn-main">➕ Add</button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['car'])) {
      $car = htmlspecialchars($_POST['car']);
      $date = date("Y-m-d");
      echo "<p class='success-msg'>✅ $car added to wishlist on $date!</p>";
  }
  ?>
  
  </center>
</div>


