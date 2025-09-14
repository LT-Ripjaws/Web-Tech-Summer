<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer (sales role)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}


// Search parameter
$search = isset($_GET['search']) ? test_input($_GET['search']) : '';

// Pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Build the WHERE clause for search and filters
$where_conditions = [];
$params = [];
$param_types = '';

if (!empty($search)) {
    $where_conditions[] = "(brand LIKE ? OR model LIKE ? OR vin LIKE ? OR description LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $param_types .= 'ssss';
}


$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM cars $where_clause";
if (!empty($params)) {
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param($param_types, ...$params);
    $count_stmt->execute();
    $total_cars = $count_stmt->get_result()->fetch_assoc()['total'];
    $count_stmt->close();
} else {
    $total_cars = $conn->query($count_sql)->fetch_assoc()['total'];
}

$total_pages = ceil($total_cars / $per_page);

// Get cars with pagination
$cars = [];
$sql = "SELECT car_id, vin, brand, model, year, price, status, description, image, created_at 
        FROM cars $where_clause 
        ORDER BY created_at DESC 
        LIMIT $per_page OFFSET $offset";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}


// Handle car status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $car_id = test_input($_POST['car_id']);
    $new_status = test_input($_POST['status']);
    
    // Validate input
    if (empty($car_id) || !is_numeric($car_id)) {
        $error_message = "Invalid car ID";
    } elseif (empty($new_status)) {
        $error_message = "Status is required";
    } else {
        // Validate status
        $valid_statuses = ['available', 'sold', 'maintenance'];
        if (!in_array($new_status, $valid_statuses)) {
            $error_message = "Invalid status selected";
        } else {
            $sql = "UPDATE cars SET status = ? WHERE car_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $car_id);
            
            if ($stmt->execute()) {
                $success_message = "Car status updated successfully!";
                // Refresh the page to show updated data
                header("Location: manage-cars.php?success=1");
                exit();
            } else {
                $error_message = "Error updating car status: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Note: Dealer can only view and update car status, not delete cars

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
    <title>Manage Cars | RetroRides</title>
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/base.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/components.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/sidebar.css">
    <link rel="stylesheet" href="/Web-Tech-Summer/project/assets/css/dealer-dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
</head>
<body>
    <div class="full-container">
<?php
    include ('../../includes/dealer-sidebar.php'); ?>

    <main>
        <header class="dealer-topbar">
            <div>
                <h1>Manage Cars</h1>
                <p>View and manage your car inventory</p>
            </div>
        </header>

        <!-- Search Form -->
        <form method="GET" class="dealer-filters-section">
            <div class="dealer-search-container">
                <div class="dealer-search-box">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" name="search" placeholder="Search cars by brand, model, VIN, or description..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <?php if (!empty($search)): ?>
                <a href="manage-cars.php" class="dealer-btn dealer-btn-secondary">
                    <span class="material-symbols-rounded">clear</span>
                    Clear
                </a>
                <?php endif; ?>
                <div class="dealer-filter-group">
                    <button type="button" class="btn-secondary" onclick="toggleView()">
                        <span class="material-symbols-rounded" id="viewIcon">grid_view</span>
                        <span id="viewText">Gallery View</span>
                    </button>
                </div>
            </div>
        </form>

        <div class="dealer-panel">
            <?php if (isset($_GET['success'])): ?>
            <div class="dealer-alert dealer-alert-success">
                <span class="material-symbols-rounded">check_circle</span>
                <span>Car status updated successfully!</span>
            </div>
            <?php endif; ?>
            
            
            <?php if (isset($error_message)): ?>
            <div class="dealer-alert dealer-alert-error">
                <span class="material-symbols-rounded">error</span>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
            <?php endif; ?>

            <div class="dealer-table-header">
                <h4>Car Inventory (<?php echo count($cars); ?> cars)</h4>
                <div class="dealer-table-actions">
                    <span class="dealer-inventory-count">Manage existing cars only</span>
                </div>
            </div>

            <!-- Table View -->
            <div id="tableView" class="dealer-table-container">
                <table class="dealer-table">
                    <thead>
                        <tr>
                            <th>Car Details</th>
                            <th>Price</th>
                            <th>Condition</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cars)): ?>
                            <?php foreach ($cars as $car): ?>
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
                                            <div class="car-specs"><?php echo htmlspecialchars($car['year']); ?> • VIN: <?php echo htmlspecialchars($car['vin']); ?></div>
                                            <div class="car-condition"><?php echo htmlspecialchars($car['description']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="car-price">
                                        <div class="price">$<?php echo number_format($car['price'], 2); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                                        <select name="status" onchange="this.form.submit()" style="padding: 4px 8px; border: 1px solid #ddd; border-radius: 4px;">
                                            <option value="available" <?php echo $car['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                                            <option value="sold" <?php echo $car['status'] == 'sold' ? 'selected' : ''; ?>>Sold</option>
                                            <option value="maintenance" <?php echo $car['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td><span class="dealer-status <?php echo $car['status']; ?>"><?php echo ucfirst($car['status']); ?></span></td>
                                <td>
                                    <div class="views">
                                        <div class="view-count"><?php echo rand(100, 2000); ?></div>
                                        <div class="view-trend positive">+<?php echo rand(5, 25); ?>%</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dealer-actions">
                                        <button class="dealer-action-btn" onclick="viewCar(<?php echo $car['car_id']; ?>)" title="View Details">
                                            <span class="material-symbols-rounded">visibility</span>
                                        </button>
                                        <button class="dealer-action-btn" onclick="updateCarStatus(<?php echo $car['car_id']; ?>)" title="Update Status">
                                            <span class="material-symbols-rounded">flag</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem;">
                                    <p>No cars found in inventory.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Gallery View -->
            <div id="galleryView" class="car-gallery" style="display: none;">
                <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <div class="car-card-image">
                        <?php if (!empty($car['image'])): ?>
                            <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>" onerror="this.parentElement.innerHTML='<div class=\'car-image-placeholder\'><span class=\'material-symbols-rounded\'>directions_car</span></div>'">
                        <?php else: ?>
                            <div class="car-image-placeholder">
                                <span class="material-symbols-rounded">directions_car</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="car-card-content">
                        <div class="car-card-title"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></div>
                        <div class="car-card-specs"><?php echo htmlspecialchars($car['year']); ?> • <?php echo htmlspecialchars($car['vin']); ?></div>
                        <div class="car-card-price">$<?php echo number_format($car['price']); ?></div>
                        <div class="car-card-actions">
                            <button class="btn-main" onclick="editCar(<?php echo $car['car_id']; ?>)">Edit</button>
                            <button class="btn-secondary" onclick="viewCar(<?php echo $car['car_id']; ?>)">View</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="dealer-pagination">
                <!-- Previous Button -->
                <?php if ($page > 1): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="dealer-pagination-btn">
                    <span class="material-symbols-rounded">chevron_left</span>
                </a>
                <?php else: ?>
                <span class="dealer-pagination-btn disabled">
                    <span class="material-symbols-rounded">chevron_left</span>
                </span>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);
                
                if ($start_page > 1): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => 1])); ?>" class="dealer-pagination-btn">1</a>
                    <?php if ($start_page > 2): ?>
                    <span class="dealer-pagination-dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                   class="dealer-pagination-btn <?php echo $i == $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                    <?php if ($end_page < $total_pages - 1): ?>
                    <span class="dealer-pagination-dots">...</span>
                    <?php endif; ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $total_pages])); ?>" class="dealer-pagination-btn"><?php echo $total_pages; ?></a>
                <?php endif; ?>

                <!-- Next Button -->
                <?php if ($page < $total_pages): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="dealer-pagination-btn">
                    <span class="material-symbols-rounded">chevron_right</span>
                </a>
                <?php else: ?>
                <span class="dealer-pagination-btn disabled">
                    <span class="material-symbols-rounded">chevron_right</span>
                </span>
                <?php endif; ?>
            </div>
            
            <!-- Results Info -->
            <div class="dealer-results-info">
                <span class="material-symbols-rounded">info</span>
                <span>Showing <?php echo $offset + 1; ?>-<?php echo min($offset + $per_page, $total_cars); ?> of <?php echo $total_cars; ?> cars</span>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
    <script src="/Web-Tech-Summer/project/assets/js/sidebar.js"></script>
    <script>
        let currentView = 'table';

        function toggleView() {
            const tableView = document.getElementById('tableView');
            const galleryView = document.getElementById('galleryView');
            const viewIcon = document.getElementById('viewIcon');
            const viewText = document.getElementById('viewText');

            if (currentView === 'table') {
                tableView.style.display = 'none';
                galleryView.style.display = 'grid';
                viewIcon.textContent = 'table_view';
                viewText.textContent = 'Table View';
                currentView = 'gallery';
            } else {
                tableView.style.display = 'block';
                galleryView.style.display = 'none';
                viewIcon.textContent = 'grid_view';
                viewText.textContent = 'Gallery View';
                currentView = 'table';
            }
        }

        function viewCar(carId) {
            window.location.href = 'car-details.php?id=' + carId;
        }

        function updateCarStatus(carId) {
            window.location.href = 'edit-car.php?id=' + carId;
        }

        // Note: Dealer can only view and update car status, not delete or modify core car data
    </script>
</body>
</html>

