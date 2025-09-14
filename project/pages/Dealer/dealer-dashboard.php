<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer (sales role)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}



// Get car statistics from database
$total_cars = 0;
$available_cars = 0;
$sold_cars = 0;
$maintenance_cars = 0;

$sql = "SELECT status, COUNT(*) as count FROM cars GROUP BY status";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_cars += $row['count'];
        if($row['status'] == 'available') $available_cars = $row['count'];
        if($row['status'] == 'sold') $sold_cars = $row['count'];
        if($row['status'] == 'maintenance') $maintenance_cars = $row['count'];
    }
}

// Get recent cars
$recent_cars = [];
$sql = "SELECT car_id, brand, model, year, price, status, image FROM cars ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $recent_cars[] = $row;
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Dashboard | RetroRides</title>
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/dealer-dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
</head>
<body>
    <div class="full-container">
<?php
    include ('../../includes/dealer-sidebar.php'); ?>
    <main>
        <header class="dealer-topbar">
            <div>
                <h1>Dealer Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Dealer'); ?>! Here's your business overview</p>
            </div>
        </header>

        <div class="dealer-summary-cards">
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">directions_car</span>
                <h3>Total Cars</h3>
                <p><?php echo $total_cars; ?></p>
                <small>In inventory</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">check_circle</span>
                <h3>Available</h3>
                <p><?php echo $available_cars; ?></p>
                <small>Ready for sale</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">sell</span>
                <h3>Sold</h3>
                <p><?php echo $sold_cars; ?></p>
                <small>Completed sales</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">build</span>
                <h3>Maintenance</h3>
                <p><?php echo $maintenance_cars; ?></p>
                <small>Under repair</small>
            </div>
        </div>

        <div class="dealer-chart-grid">
            <div class="dealer-chart-holder">
                <div class="dealer-chart-placeholder">
                    <span class="material-symbols-rounded">bar_chart</span>
                    <p>Monthly Sales Chart</p>
                </div>
            </div>
            <div class="dealer-chart-holder">
                <div class="dealer-chart-placeholder">
                    <span class="material-symbols-rounded">trending_up</span>
                    <p>Revenue Trends</p>
                </div>
            </div>
        </div>

        <div class="dealer-table-grid">
            <div class="dealer-panel">
                <h4>Recent Listings</h4>
                <div class="dealer-table-container">
                    <table class="dealer-table">
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_cars)): ?>
                                <?php foreach ($recent_cars as $car): ?>
                                <tr>
                                    <td>
                                        <div class="car-details">
                                            <div class="car-image">
                                                <?php if (!empty($car['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>" onerror="this.parentElement.innerHTML='<div class=\'car-image-placeholder\'><span class=\'material-symbols-rounded\'>directions_car</span></div>'">
                                                <?php else: ?>
                                                    <div class="car-image-placeholder">
                                                        <span class="material-symbols-rounded">directions_car</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="car-info-text">
                                                <h5><?php echo htmlspecialchars($car['year'] . ' ' . $car['brand'] . ' ' . $car['model']); ?></h5>
                                                <div class="car-specs"><?php echo htmlspecialchars($car['year']); ?> • <?php echo htmlspecialchars($car['brand']); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$<?php echo number_format($car['price'], 2); ?></td>
                                    <td><span class="dealer-status <?php echo $car['status']; ?>"><?php echo ucfirst($car['status']); ?></span></td>
                                    <td><?php echo rand(100, 2000); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem;">
                                        <p>No cars found in inventory.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dealer-panel">
                <h4>Recent Bookings</h4>
                <div class="dealer-table-container">
                    <table class="dealer-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_cars)): ?>
                                <?php foreach ($recent_cars as $car): ?>
                                <tr>
                                    <td>Recent Car</td>
                                    <td>
                                        <div class="car-details">
                                            <div class="car-image">
                                                <?php if (!empty($car['image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>" onerror="this.parentElement.innerHTML='<div class=\'car-image-placeholder\'><span class=\'material-symbols-rounded\'>directions_car</span></div>'">
                                                <?php else: ?>
                                                    <div class="car-image-placeholder">
                                                        <span class="material-symbols-rounded">directions_car</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="car-info-text">
                                                <h5><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($car['created_at'])); ?></td>
                                    <td><span class="dealer-status <?php echo $car['status']; ?>"><?php echo ucfirst($car['status']); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No recent cars found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dealer-quick-actions">
            <div class="dealer-action-buttons">
                <a href="manage-cars.php" class="btn-main">
                    <span class="material-symbols-rounded">edit</span>
                    Manage Cars
                </a>
                <a href="manage-offers.php" class="btn-main">
                    <span class="material-symbols-rounded">local_offer</span>
                    Manage Offers
                </a>
                <a href="bookings.php" class="btn-main">
                    <span class="material-symbols-rounded">schedule</span>
                    View Bookings
                </a>
                <a href="sales-reports.php" class="btn-main">
                    <span class="material-symbols-rounded">analytics</span>
                    Sales Reports
                </a>
            </div>
        </div>
    </main>
    </div>

    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>
