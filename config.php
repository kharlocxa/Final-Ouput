<?php
// Get your local IP address - you can hardcode it or detect it
$hostIP = $_SERVER['HTTP_HOST'] ?? 'localhost';

define('HOSTURL', 'http://' . $hostIP . '/IT424/Finals');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "northwind";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>