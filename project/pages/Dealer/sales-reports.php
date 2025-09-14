<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}



// Get sales statistics from database
$total_cars = 0;
$available_cars = 0;
$sold_cars = 0;
$maintenance_cars = 0;
$total_value = 0;
$sold_value = 0;

$sql = "SELECT status, COUNT(*) as count, SUM(price) as total_price FROM cars GROUP BY status";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_cars += $row['count'];
        $total_value += $row['total_price'];
        
        if($row['status'] == 'available') {
            $available_cars = $row['count'];
        }
        if($row['status'] == 'sold') {
            $sold_cars = $row['count'];
            $sold_value = $row['total_price'];
        }
        if($row['status'] == 'maintenance') {
            $maintenance_cars = $row['count'];
        }
    }
}

// Get booking statistics
$total_bookings = 0;
$sold_bookings = 0;
$processing_bookings = 0;

$sql = "SELECT status, COUNT(*) as count FROM bookings GROUP BY status";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_bookings += $row['count'];
        
        if($row['status'] == 'sold') {
            $sold_bookings = $row['count'];
        }
        if($row['status'] == 'processing') {
            $processing_bookings = $row['count'];
        }
    }
}

// Get inquiry statistics
$total_inquiries = 0;
$new_inquiries = 0;
$responded_inquiries = 0;

$sql = "SELECT status, COUNT(*) as count FROM inquiries GROUP BY status";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_inquiries += $row['count'];
        
        if($row['status'] == 'new') {
            $new_inquiries = $row['count'];
        }
        if($row['status'] == 'responded') {
            $responded_inquiries = $row['count'];
        }
    }
}

// Get recent cars
$recent_cars = [];
$sql = "SELECT car_id, brand, model, year, price, status, image FROM cars ORDER BY created_at DESC LIMIT 10";
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
    <title>Sales Reports | RetroRides</title>
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
                <h1>Sales Reports</h1>
                <p>Track your sales performance and inventory</p>
            </div>
        </header>

        <div class="dealer-summary-cards">
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">directions_car</span>
                <h3>Total Inventory</h3>
                <p><?php echo $total_cars; ?></p>
                <small>Total cars</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">sell</span>
                <h3>Cars Sold</h3>
                <p><?php echo $sold_cars; ?></p>
                <small>Completed sales</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">attach_money</span>
                <h3>Total Value</h3>
                <p>$<?php echo number_format($total_value, 0); ?></p>
                <small>Inventory value</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">trending_up</span>
                <h3>Sales Value</h3>
                <p>$<?php echo number_format($sold_value, 0); ?></p>
                <small>Revenue generated</small>
            </div>
        </div>

        <div class="dealer-summary-cards">
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">event</span>
                <h3>Total Bookings</h3>
                <p><?php echo $total_bookings; ?></p>
                <small>Test drive bookings</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">check_circle</span>
                <h3>Sold Bookings</h3>
                <p><?php echo $sold_bookings; ?></p>
                <small>Converted to sales</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">question_answer</span>
                <h3>Total Inquiries</h3>
                <p><?php echo $total_inquiries; ?></p>
                <small>Customer questions</small>
            </div>
            <div class="dealer-summary-card">
                <span class="dealer-card-icon material-symbols-rounded">reply</span>
                <h3>Responded</h3>
                <p><?php echo $responded_inquiries; ?></p>
                <small>Inquiries answered</small>
            </div>
        </div>

        <div class="dealer-chart-grid">
            <div class="dealer-chart-holder">
                <div class="dealer-chart-placeholder">
                    <span class="material-symbols-rounded">bar_chart</span>
                    <p>Inventory Status Chart</p>
                </div>
            </div>
            <div class="dealer-chart-holder">
                <div class="dealer-chart-placeholder">
                    <span class="material-symbols-rounded">pie_chart</span>
                    <p>Sales Distribution</p>
                </div>
            </div>
        </div>

        <div class="dealer-panel">
            <div class="dealer-table-header">
                <h4>Recent Inventory</h4>
                <div class="dealer-table-actions">
                    <span class="dealer-inventory-count"><?php echo count($recent_cars); ?> cars</span>
                </div>
            </div>

            <div class="dealer-table-container">
                <table class="dealer-table">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Listed</th>
                            <th>Actions</th>
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
                                <td>
                                    <div class="car-price">$<?php echo number_format($car['price'], 2); ?></div>
                                </td>
                                <td><span class="dealer-status <?php echo $car['status']; ?>"><?php echo ucfirst($car['status']); ?></span></td>
                                <td><?php echo date('M d, Y', strtotime($car['created_at'])); ?></td>
                                <td>
                                    <div class="dealer-actions">
                                        <button class="dealer-action-btn" onclick="viewCar(<?php echo $car['car_id']; ?>)" title="View">
                                            <span class="material-symbols-rounded">visibility</span>
                                        </button>
                                        <button class="dealer-action-btn" onclick="editCar(<?php echo $car['car_id']; ?>)" title="Edit">
                                            <span class="material-symbols-rounded">edit</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">
                                    <p>No cars found in inventory.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    </div>

    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
    <script>
        function viewCar(carId) {
            window.location.href = 'car-details.php?id=' + carId;
        }

        function editCar(carId) {
            window.location.href = 'edit-car.php?id=' + carId;
        }
    </script>
</body>
</html>