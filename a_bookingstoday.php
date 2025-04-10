<?php
include('includes/server.php');
include('includes/errors.php');

// Get today's date
$todaydate = date("Y-m-d");

// Fetch today's and future bookings
$sql = "SELECT * FROM bookings WHERE sdate >= '$todaydate'";
$result = $db->query($sql);

// Handle mechanic assignment
if (isset($_POST['assign_mechanic'])) {
    $bid = $_POST['bid'];
    $mechanic_id = $_POST['mechanic_id'];
    
    // Get mechanic name
    $mech_query = "SELECT name FROM mechanic WHERE id='$mechanic_id'";
    $mech_result = $db->query($mech_query);
    $mech_row = $mech_result->fetch_assoc();
    $mechanic_name = $mech_row['name'];
    
    // Update booking with mechanic and set status to Active
    $update_sql = "UPDATE bookings SET mechanic_id='$mechanic_id', mechanic_name='$mechanic_name', status='Active' WHERE bid='$bid'";
    $db->query($update_sql);
}

// Handle booking completion
if (isset($_GET['complete'])) {
    $bid = $_GET['complete'];

    // Check if mechanic is assigned and repair comment exists
    $check_sql = "SELECT * FROM bookings WHERE bid='$bid' AND mechanic_id != 0 AND repair_comment != ''";
    $check_result = $db->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Move data to archive
        $move_sql = "INSERT INTO archive (bid, mname, phone, email, sdate, dtime, vehicle, vehiclenum, services, comments, status, repair_comment, mechanic_id) 
                     SELECT bid, mname, phone, email, sdate, dtime, vehicle, vehiclenum, services, comments, status, repair_comment, mechanic_id 
                     FROM bookings WHERE bid='$bid'";
        
        if ($db->query($move_sql)) {
            // Delete original booking
            $delete_sql = "DELETE FROM bookings WHERE bid='$bid'";
            $db->query($delete_sql);
        }
    } else {
        echo "<script>alert('Cannot complete! Assign a mechanic and ensure a repair comment is added.');</script>";
    }
}

// Handle booking cancellation
if (isset($_GET['cancel'])) {
    $bid = $_GET['cancel'];

    // Move to canceled_bookings
    $move_sql = "INSERT INTO cancellations (bid, mname, phone, email, sdate, dtime, vehicle, vehiclenum, services, comments, status, repair_comment, mechanic_id) 
                 SELECT bid, mname, phone, email, sdate, dtime, vehicle, vehiclenum, services, comments, status, repair_comment, mechanic_id 
                 FROM bookings WHERE bid='$bid'";
    
    if ($db->query($move_sql)) {
        $delete_sql = "DELETE FROM bookings WHERE bid='$bid'";
        $db->query($delete_sql);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Bookings</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.8em;
            font-weight: bold;
        }

        .container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            top: 60px;
            height: calc(100% - 60px);
            left: 0;
            overflow-y: auto;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            margin: 5px 0;
            transition: background 0.3s, padding-left 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            padding-left: 25px;
        }

        .content {
            margin-left: 260px;
            padding: 25px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            overflow-y: auto;
            border-radius: 10px;
        }

        h3 {
            text-align: center;
            font-weight: 600;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #007bff;
            color: white;
            text-transform: uppercase;
        }

        td {
            background: #f8f9fa;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-assign {
            background: #28a745;
            color: white;
            border: none;
        }

        .btn-assign:hover {
            background: #218838;
        }

        .btn-complete {
            background: #17a2b8;
            color: white;
        }

        .btn-complete:hover {
            background: #138496;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-cancel:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="header">Admin Panel | <a href="admn.php" style="color: white; text-decoration: none;">Logout</a></div>
    <div class="sidebar">
        <a href="admindashboard.php">Home</a>
        <a href="a_bookingstoday.php">View Today's Bookings</a>
        <a href="a_bookings.php">View All Bookings</a>
        <a href="a_searchbookings.php">Search Completed Bookings</a>
        <a href="a_cancellations.php">View Cancelled Bookings</a>
        <a href="a_vehicle.php">Add or Delete Vehicle</a>
        <a href="a_employee.php">Add or Delete Employee</a>
        <a href="a_reviews.php">Analyze Reviews</a>
    </div>
    <div class="container">
        <div class="content">
            <h3>Assign a Mechanic</h3>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Phone</th><th>Vehicle</th><th>Services</th><th>Mechanic Comments</th><th>Mechanic</th><th>Status</th><th>Actions <br> assign mechanic</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['bid']}</td>
                            <td>{$row['mname']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['vehicle']}</td>
                            <td>{$row['services']}</td>
                            <td>{$row['repair_comment']}</td>
                            <td>" . ($row['mechanic_name'] ? $row['mechanic_name'] : 'Not Assigned') . "</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form method='post'>Assign Mechanic<b/><br>
                                    <input type='hidden' name='bid' value='{$row['bid']}'>
                                    <select name='mechanic_id'>";
                                    $mech_query = "SELECT * FROM mechanic";
                                    $mech_result = $db->query($mech_query);
                                    while ($mech = $mech_result->fetch_assoc()) {
                                        echo "<option value='{$mech['id']}'>{$mech['name']}</option>";
                                    }
                                    echo "</select><br><br>
                                    <button type='submit' name='assign_mechanic' class='btn btn-assign'>Assign</button><br>
                                </form><br>
                                <a href='?complete={$row['bid']}' class='btn btn-complete'>Complete</a><br><br>
                                <a href='?cancel={$row['bid']}' class='btn btn-cancel'>Cancel</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
