<?php
// db_connection.php - Place this file in a location that is included where needed (like 'includes/db_connection.php')

$host = "localhost"; // Change this to your database host
$username = "root";  // Change this to your database username
$password = "";      // Change this to your database password
$dbname = "carbdb"; // Change this to your database name

// Create connection
$db = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
