<?php 
session_start();
include("../../includes/db/config.php");

// Check if user is logged in as dealer (sales role)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sales') {
    header('Location: ../login.php');
    exit();
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: manage-cars.php');
    exit();
}

// Get car ID
$car_id = isset($_POST['car_id']) ? intval($_POST['car_id']) : 0;

if ($car_id <= 0) {
    header('Location: manage-cars.php?error=invalid_car_id');
    exit();
}

// Only allow status updates (dealers cannot modify core car data)
if (isset($_POST['update_status'])) {
    $status = test_input($_POST['status']);
    
    // Validate status
    $valid_statuses = ['available', 'sold', 'maintenance'];
    if (!in_array($status, $valid_statuses)) {
        header('Location: edit-car.php?id=' . $car_id . '&error=invalid_status');
        exit();
    }
    
    // Update only car status in database
    $sql = "UPDATE cars SET status = ? WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $car_id);
    
    if ($stmt->execute()) {
        $stmt->close();
        // Success - redirect back to manage cars
        header('Location: manage-cars.php?success=status_updated&car_id=' . $car_id);
        exit();
    } else {
        $stmt->close();
        // Error - redirect back with error
        header('Location: edit-car.php?id=' . $car_id . '&error=' . urlencode("Database error: " . $conn->error));
        exit();
    }
} else {
    // No valid action
    header('Location: manage-cars.php?error=invalid_action');
    exit();
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>