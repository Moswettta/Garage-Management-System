<?php
// Starting the session, necessary for using session variables
session_start();

// DBMS connection code -> hostname, username, password, database name
$db = mysqli_connect('localhost', 'root', '', 'carbdb');

// Fetch members data from the "members" table
$sql = "SELECT * FROM members";
$result = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Members</title>
    <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
    <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .header {
            background: #047a94;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5em;
        }
    .container-fluid {
      padding: 20px;
    }
    .row {
      display: flex;
      justify-content: center;
      margin-top: 20px;
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
    
    /* Main Content Styles */
    .main-content {
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      width: 35%;
    }
    .header h2 {
      margin-bottom: 20px;
    }
    .input-group {
      margin-bottom: 15px;
    }
    .input-group label {
      display: block;
      font-weight: bold;
    }
    .input-group input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .barbbutton {
      background-color: #047a94;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .barbbutton:hover {
      background-color: #035f75;
    }
    
    /* Table Styles */
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .table th, .table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    .table th {
      background-color: #047a94;
      color: white;
    }
    .table a {
      color: red;
      text-decoration: none;
    }
    .table a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
    <div class="header">Member Management System</div>
    <div class="container">
        <div class="sidebar">
            <?php if(isset($_SESSION['ename'])): ?>
                <a href="admindashbord.php" class="linkb">Home</a>
                <a href="a_bookingstoday.php" class="linkb">View Today's Bookings</a>
                <a href="a_bookings.php" class="linkb">View All Bookings</a>
                <a href="a_searchbookings.php" class="linkb">Search Completed Bookings</a>
                <a href="a_cancellations.php" class="linkb">View Cancelled Bookings</a>
                <a href="a_vehicle.php" class="linkb">Add or Delete Vehicle</a>
                <a href="a_employee.php" class="linkb">Add or Delete Employee</a>
                <a href="mechanic.php" class="linkb">Add or view mechanics</a>
                <a href="a_reviews.php" class="linkb">Analyze Reviews</a>
            <?php endif; ?>
        </div>
        <div class="main-content">
            <h2>View Members</h2>
            <table class="member-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row["mid"]; ?></td>
                            <td><?php echo $row["mname"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>