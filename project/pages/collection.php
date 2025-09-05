<?php include '../includes/header.php'; ?>
<link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/collection.css">
<main>
     <!-- Page Hero Section -->
    <section class="collection-hero">
        <div class="hero-content">
            <h1>~Choose Your Ride~</h1>
            <p>Browse our carefully curated collection of timeless retro rides.</p>
        </div>
    </section>

    <!-- Car collection -->
      <section class="car-collection">
         <div class="container">
            <div class="car-grid">
                 <?php 
                    include("../includes/db/config.php");
                    $result = $conn->query("SELECT * FROM cars ORDER BY year ASC");
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): 
                ?>
                <div class="car-card">
                    <div class="car-img">
                        <?php if (!empty($row['image'])): ?>
                            <img src="/Web-Tech-Summer/project/assets/images/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['brand'].' '.$row['model']; ?>">
                        <?php else: ?>
                            <img src="/Web-Tech-Summer/project/assets/images/default-car.jpeg" alt="Default Car">
                        <?php endif; ?>
                    </div>
                    <div class="car-details">
                        <h3><?php echo strtoupper( $row['year']." ".$row['brand']." ".$row['model']) ; ?></h3>
                        <p class="car-desc"><?php echo substr($row['description'],0,100); ?>...</p>
                        <p class="car-price">$<?php echo number_format($row['price'], 2); ?></p>
                        <div class="car-actions">
                            <form action="test_drive.php" method="POST">
                                <input type="hidden" name="car_id" value="<?php echo $row['car_id']; ?>">
                                <button type="submit" class="btn-main small">Book Test Drive</button>
                            </form>
                            <form action="order_car.php" method="POST">
                                <input type="hidden" name="car_id" value="<?php echo $row['car_id']; ?>">
                                <button type="submit" class="btn-main small">Order Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                 <?php 
                        endwhile;
                    else:
                        echo "<p class='no-cars'>No cars available at the moment.</p>";
                    endif;
                ?>
            </div>
         </div>
      </section>
</main>

<?php include '../includes/footer.php'; ?>