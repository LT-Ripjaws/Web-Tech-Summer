<?php include("../../../../includes/db/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $vin    = $conn->real_escape_string($_POST['vin']);
    $brand  = $conn->real_escape_string($_POST['brand']);
    $model  = $conn->real_escape_string($_POST['model']);
    $year   = $conn->real_escape_string($_POST['year']);
    $price  = $conn->real_escape_string($_POST['price']);
    $status = $conn->real_escape_string($_POST['status']);
    $desc   = $conn->real_escape_string($_POST['desc']);

     $imageName = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "../../../../assets/images/uploads/";
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = basename($_FILES['image']['name']);
        $ext = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg","jpeg","png","gif");
        $targetPath = $uploadDir . $imageName;

        if(in_array(strtolower($ext), $allowedTypes)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
        }
    }

    $sql = "INSERT into cars (vin, brand, model, year, price, status, description, image, created_at)
            VALUES ('$vin', '$brand', '$model', '$year', '$price', '$status', '$desc', '$imageName', NOW())";

    if($conn->query($sql) === TRUE) {
        header("Location: ../cars.php?success=1");
        exit();
    } else {
        echo ("error").$conn->error;
    }
}   