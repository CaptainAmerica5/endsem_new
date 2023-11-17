<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";  // Replace with your actual database password
$dbName = "new_database";  // Replace with your actual database name

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>