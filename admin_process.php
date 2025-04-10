<?php
session_start();
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Carbdb";

// Establishing a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username and password from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if the admin credentials are correct
$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Admin credentials are correct, redirect to admin dashboard or perform any other actions
    $_SESSION['admin_username'] = $username;
    header("Location: admin.php"); // Redirect to admin dashboard
} else {
    // Admin credentials are incorrect, redirect back to the login page with an error message
    $_SESSION['login_error'] = "Invalid username or password";
    header("Location: admin_login.php"); // Redirect back to admin login page
}

$conn->close();
?>
