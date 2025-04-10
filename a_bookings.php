<?php
error_reporting(0);

session_start();
include('includes/server.php'); // Database connection

// Delete Booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM archive WHERE bid = '$delete_id'";
    if ($db->query($sql) === TRUE) {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='a_bookings.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking: " . $db->error . "');</script>";
    }
}

// Update Mechanic Assignment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_mechanic'])) {
    $booking_id = $_POST['booking_id'];
    $mechanic_id = $_POST['mechanic_id'];

    $update_sql = "UPDATE archive SET mechanic_id = '$mechanic_id' WHERE bid = '$booking_id'";
    if ($db->query($update_sql) === TRUE) {
        echo "<script>alert('Mechanic assigned successfully!'); window.location.href='a_bookings.php';</script>";
    } else {
        echo "<script>alert('Error updating mechanic: " . $db->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Bookings</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    display: flex;
}

.header {
    position: fixed;
    top: 0;
    width: 100%;
    background-color: #047a94;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 1.5em;
    z-index: 1000;
}

.container {
    display: flex;
    width: 100%;
    margin-top: 60px; /* Adjust for fixed header */
}

.sidebar {
    width: 250px;
    height: 100vh; /* Full height */
    background: #2c3e50;
    padding: 15px;
    color: white;
    position: fixed; /* Keeps it visible */
    top: 60px; /* Below header */
    left: 0;
    overflow-y: auto; /* Scroll if content overflows */
    border-right: 2px solid #1abc9c;
}

.sidebar p.hdr {
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
    margin-bottom: 15px;
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px;
    text-decoration: none;
    margin-bottom: 10px;
    border-radius: 5px;
    background: #34495e;
    transition: background 0.3s;
}

.sidebar a:hover {
    background: #1abc9c;
}

.main-content {
    margin-left: 270px; /* Adjust for sidebar width */
    padding: 20px;
    width: calc(100% - 270px);
    background: white;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}

th {
    background: #047a94;
    color: white;
}

.delete-btn {
    background: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
}

.assign-btn {
    background: green;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
}

    </style>
</head>
<body>
    <div class="header">Admin - View All Bookings</div>
    <div class="container">
        <div class="sidebar">
            <p class="hdr">Admin Panel</p>
            <a href="admindashboard.php">Home</a>
            <a href="a_bookingstoday.php">View Today's Bookings</a>
            <a href="a_bookings.php">View All Bookings</a>
            <a href="a_searchbookings.php">Search Completed Bookings</a>
            <a href="a_cancellations.php">View Cancelled Bookings</a>
            <a href="a_vehicle.php">Add or Delete Vehicle</a>
            <a href="a_employee.php">Add or Delete Employee</a>
             <a href="REPORTS.php" class="linkb">Reports</a>
            <a href="adminlogout.php">Log Out</a>
        </div>
              

        <div class="main-content">
            <h3 align="center">All Bookings</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Servicing Date</th>
                        <th>Drop-off Time</th>
                        <th>Vehicle</th>
                        <th>Vehicle Number</th>
                        <th>Services Required</th>
                        <th>Comments</th>
                        <th>Status</th>
                        <th>Assigned Mechanic</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT a.*, m.name AS mechanic_name FROM archive a 
                            LEFT JOIN mechanic m ON a.mechanic_id = m.id";
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $mechanic_name = $row['mechanic_name'] ? $row['mechanic_name'] : "<span style='color:red;'>Not Assigned</span>";
                            echo "<tr>
                                    <td>{$row['bid']}</td>
                                    <td>{$row['mname']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['sdate']}</td>
                                    <td>{$row['dtime']}</td>
                                    <td>{$row['vehicle']}</td>
                                    <td>{$row['vehiclenum']}</td>
                                    <td>{$row['services']}</td>
                                    <td>{$row['comments']}</td>
                                    <td>{$row['status']}</td>
                                    <td>{$mechanic_name}</td>
                                    <td>
                                        <form method='POST' style='display:inline;'>
                                            <input type='hidden' name='delete_id' value='{$row['bid']}'>
                                            <button type='submit' class='delete-btn'>Delete</button>
                                        </form>
                                        <form method='POST' style='display:inline;'>
                                            <input type='hidden' name='booking_id' value='{$row['bid']}'>
                                            <select name='mechanic_id'>";
                                            
                                            // Fetch available mechanics
                                            $mech_sql = "SELECT * FROM mechanic";
                                            $mech_result = $db->query($mech_sql);
                                            while ($mech_row = $mech_result->fetch_assoc()) {
                                                $selected = ($mech_row['id'] == $row['mechanic_id']) ? "selected" : "";
                                                echo "<option value='{$mech_row['id']}' $selected>{$mech_row['name']}</option>";
                                            }

                                    echo "</select>
                                            <button type='submit' name='assign_mechanic' class='assign-btn'>Assign</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
