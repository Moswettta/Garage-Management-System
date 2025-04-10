<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Mechanics</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
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
    .container {
      display: flex;
      min-height: 100vh;
      padding-top: 70px;
    }
    
    /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background: #2c3e50;
      padding: 20px;
      position: fixed;
      height: calc(100vh - 70px);
      overflow-y: auto;
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
      margin-left: 250px;
      padding: 30px;
      background-color: #f5f7fa;
    }
    
    .content-section {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 25px;
      margin-bottom: 30px;
    }
    
    .content-section h3 {
      color: #047a94;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #047a94;
    }
    
    /* Form Styles */
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #555;
    }
    
    .form-group input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1em;
      transition: border-color 0.3s;
    }
    
    .form-group input:focus {
      border-color: #047a94;
      outline: none;
      box-shadow: 0 0 0 2px rgba(4, 122, 148, 0.2);
    }
    
    .btn {
      background: linear-gradient(135deg, #047a94, #035f75);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1em;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn:hover {
      background: linear-gradient(135deg, #035f75, #024b5d);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #e74c3c, #c0392b);
    }
    
    .btn-danger:hover {
      background: linear-gradient(135deg, #c0392b, #a5281b);
    }
    
    /* Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    th {
      background: linear-gradient(135deg, #047a94, #035f75);
      color: white;
      padding: 12px 15px;
      text-align: left;
    }
    
    td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
    }
    
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    
    tr:hover {
      background-color: #f1f9fb;
    }
    
    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-size: 0.9em;
      margin-right: 5px;
      transition: all 0.3s;
    }
    
    .delete-btn {
      background-color: #e74c3c;
      color: white;
    }
    
    .delete-btn:hover {
      background-color: #c0392b;
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      
      .sidebar {
        width: 100%;
        position: relative;
        height: auto;
      }
      
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    Admin Panel 
    <a href="logout.php">Logout</a>
  </div>
  
  <div class="container">
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
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "carbdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete mechanic via GET (from table)
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    $sql = "DELETE FROM mechanic WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Mechanic deleted successfully.');</script>";
    } else {
        echo "Error deleting mechanic: " . $conn->error;
    }
}

// Delete mechanic via POST (form)
if (isset($_POST['delete_mechanic'])) {
    $id = intval($_POST['mechanic_id']);

    $sql = "DELETE FROM mechanic WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Mechanic deleted successfully.');</script>";
    } else {
        echo "Error deleting mechanic: " . $conn->error;
    }
}

// Insert mechanic
if (isset($_POST['add_mechanic'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']); // Now using form value

    $sql = "INSERT INTO mechanic (name, email, address, password) 
            VALUES ('$name', '$email', '$address', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Mechanic added successfully.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Add Mechanic Form -->
<div class="content-section">
  <h3>Add New Mechanic</h3>
  <form method="POST" action="">
    <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn" name="add_mechanic">Add Mechanic</button>
  </form>
</div>


<!-- Mechanics Table -->
<div class="content-section">
  <h3>All Mechanics</h3>
  <table id="mechanics-table" class="display">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql = "SELECT * FROM mechanic";
        $result = $conn->query($sql); // fixed: use $conn not $db
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["address"] . "</td>
                        <td>
                          <a href='?delete_id=" . $row["id"] . "' class='action-btn delete-btn' onclick=\"return confirm('Are you sure you want to delete this mechanic?');\">
                            <i class='fas fa-trash-alt'></i> Delete
                          </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align: center;'>No mechanics found</td></tr>";
        }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#mechanics-table').DataTable();
  });
</script>
</body>
</html>
