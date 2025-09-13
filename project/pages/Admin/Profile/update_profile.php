<?php
session_start();
require_once("../../../includes/db/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    $id = $_SESSION['user_id']; 
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $sql = "UPDATE employees
            SET name='$name', email='$email', phone='$phone', updated_at=NOW()
            WHERE employee_id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: profile.php?success=1");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>