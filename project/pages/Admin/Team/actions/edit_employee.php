<?php
require_once("../../../../includes/db/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST['employee_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $status = $_POST['status'];

    $sql = "UPDATE employees
            SET name='$name', email='$email', phone='$phone', role='$role', department='$department',
            status='$status' WHERE employee_id='$id'";
    
    if($conn->query($sql) === TRUE) {
        header("Location: ../team.php");
        exit();
    }
    else {
        echo "error updating record".$conn->error;
    }

}

$conn->close();
?>