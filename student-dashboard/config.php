<?php
// config.php

$host = 'localhost'; // Database host
$dbUsername = 'eajlbarx_iilmuniversity'; // Database username
$dbPassword = 'Shivansh@IILM2k24'; // Database password
$dbName = 'eajlbarx_assignmentiilm'; // Database name

// Create a connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
