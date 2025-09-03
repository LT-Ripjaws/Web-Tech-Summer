<?php include("../../../../includes/db/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $vin   = $_POST['vin'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year  = $_POST['year'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $desc  = $_POST['desc'];

    $sql = "INSERT into cars (vin, brand, model, year, price, status, description, created_at)
            VALUES ('$vin', '$brand', '$model', '$year', '$price', '$status', '$desc', NOW())";

    if($conn->query($sql) === TRUE) {
        header("Location: ../cars.php?success=1");
        exit();
    } else {
        echo ("error").$conn->error;
    }
}   