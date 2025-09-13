<?php
session_start();
require_once("../../../includes/db/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    $id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

   
    $result = $conn->query("SELECT password FROM employees WHERE employee_id = '$id'");
    $row = $result->fetch_assoc();

    if (!password_verify($old_password, $row['password'])) {
        die("Old password is incorrect!");
    }

    if ($new_password !== $confirm_password) {
        die("New passwords do not match!");
    }

    $hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "UPDATE employees
            SET password='$hashed_pass', updated_at=NOW()
            WHERE employee_id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: profile.php?password_changed=1");
        exit();
    } else {
        echo "Error updating password: " . $conn->error;
    }
}

$conn->close();
?>