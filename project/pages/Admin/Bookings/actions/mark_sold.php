<?php
include("../../../../includes/db/config.php");

if (isset($_GET['booking_id'])) {
    $id = intval($_GET['booking_id']);
    $conn->query("UPDATE bookings SET status='sold' WHERE booking_id=$id");
}
header("Location: ../bookings.php");
exit;
?>