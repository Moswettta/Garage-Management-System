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
        }
        .header {
            background-color: #047a94;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5em;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            padding: 15px;
            color: white;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
            background: #34495e;
        }
        .sidebar a:hover {
            background: #1abc9c;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
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
        .filter-section {
            margin-bottom: 20px;
        }
        .filter-section select, .filter-section input, .filter-section button {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .delete-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
    <?php include('includes/server.php'); ?>
    <?php include('includes/errors.php'); ?>
</head>
<body>
    <div class="header">Admin - View All Bookings</div>
    <div class="container">
        <div class="sidebar">
            <p class="hdr">Admin Panel</p>
            
             <a href="admindashboard.php" class="linkb">Home</a>
            <a href="a_bookingstoday.php">View Today's Bookings</a>
            <a href="a_bookings.php">View All Bookings</a>
            <a href="a_searchbookings.php">Search Completed Bookings</a>
            <a href="a_cancellations.php">View Cancelled Bookings</a>
            <a href="a_vehicle.php">Add or Delete Vehicle</a>
            <a href="a_employee.php">Add or Delete Employee</a>
            <a href="a_reviews.php">Analyze Reviews</a>
            <a href="a_reviews.php">Log Out</a>

        </div>
        <div class="main-content">
            <h3 align="center">All Bookings</h3>
            <div class="filter-section">
                <form method="GET">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="year" min="2000" max="2100" placeholder="YYYY">
                    <label for="month">Month:</label>
                    <input type="number" name="month" id="month" min="1" max="12" placeholder="MM">
                    <label for="date">Date:</label>
                    <input type="date" name="date" id="date">
                    <button type="submit">Apply</button>
                </form>
            </div>
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
                    $conditions = [];
                    if (!empty($_GET['year'])) {
                        $conditions[] = "YEAR(sdate) = '" . $_GET['year'] . "'";
                    }
                    if (!empty($_GET['month'])) {
                        $conditions[] = "MONTH(sdate) = '" . $_GET['month'] . "'";
                    }
                    if (!empty($_GET['date'])) {
                        $conditions = ["sdate = '" . $_GET['date'] . "'"];
                    }
                    $sql = "SELECT a.*, m.name AS mechanic_name FROM archive a LEFT JOIN mechanic m ON a.mechanic_id = m.id";
                    if ($conditions) {
                        $sql .= " WHERE " . implode(" AND ", $conditions);
                    }
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
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
                                    <td>{$row['mechanic_name']}</td>
                                    <td><form method='POST'><input type='hidden' name='delete_id' value='{$row['bid']}'><button type='submit' class='delete-btn'>Delete</button></form></td>
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
