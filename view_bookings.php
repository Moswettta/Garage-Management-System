<?php
session_start();
include('includes/server.php'); // Ensure this file connects to your database

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Fetch user's bookings
$sql = "SELECT id, sdate, vehicle, vehiclenum, dtime, comments, booking_status 
        FROM bookings WHERE user_id = '$user_id' ORDER BY sdate DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .status-rejected {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include('includes/navbar.php'); ?>

<div class="container">
    <h2>My Bookings</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Service Date</th>
                <th>Vehicle</th>
                <th>Vehicle Number</th>
                <th>Drop-off Time</th>
                <th>Comments</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): 
                $count = 1;
                while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['sdate']; ?></td>
                    <td><?php echo $row['vehicle']; ?></td>
                    <td><?php echo $row['vehiclenum']; ?></td>
                    <td><?php echo $row['dtime']; ?></td>
                    <td><?php echo $row['comments']; ?></td>
                    <td>
                        <?php 
                            if ($row['booking_status'] == "Pending") {
                                echo "<span class='status-pending'>Pending</span>";
                            } elseif ($row['booking_status'] == "Approved") {
                                echo "<span class='status-approved'>Approved</span>";
                            } else {
                                echo "<span class='status-rejected'>Rejected</span>";
                            }
                        ?>
                    </td>
                </tr>
            <?php endwhile; 
            else: ?>
                <tr>
                    <td colspan="7">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
