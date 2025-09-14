<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}



// Handle booking status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_booking_status'])) {
    $booking_id = test_input($_POST['booking_id']);
    $new_status = test_input($_POST['status']);
    
    // Validate input
    if (empty($booking_id) || !is_numeric($booking_id)) {
        $error_message = "Invalid booking ID";
    } elseif (empty($new_status)) {
        $error_message = "Status is required";
    } else {
        // Validate status
        $valid_statuses = ['processing', 'sold', 'cancelled'];
        if (!in_array($new_status, $valid_statuses)) {
            $error_message = "Invalid status selected";
        } else {
            $sql = "UPDATE bookings SET status = ? WHERE booking_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $booking_id);
            
            if ($stmt->execute()) {
                $success_message = "Booking status updated successfully!";
                header("Location: bookings.php?success=1");
                exit();
            } else {
                $error_message = "Error updating booking status: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Get all bookings from database with car information
$bookings = [];
$sql = "SELECT b.booking_id, b.car_id, b.customer_name, b.customer_email, b.booking_date, b.status, 
               c.brand, c.model, c.year, c.price 
        FROM bookings b 
        JOIN cars c ON b.car_id = c.car_id 
        ORDER BY b.booking_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

$total_bookings = count($bookings);
$processing_bookings = count(array_filter($bookings, function($b) { return $b['status'] == 'processing'; }));
$sold_bookings = count(array_filter($bookings, function($b) { return $b['status'] == 'sold'; }));
$cancelled_bookings = count(array_filter($bookings, function($b) { return $b['status'] == 'cancelled'; }));

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
    <title>Bookings - RetroRides Dealer</title>
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/dealer-dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <div class="full-container">
    <?php
    include ('../../includes/dealer-sidebar.php'); ?>
    <main>
            <div class="dealer-topbar">
                <div class="dealer-topbar-left">
                    <h1>Test Drive Bookings</h1>
                    <p>Manage customer test drive bookings and appointments</p>
                </div>
                <div class="dealer-topbar-right">
                    <div class="dealer-search-box">
                        <span class="material-symbols-rounded">search</span>
                        <input type="text" placeholder="Search bookings...">
                    </div>
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

            <div class="dealer-summary-cards">
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">event</span>
                    <h3>Total Bookings</h3>
                    <p><?php echo $total_bookings; ?></p>
                    <small>All time</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">schedule</span>
                    <h3>Processing</h3>
                    <p><?php echo $processing_bookings; ?></p>
                    <small>Pending confirmation</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">check_circle</span>
                    <h3>Sold</h3>
                    <p><?php echo $sold_bookings; ?></p>
                    <small>Completed sales</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">cancel</span>
                    <h3>Cancelled</h3>
                    <p><?php echo $cancelled_bookings; ?></p>
                    <small>This month</small>
                </div>
            </div>

            <div class="dealer-panel">
                <div class="dealer-table-header">
                    <h4>Test Drive Bookings</h4>
                    <div class="dealer-table-actions">
                        <span class="dealer-inventory-count">Manage bookings</span>
                    </div>
                </div>

                <div class="dealer-table-container">
                    <table class="dealer-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Date & Time</th>
                                <th>Contact Info</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                    <span class="material-symbols-rounded" style="font-size: 48px; margin-bottom: 16px; display: block;">event_busy</span>
                                    No bookings found
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>#<?php echo $booking['booking_id']; ?></td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-name"><?php echo htmlspecialchars($booking['customer_name']); ?></div>
                                        <div class="customer-email"><?php echo htmlspecialchars($booking['customer_email']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="car-info">
                                        <div class="car-name"><?php echo htmlspecialchars($booking['year'] . ' ' . $booking['brand'] . ' ' . $booking['model']); ?></div>
                                        <div class="car-price">$<?php echo number_format($booking['price']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="booking-time">
                                        <div class="booking-date"><?php echo date('M d, Y', strtotime($booking['booking_date'])); ?></div>
                                        <div class="booking-time-slot"><?php echo date('h:i A', strtotime($booking['booking_date'])); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <div class="contact-email"><?php echo htmlspecialchars($booking['customer_email']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="dealer-status dealer-status-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dealer-action-buttons">
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                            <select name="status" onchange="this.form.submit()" class="dealer-status-select">
                                                <option value="processing" <?php echo $booking['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                <option value="sold" <?php echo $booking['status'] == 'sold' ? 'selected' : ''; ?>>Sold</option>
                                                <option value="cancelled" <?php echo $booking['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                            <input type="hidden" name="update_booking_status" value="1">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>
    </div>

    <style>
    .dealer-status-select {
        padding: 6px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: white;
        font-size: 14px;
        cursor: pointer;
    }
    
    .dealer-status-select:focus {
        outline: none;
        border-color: #007bff;
    }
    
    .dealer-status-processing {
        background: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-sold {
        background: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-cancelled {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    </style>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>