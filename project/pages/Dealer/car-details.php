<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}



// Get car ID from URL
$car_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get car data from database
$car_data = null;
if ($car_id > 0) {
    $sql = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $car_data = $result->fetch_assoc();
    } else {
        header('Location: manage-cars.php');
        exit();
    }
    $stmt->close();
} else {
    header('Location: manage-cars.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details | RetroRides</title>
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
                <h1>Car Details</h1>
                <p>View detailed information about this car</p>
            </div>
        </header>

        <div class="dealer-panel">
            <div class="car-details-header">
                <div class="car-details-title">
                    <h2><?php echo htmlspecialchars($car_data['year'] . ' ' . $car_data['brand'] . ' ' . $car_data['model']); ?></h2>
                    <div class="car-details-price">$<?php echo number_format($car_data['price'], 2); ?></div>
                </div>
                <div class="car-details-status">
                    <span class="dealer-status <?php echo $car_data['status']; ?>"><?php echo ucfirst($car_data['status']); ?></span>
                </div>
            </div>

            <div class="car-details-content">
                <div class="car-details-image">
                    <?php if (!empty($car_data['image'])): ?>
                        <img src="<?php echo htmlspecialchars($car_data['image']); ?>" alt="<?php echo htmlspecialchars($car_data['brand'] . ' ' . $car_data['model']); ?>" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjMzMzMzMzIi8+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjE1MCIgcj0iNDAiIGZpbGw9IiM2NjY2NjYiLz4KPHBhdGggZD0iTTgwIDMwMEM4MCAyNzkuMDkxIDk1LjkwOSAyNjAgMTIwIDI2MEgyODBDMzA0LjA5MSAyNjAgMzIwIDI3OS4wOTEgMzIwIDMwMFYzMTBINjBWMzAwWiIgZmlsbD0iIzY2NjY2NiIvPgo8L3N2Zz4K'">
                    <?php else: ?>
                        <div class="car-image-placeholder">
                            <span class="material-symbols-rounded">directions_car</span>
                            <p>No image available</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="car-details-info">
                    <div class="car-details-section">
                        <h3>Vehicle Information</h3>
                        <div class="car-details-grid">
                            <div class="car-detail-item">
                                <span class="car-detail-label">VIN:</span>
                                <span class="car-detail-value"><?php echo htmlspecialchars($car_data['vin']); ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Brand:</span>
                                <span class="car-detail-value"><?php echo htmlspecialchars($car_data['brand']); ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Model:</span>
                                <span class="car-detail-value"><?php echo htmlspecialchars($car_data['model']); ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Year:</span>
                                <span class="car-detail-value"><?php echo $car_data['year']; ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Price:</span>
                                <span class="car-detail-value">$<?php echo number_format($car_data['price'], 2); ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Status:</span>
                                <span class="car-detail-value">
                                    <span class="dealer-status <?php echo $car_data['status']; ?>"><?php echo ucfirst($car_data['status']); ?></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="car-details-section">
                        <h3>Description</h3>
                        <p><?php echo htmlspecialchars($car_data['description']); ?></p>
                    </div>

                    <div class="car-details-section">
                        <h3>Listing Information</h3>
                        <div class="car-details-grid">
                            <div class="car-detail-item">
                                <span class="car-detail-label">Listed:</span>
                                <span class="car-detail-value"><?php echo date('M d, Y', strtotime($car_data['created_at'])); ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Views:</span>
                                <span class="car-detail-value"><?php echo rand(100, 2000); ?></span>
                            </div>
                            <div class="car-detail-item">
                                <span class="car-detail-label">Inquiries:</span>
                                <span class="car-detail-value"><?php echo rand(5, 50); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="car-details-actions">
                <a href="edit-car.php?id=<?php echo $car_id; ?>" class="btn-main">
                    <span class="material-symbols-rounded">edit</span>
                    Edit Car
                </a>
                <a href="manage-cars.php" class="btn-secondary">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Back to Inventory
                </a>
            </div>
        </div>
    </main>
    </div>

    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>