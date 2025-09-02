<?php
require_once("../../../includes/db/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM employees WHERE employee_id ='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: team.php?deleted=1");
        exit();
    } else {
        echo "Error Deleting Records".$conn->error;
    }
}

$conn->close();
?>