<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}

// Handle offer status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_offer_status'])) {
    $offer_id = test_input($_POST['offer_id']);
    $new_status = test_input($_POST['status']);
    
    // Validate input
    if (empty($offer_id) || !is_numeric($offer_id)) {
        $error_message = "Invalid offer ID";
    } elseif (empty($new_status)) {
        $error_message = "Status is required";
    } else {
        // Validate status
        $valid_statuses = ['active', 'inactive', 'expired'];
        if (!in_array($new_status, $valid_statuses)) {
            $error_message = "Invalid status selected";
        } else {
            $sql = "UPDATE offers SET status = ? WHERE offer_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $offer_id);
            
            if ($stmt->execute()) {
                $success_message = "Offer status updated successfully!";
                header("Location: manage-offers.php?success=1");
                exit();
            } else {
                $error_message = "Error updating offer status: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Get all offers from database with car information
$offers = [];
$sql = "SELECT o.offer_id, o.car_id, o.offer_title, o.offer_description, o.discount_percentage, o.discount_amount, 
               o.start_date, o.end_date, o.status, o.created_at,
               c.brand, c.model, c.year, c.price 
        FROM offers o 
        JOIN cars c ON o.car_id = c.car_id 
        ORDER BY o.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }
}

$total_offers = count($offers);
$active_offers = count(array_filter($offers, function($o) { return $o['status'] == 'active'; }));
$inactive_offers = count(array_filter($offers, function($o) { return $o['status'] == 'inactive'; }));
$expired_offers = count(array_filter($offers, function($o) { return $o['status'] == 'expired'; }));

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
    <title>Manage Offers - RetroRides Dealer</title>
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
                    <h1>Manage Offers & Discounts</h1>
                    <p>View and manage special offers and discounts for your cars</p>
                </div>
                <div class="dealer-topbar-right">
                    <div class="dealer-search-box">
                        <span class="material-symbols-rounded">search</span>
                        <input type="text" placeholder="Search offers...">
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
                    <span class="dealer-card-icon material-symbols-rounded">local_offer</span>
                    <h3>Total Offers</h3>
                    <p><?php echo $total_offers; ?></p>
                    <small>All time</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">check_circle</span>
                    <h3>Active</h3>
                    <p><?php echo $active_offers; ?></p>
                    <small>Currently running</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">pause</span>
                    <h3>Inactive</h3>
                    <p><?php echo $inactive_offers; ?></p>
                    <small>Paused</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">schedule</span>
                    <h3>Expired</h3>
                    <p><?php echo $expired_offers; ?></p>
                    <small>Ended</small>
                </div>
            </div>

            <div class="dealer-panel">
                <div class="dealer-table-header">
                    <h4>Special Offers & Discounts</h4>
                    <div class="dealer-table-actions">
                        <span class="dealer-inventory-count">Manage offers</span>
                    </div>
                </div>

                <div class="dealer-table-container">
                    <table class="dealer-table">
                        <thead>
                            <tr>
                                <th>Offer ID</th>
                                <th>Car</th>
                                <th>Offer Title</th>
                                <th>Discount</th>
                                <th>Valid Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($offers)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                    <span class="material-symbols-rounded" style="font-size: 48px; margin-bottom: 16px; display: block;">local_offer</span>
                                    No offers found
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($offers as $offer): ?>
                            <tr>
                                <td>#<?php echo $offer['offer_id']; ?></td>
                                <td>
                                    <div class="car-info">
                                        <div class="car-name"><?php echo htmlspecialchars($offer['year'] . ' ' . $offer['brand'] . ' ' . $offer['model']); ?></div>
                                        <div class="car-price">$<?php echo number_format($offer['price']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="offer-info">
                                        <div class="offer-title"><?php echo htmlspecialchars($offer['offer_title']); ?></div>
                                        <div class="offer-description"><?php echo htmlspecialchars(substr($offer['offer_description'], 0, 80)); ?>...</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="discount-info">
                                        <?php if (!empty($offer['discount_percentage'])): ?>
                                        <span class="discount-percentage"><?php echo $offer['discount_percentage']; ?>% OFF</span>
                                        <?php endif; ?>
                                        <?php if (!empty($offer['discount_amount'])): ?>
                                        <span class="discount-amount">$<?php echo number_format($offer['discount_amount']); ?> OFF</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="validity-period">
                                        <div class="start-date">From: <?php echo date('M d, Y', strtotime($offer['start_date'])); ?></div>
                                        <div class="end-date">To: <?php echo date('M d, Y', strtotime($offer['end_date'])); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="dealer-status dealer-status-<?php echo $offer['status']; ?>">
                                        <?php echo ucfirst($offer['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dealer-action-buttons">
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
                                            <select name="status" onchange="this.form.submit()" class="dealer-status-select">
                                                <option value="active" <?php echo $offer['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="inactive" <?php echo $offer['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                <option value="expired" <?php echo $offer['status'] == 'expired' ? 'selected' : ''; ?>>Expired</option>
                                            </select>
                                            <input type="hidden" name="update_offer_status" value="1">
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
    
    .dealer-status-active {
        background: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-inactive {
        background: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-expired {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .discount-percentage, .discount-amount {
        display: block;
        font-weight: bold;
        color: #28a745;
    }
    
    .offer-title {
        font-weight: bold;
        margin-bottom: 4px;
    }
    
    .offer-description {
        color: #666;
        font-size: 12px;
    }
    </style>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>