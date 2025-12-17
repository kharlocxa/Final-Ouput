<?php
define('HOSTURL', 'http://localhost/northwind_finals/northwind_project');
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
//echo("Connected Successfully");
?>