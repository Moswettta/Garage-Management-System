<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Item</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <?php include('includes/server.php'); ?>
  <?php include('includes/errors.php'); ?>
  <style>
    /* General Styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
      color: #333;
      line-height: 1.6;
    }
    
    /* Header Styles */
    .header {
      background: linear-gradient(135deg, #047a94, #035f75);
      color: white;
      padding: 15px 20px;
      text-align: center;
      font-size: 1.5em;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .header a {
      color: white;
      text-decoration: none;
      font-size: 0.8em;
      padding: 5px 10px;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    
    .header a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }
    
    /* Container Styles */
    .container-fluid {
      padding: 20px;
      margin-top: 70px;
    }
    
    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    
    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background: #2c3e50;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      height: fit-content;
    }
    
    .sidebar .hdr {
      color: white;
      font-size: 1.3em;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #34495e;
      text-align: center;
    }
    
    .sidebar a {
      display: block;
      color: #ecf0f1;
      padding: 12px 15px;
      text-decoration: none;
      margin-bottom: 8px;
      border-radius: 5px;
      transition: all 0.3s ease;
      background-color: #34495e;
    }
    
    .sidebar a:hover {
      background-color: #3d566e;
      transform: translateX(5px);
    }
    
    /* Main Content Styles */
    .main-content {
      flex: 1;
      min-width: 300px;
      max-width: 500px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 25px;
      margin-bottom: 20px;
    }
    
    .main-content .header {
      position: static;
      background: none;
      color: #047a94;
      padding: 0;
      margin-bottom: 20px;
      text-align: left;
      box-shadow: none;
      display: block;
      width: auto;
    }
    
    .main-content .header h2 {
      font-size: 1.5em;
      margin-bottom: 5px;
      color: #047a94;
      border-bottom: 2px solid #047a94;
      padding-bottom: 10px;
    }
    
    /* Form Styles */
    .input-group {
      margin-bottom: 20px;
    }
    
    .input-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #555;
    }
    
    .input-group input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1em;
      transition: border-color 0.3s;
    }
    
    .input-group input:focus {
      border-color: #047a94;
      outline: none;
      box-shadow: 0 0 0 2px rgba(4, 122, 148, 0.2);
    }
    
    .barbbutton {
      background: linear-gradient(135deg, #047a94, #035f75);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1em;
      font-weight: 600;
      transition: all 0.3s;
      width: 100%;
    }
    
    .barbbutton:hover {
      background: linear-gradient(135deg, #035f75, #024b5d);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Table Styles */
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table th {
      background: linear-gradient(135deg, #047a94, #035f75);
      color: white;
      padding: 12px 15px;
      text-align: left;
    }
    
    .table td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
    }
    
    .table tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    
    .table tr:hover {
      background-color: #f1f9fb;
    }
    
    .table a {
      color: #e74c3c;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }
    
    .table a:hover {
      color: #c0392b;
      text-decoration: underline;
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
      .row {
        flex-direction: column;
      }
      
      .sidebar {
        width: 100%;
        margin-bottom: 20px;
      }
      
      .main-content {
        width: 100%;
      }
      
      .header {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    Admin Panel 
    <a href="logout.php">Logout</a>
  </div>
  
  <div class="container-fluid">
    <div class="row">
      <div class="sidebar">
        <div class="hdr">Admin Panel</div>
        <a href="admindashboard.php" class="linkb">Home</a>
        <a href="a_bookingstoday.php" class="linkb">View Today's Bookings</a>
        <a href="a_bookings.php" class="linkb">View All Bookings</a>
        <a href="a_searchbookings.php" class="linkb">Search Completed Bookings</a>
        <a href="a_cancellations.php" class="linkb">View Cancelled Bookings</a>
        <a href="a_vehicle.php" class="linkb">Add or Delete Vehicle</a>
        <a href="a_employee.php" class="linkb">Add or Delete Employee</a>
        <a href="REPORTS.php" class="linkb">Reports</a>
        <a href="admn.php">Log Out</a>
      </div>
      
      <div class="main-content">
        <div class="header">
          <h2>Add Vehicle</h2>
        </div>
        <form method="POST">
          <div class="input-group">
            <label>Vehicle Make</label>
            <input type="text" name="vmake" required>
          </div>
          <div class="input-group">
            <label>Vehicle Model</label>
            <input type="text" name="vmodel" required>
          </div>
          <div class="input-group">
            <button type="submit" class="barbbutton" name="addvehicle">Add Vehicle</button>
          </div>
        </form>
      </div>
      
      <div class="main-content">
        <div class="header">
          <h2>Delete Vehicle</h2>
        </div>
        <table class="table">
          <?php
            $sql = "SELECT * FROM vehicles ORDER BY vmake";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                echo "<tr><th>Make</th><th>Model</th><th>Actions</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["vmake"]. "</td><td>" . $row["vmodel"]. "</td><td><a href='a_vehicle.php?delvmake=" . $row['vmake'] . "&delvmodel=" .$row['vmodel'] . "'><i class='fas fa-trash-alt'></i> Delete</a></td></tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align: center; padding: 20px; color: #777;'>No vehicles found</td></tr>";
            }
          ?>
        </table>
      </div>
    </div>
  </div>
</body>
</html>