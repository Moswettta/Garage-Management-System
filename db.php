<?php
// Database connection variables
$host = "localhost"; // Your database host (usually 'localhost')
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "carbdb"; // Your database name

// Create connection
$db = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
