<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer (sales role)
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

// Handle status update only (dealers can only update status, not modify core car data)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $status = test_input($_POST['status']);
    
    // Validate status
    $valid_statuses = ['available', 'sold', 'maintenance'];
    if (!in_array($status, $valid_statuses)) {
        $error_message = "Invalid status selected";
    } else {
        // Update only car status in database
        $sql = "UPDATE cars SET status = ? WHERE car_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $car_id);
        
        if ($stmt->execute()) {
            $success_message = "Car status updated successfully!";
            header("Location: manage-cars.php?success=status_updated");
            exit();
        } else {
            $error_message = "Error updating car status: " . $conn->error;
        }
        $stmt->close();
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car Status - RetroRides Dealer</title>
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/dealer-dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</head>
<body>
    <div class="full-container">
<?php
    include ('../../includes/dealer-sidebar.php'); ?>

    <main>
            <div class="dealer-topbar">
                <div class="dealer-topbar-left">
                    <h1>Update Car Status</h1>
                    <p>Update the status of <?php echo htmlspecialchars($car_data['year'] . ' ' . $car_data['brand'] . ' ' . $car_data['model']); ?></p>
                </div>
                <div class="dealer-topbar-right">
                    <a href="manage-cars.php" class="dealer-btn dealer-btn-secondary">
                        <span class="material-symbols-rounded">arrow_back</span>
                        Back to Cars
                    </a>
                </div>
            </div>

            <?php if (isset($success_message)): ?>
            <div class="dealer-alert dealer-alert-success">
                <span class="material-symbols-rounded">check_circle</span>
                <span><?php echo htmlspecialchars($success_message); ?></span>
            </div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
            <div class="dealer-alert dealer-alert-error">
                <span class="material-symbols-rounded">error</span>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
            <?php endif; ?>

            <div class="dealer-panel">
                <div class="dealer-table-header">
                    <h4>Car Information</h4>
                </div>
                
                <div class="dealer-car-details">
                    <div class="dealer-car-image">
                        <?php if (!empty($car_data['image'])): ?>
                        <img src="<?php echo htmlspecialchars($car_data['image']); ?>" alt="<?php echo htmlspecialchars($car_data['brand'] . ' ' . $car_data['model']); ?>" class="dealer-car-img">
                        <?php else: ?>
                        <div class="dealer-no-image">
                            <span class="material-symbols-rounded">directions_car</span>
                            <p>No image available</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="dealer-car-info">
                        <h3><?php echo htmlspecialchars($car_data['year'] . ' ' . $car_data['brand'] . ' ' . $car_data['model']); ?></h3>
                        <div class="dealer-car-specs">
                            <div class="dealer-spec-item">
                                <span class="dealer-spec-label">VIN:</span>
                                <span class="dealer-spec-value"><?php echo htmlspecialchars($car_data['vin']); ?></span>
                            </div>
                            <div class="dealer-spec-item">
                                <span class="dealer-spec-label">Year:</span>
                                <span class="dealer-spec-value"><?php echo $car_data['year']; ?></span>
                            </div>
                            <div class="dealer-spec-item">
                                <span class="dealer-spec-label">Brand:</span>
                                <span class="dealer-spec-value"><?php echo htmlspecialchars($car_data['brand']); ?></span>
                            </div>
                            <div class="dealer-spec-item">
                                <span class="dealer-spec-label">Model:</span>
                                <span class="dealer-spec-value"><?php echo htmlspecialchars($car_data['model']); ?></span>
                            </div>
                            <div class="dealer-spec-item">
                                <span class="dealer-spec-label">Price:</span>
                                <span class="dealer-spec-value">$<?php echo number_format($car_data['price']); ?></span>
                            </div>
                            <div class="dealer-spec-item">
                                <span class="dealer-spec-label">Current Status:</span>
                                <span class="dealer-spec-value dealer-status-<?php echo $car_data['status']; ?>"><?php echo ucfirst($car_data['status']); ?></span>
                            </div>
                        </div>
                        
                        <?php if (!empty($car_data['description'])): ?>
                        <div class="dealer-car-description">
                            <h4>Description</h4>
                            <p><?php echo htmlspecialchars($car_data['description']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="dealer-panel">
                <div class="dealer-table-header">
                    <h4>Update Status</h4>
                    <p>Dealers can only update the car status, not modify core car information.</p>
                </div>
                
                <form method="post" class="dealer-form-container">
                    <div class="dealer-form-group">
                        <label for="status">
                            <span class="material-symbols-rounded">flag</span>
                            Car Status *
                        </label>
                        <select name="status" id="status" required class="dealer-form-input">
                            <option value="available" <?php echo $car_data['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                            <option value="sold" <?php echo $car_data['status'] == 'sold' ? 'selected' : ''; ?>>Sold</option>
                            <option value="maintenance" <?php echo $car_data['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        </select>
                    </div>
                    
                    <div class="dealer-form-actions">
                        <button type="submit" name="update_status" class="dealer-btn dealer-btn-primary">
                            <span class="material-symbols-rounded">save</span>
                            Update Status
                        </button>
                        <a href="manage-cars.php" class="dealer-btn dealer-btn-secondary">
                            <span class="material-symbols-rounded">cancel</span>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
    </main>
</div>
    <style>
    .dealer-car-details {
        display: flex;
        gap: 30px;
        padding: 20px;
    }
    
    .dealer-car-image {
        flex: 0 0 300px;
    }
    
    .dealer-car-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    .dealer-no-image {
        width: 100%;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px dashed #ddd;
        border-radius: 8px;
        color: #666;
    }
    
    .dealer-no-image .material-symbols-rounded {
        font-size: 48px;
        margin-bottom: 10px;
    }
    
    .dealer-car-info {
        flex: 1;
    }
    
    .dealer-car-info h3 {
        margin: 0 0 20px 0;
        color: #333;
        font-size: 24px;
    }
    
    .dealer-car-specs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .dealer-spec-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 4px;
    }
    
    .dealer-spec-label {
        font-weight: 600;
        color: #666;
    }
    
    .dealer-spec-value {
        color: #333;
    }
    
    .dealer-car-description {
        margin-top: 20px;
    }
    
    .dealer-car-description h4 {
        margin: 0 0 10px 0;
        color: #333;
    }
    
    .dealer-car-description p {
        color: #666;
        line-height: 1.6;
    }
    
    .dealer-status-available {
        background: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-sold {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-maintenance {
        background: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-form-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    </style>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>