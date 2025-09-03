<?php

require_once("../../../../includes/db/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $role       = $_POST['role'];
    $department = $_POST['department'];
    $status     = $_POST['status'];
    $hash_pass = password_hash("default123", PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO employees (name, email, password, phone, role, department, joined, status)
            VALUES ('$name', '$email', '$hash_pass', '$phone', '$role', '$department', NOW(), '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New employee added successfully!";
        header("Location: ../team.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>