<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Bookings</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body {
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }
    .header {
      width: 100%;
      background: #047a94;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 1.5em;
      font-weight: bold;
      position: fixed;
      top: 0;
      z-index: 1000;
    }
    .container {
      display: flex;
      width: 90%;
      max-width: 1200px;
      background: #fff;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow: hidden;
      margin-top: 80px;
    }
    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      padding-top: 20px;
      position: fixed;
      top: 80px;
      height: calc(100% - 90px);
      left: 0;
      overflow-y: auto;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      margin: 5px 0;
      transition: background-color 0.3s;
    }
    .sidebar a:hover {
      background-color: #34495e;
    }
    .sidebar p {
      color: white;
      padding: 10px;
      text-align: center;
    }
    .main-content {
      flex: 1;
      padding: 20px;
      background: white;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      margin-left: 250px;
      width: calc(100% - 250px);
    }
    h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .table-container {
      width: 100%;
      overflow-x: auto;
      margin-top: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #047a94;
      color: white;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #e6f7ff;
    }
    .no-results {
      text-align: center;
      padding: 20px;
      color: #666;
      font-style: italic;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        margin-top: 60px;
      }
      .sidebar {
        width: 100%;
        position: relative;
        top: auto;
        height: auto;
      }
      .main-content {
        margin-left: 0;
        width: 100%;
      }
      table {
        font-size: 0.9em;
      }
      th, td {
        padding: 8px 10px;
      }
    }
  </style>
</head>
<body>
  <div class="header">Admin Dashboard</div>
  <div class="container">
    <div class="sidebar">
      <h2>Admin Panel</h2>
      <a href="admindashboard.php" class="linkb">Home</a>
      <a href="a_bookingstoday.php">View Today's Bookings</a>
      <a href="a_bookings.php">View All Bookings</a>
      <a href="a_searchbookings.php">Search Completed Bookings</a>
      <a href="a_cancellations.php">View Cancelled Bookings</a>
      <a href="a_vehicle.php">Add or Delete Vehicle</a>
      <a href="a_employee.php">Add or Delete Employee</a>
      <a href="a_reviews.php">Analyze Reviews</a>
    </div>

    <div class="main-content">
      <?php include('includes/server.php');?>
      <?php include('includes/errors.php');?>
      
      <h3>Bookings on <?php $searchdate=$_POST['searchdate']; echo $searchdate; ?></h3>
      
      <div class="table-container">
        <table>
          <?php
            $sql = "SELECT * FROM archive WHERE sdate='$searchdate'";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                echo "<tr><th>Booking ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Servicing Date</th><th>Drop-off Time</th><th>Vehicle</th><th>Vehicle Number</th><th>Services Required</th><th>Comments</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["bid"]. "</td><td>" . $row["mname"]. "</td><td>" . $row["phone"]. "</td><td>" . $row["email"] . "</td><td>" . $row["sdate"] . "</td><td>" . $row["dtime"] . "</td><td>" . $row["vehicle"] . "</td><td>" . $row["vehiclenum"] . "</td><td>" . $row["services"] . "</td><td>" . $row["comments"] . "</td></tr>";
                }
            } else {
                echo '<tr><td colspan="10" class="no-results">0 results found</td></tr>';
            }
          ?>
        </table>
      </div>
    </div>
  </div>
  
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>