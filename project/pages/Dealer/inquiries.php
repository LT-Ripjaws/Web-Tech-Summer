<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}



// Handle inquiry status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_inquiry_status'])) {
    $inquiry_id = test_input($_POST['inquiry_id']);
    $new_status = test_input($_POST['status']);
    
    // Validate input
    if (empty($inquiry_id) || !is_numeric($inquiry_id)) {
        $error_message = "Invalid inquiry ID";
    } elseif (empty($new_status)) {
        $error_message = "Status is required";
    } else {
        // Validate status
        $valid_statuses = ['new', 'responded', 'closed'];
        if (!in_array($new_status, $valid_statuses)) {
            $error_message = "Invalid status selected";
        } else {
            $sql = "UPDATE inquiries SET status = ? WHERE inquiry_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $inquiry_id);
            
            if ($stmt->execute()) {
                $success_message = "Inquiry status updated successfully!";
                header("Location: inquiries.php?success=1");
                exit();
            } else {
                $error_message = "Error updating inquiry status: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Get all inquiries from database with car information
$inquiries = [];
$sql = "SELECT i.inquiry_id, i.car_id, i.customer_name, i.customer_email, i.customer_phone, i.message, i.status, i.created_at,
               c.brand, c.model, c.year, c.price 
        FROM inquiries i 
        JOIN cars c ON i.car_id = c.car_id 
        ORDER BY i.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $inquiries[] = $row;
    }
}

$total_inquiries = count($inquiries);
$new_inquiries = count(array_filter($inquiries, function($i) { return $i['status'] == 'new'; }));
$responded_inquiries = count(array_filter($inquiries, function($i) { return $i['status'] == 'responded'; }));
$closed_inquiries = count(array_filter($inquiries, function($i) { return $i['status'] == 'closed'; }));

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
    <title>Customer Inquiries - RetroRides Dealer</title>
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
                    <h1>Customer Inquiries</h1>
                    <p>Manage customer questions and inquiries about your cars</p>
                </div>
                <div class="dealer-topbar-right">
                    <div class="dealer-search-box">
                        <span class="material-symbols-rounded">search</span>
                        <input type="text" placeholder="Search inquiries...">
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
                    <span class="dealer-card-icon material-symbols-rounded">question_answer</span>
                    <h3>Total Inquiries</h3>
                    <p><?php echo $total_inquiries; ?></p>
                    <small>All time</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">new_releases</span>
                    <h3>New</h3>
                    <p><?php echo $new_inquiries; ?></p>
                    <small>Awaiting response</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">reply</span>
                    <h3>Responded</h3>
                    <p><?php echo $responded_inquiries; ?></p>
                    <small>Response sent</small>
                </div>
                <div class="dealer-summary-card">
                    <span class="dealer-card-icon material-symbols-rounded">done</span>
                    <h3>Closed</h3>
                    <p><?php echo $closed_inquiries; ?></p>
                    <small>Resolved</small>
                </div>
            </div>

            <div class="dealer-panel">
                <div class="dealer-table-header">
                    <h4>Customer Inquiries</h4>
                    <div class="dealer-table-actions">
                        <span class="dealer-inventory-count">Manage inquiries</span>
                    </div>
                </div>

                <div class="dealer-table-container">
                    <table class="dealer-table">
                        <thead>
                            <tr>
                                <th>Inquiry ID</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($inquiries)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                                    <span class="material-symbols-rounded" style="font-size: 48px; margin-bottom: 16px; display: block;">question_answer</span>
                                    No inquiries found
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($inquiries as $inquiry): ?>
                            <tr>
                                <td>#<?php echo $inquiry['inquiry_id']; ?></td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-name"><?php echo htmlspecialchars($inquiry['customer_name']); ?></div>
                                        <div class="customer-email"><?php echo htmlspecialchars($inquiry['customer_email']); ?></div>
                                        <?php if (!empty($inquiry['customer_phone'])): ?>
                                        <div class="customer-phone"><?php echo htmlspecialchars($inquiry['customer_phone']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="car-info">
                                        <div class="car-name"><?php echo htmlspecialchars($inquiry['year'] . ' ' . $inquiry['brand'] . ' ' . $inquiry['model']); ?></div>
                                        <div class="car-price">$<?php echo number_format($inquiry['price']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="inquiry-message">
                                        <?php echo htmlspecialchars(substr($inquiry['message'], 0, 100)); ?>
                                        <?php if (strlen($inquiry['message']) > 100): ?>
                                        <span style="color: #666;">...</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="inquiry-date">
                                        <?php echo date('M d, Y', strtotime($inquiry['created_at'])); ?>
                                        <br>
                                        <small style="color: #666;"><?php echo date('h:i A', strtotime($inquiry['created_at'])); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="dealer-status dealer-status-<?php echo $inquiry['status']; ?>">
                                        <?php echo ucfirst($inquiry['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dealer-action-buttons">
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['inquiry_id']; ?>">
                                            <select name="status" onchange="this.form.submit()" class="dealer-status-select">
                                                <option value="new" <?php echo $inquiry['status'] == 'new' ? 'selected' : ''; ?>>New</option>
                                                <option value="responded" <?php echo $inquiry['status'] == 'responded' ? 'selected' : ''; ?>>Responded</option>
                                                <option value="closed" <?php echo $inquiry['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                                            </select>
                                            <input type="hidden" name="update_inquiry_status" value="1">
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
    
    .dealer-status-new {
        background: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-responded {
        background: #d1ecf1;
        color: #0c5460;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .dealer-status-closed {
        background: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .inquiry-message {
        max-width: 200px;
        word-wrap: break-word;
    }
    </style>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</body>
</html>