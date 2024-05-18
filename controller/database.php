<?php
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$database = "root"; 

$conn = new PDO("mysql:host={$servername};dbname={$database}");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

$conn->close();
?>