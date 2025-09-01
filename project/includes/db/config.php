<?php

// This file is for DB connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "retrorides_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed:". $conn->connect_error); 
}

$conn->set_charset("utf8mb4");
?>