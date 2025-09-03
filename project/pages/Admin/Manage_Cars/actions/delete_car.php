<?php
require_once("../../../../includes/db/config.php");

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = intval(filter_input(INPUT_GET,'car_id', FILTER_SANITIZE_NUMBER_INT));

if ($id) {
    $sql = "DELETE FROM cars WHERE car_id=$id";

    if($conn->query($sql)===TRUE)
    {
        header("Location: ../cars.php?deleted=1");
        exit();
    }
    else{
        echo ("error deleting car").$conn->error;
    }
}
else {
    echo "Invalid car ID";
    }

}
?>