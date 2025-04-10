<?php
// Start session
session_start();

// Database connection (replace with your database credentials)
$servername = "localhost";
$username = "root"; // default user for XAMPP/MySQL
$password = "";     // default password for XAMPP/MySQL
$dbname = "carbdb"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Query to get total number of mechanics
$mechanics_query = "SELECT COUNT(*) AS total_mechanics FROM mechanic";
$mechanics_result = $conn->query($mechanics_query);
$mechanics_count = $mechanics_result->fetch_assoc()['total_mechanics'];

// Query to get total number of members
$members_query = "SELECT COUNT(*) AS total_members FROM members";
$members_result = $conn->query($members_query);
$members_count = $members_result->fetch_assoc()['total_members'];

// Query to get total number of bookings
$bookings_query = "SELECT COUNT(*) AS total_bookings FROM bookings";
$bookings_result = $conn->query($bookings_query);
$bookings_count = $bookings_result->fetch_assoc()['total_bookings'];

// Query to get total number of cancellations
$cancellations_query = "SELECT COUNT(*) AS total_cancellations FROM cancellations";
$cancellations_result = $conn->query($cancellations_query);
$cancellations_count = $cancellations_result->fetch_assoc()['total_cancellations'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset some basic styles */
        body, h1, h3, p, button {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Page container */
        .page-container {
            display: flex;
            min-height: 100vh;
            background-color: #f7f7f7;
        }

        /* Header */
        .header {
            width: 100%;
            background: #006b8e;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.6em;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2f3b46;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            font-size: 1.4em;
            margin-bottom: 20px;
            color: #ecf0f1;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            background: #34495e;
            transition: background 0.3s ease;
        }

        .sidebar a:hover {
            background: #1abc9c;
        }

        /* Main content */
        .main-content {
            margin-left: 260px; /* Offset for the sidebar */
            padding: 30px;
            width: calc(100% - 260px);
        }

        /* Dashboard container */
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        /* Individual card styling */
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 240px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 20px;
            color: #2980b9;
            font-weight: bold;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .card .btn {
            margin-top: 20px;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px); /* Adds subtle lift effect on hover */
        }

        .card .btn:hover {
            background-color: #3498db;
        }

        /* Different colors for each card */
        .card.mechanics {
            background-color: #f9e25d; /* Light Yellow */
        }

        .card.members {
            background-color: #e74c3c; /* Red */
        }

        .card.bookings {
            background-color: #27ae60; /* Green */
        }

        .card.cancellations {
            background-color: #9b59b6; /* Purple */
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
                align-items: center;
            }
        }

    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header">Admin Dashboard</div>

    <div class="page-container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <?php if (isset($_SESSION['username'])): ?>
                <h2>Admin Panel</h2>
                <!-- Sidebar Navigation Links -->
                <a href="admindashboard.php" class="linkb">Home</a>
                <a href="a_bookingstoday.php" class="linkb">View Today's Bookings</a>
                <a href="a_bookings.php" class="linkb">View All Bookings</a>
                <a href="a_searchbookings.php" class="linkb">Search Completed Bookings</a>
                <a href="a_cancellations.php" class="linkb">View Cancelled Bookings</a>
                <a href="a_vehicle.php" class="linkb">Add or Delete Vehicle</a>
                <a href="a_employee.php" class="linkb">Add or Delete Employee</a>
                 <a href="REPORTS.php" class="linkb">Reports</a>
                <a href="admn.php">Log Out</a>
            <?php else: ?>
                <p>Please log in to access the dashboard.</p>
            <?php endif; ?>
        </div>

        <!-- Main Content Section -->
        <div class="main-content">
            <h1>Welcome to the Admin Dashboard</h1>
            <div class="dashboard-container">
                <!-- Mechanics Card -->
                <div class="card mechanics">
                    <h3 class="card-title">Total Mechanics</h3>
                    <p><?php echo $mechanics_count; ?></p>
                    <button class="btn" onclick="window.location.href='view_mechanics.php'">View Mechanics</button>
                </div>

                <!-- Members Card -->
                <div class="card members">
                    <h3 class="card-title">Total Members</h3>
                    <p><?php echo $members_count; ?></p>
                    <button class="btn" onclick="window.location.href='view_members.php'">View Members</button>
                </div>

                <!-- Bookings Card -->
                <div class="card bookings">
                    <h3 class="card-title">Total Bookings</h3>
                    <p><?php echo $bookings_count; ?></p>
                    <button class="btn" onclick="window.location.href='a_bookings.php'">View Bookings</button>
                </div>

                <!-- Cancellations Card -->
                <div class="card cancellations">
                    <h3 class="card-title">Total Cancellations</h3>
                    <p><?php echo $cancellations_count; ?></p>
                    <button class="btn" onclick="window.location.href='a_cancellations.php'">View Cancellations</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
