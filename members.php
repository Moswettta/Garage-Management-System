<?php
session_start();
include 'db.php'; // Include database connection

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM archive WHERE bid='$delete_id'";
    if ($db->query($delete_sql) === TRUE) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='mechanic_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $db->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Garage Management System</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #d3d3d3; /* Grey background color */
    }
    .header {
      background-color: #007bff;
      padding: 5px 10px; /* Reduced padding */
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
    }
    .user-menu {
      position: relative;
      display: inline-block;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: white;
      min-width: 120px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 1;
    }
    .dropdown-content a {
      color: black;
      padding: 10px;
      text-decoration: none;
      display: block;
    }
    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }
    .user-menu:hover .dropdown-content {
      display: block;
    }
    .container {
      width: 90%;
      margin: 20px auto;
      padding: 20px;
      background: white;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: #007bff;
      color: white;
      text-align: center;
      padding: 10px;
    }
    .btn {
      background-color: #007bff;
      color: white;
      padding: 5px 10px; /* Smaller button size */
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
    }
    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="header">
   <h2><a href="members.php" style="color: white; text-decoration: none; background-color: transparent;">Home</a></h2>
    <div>
      <a href="bookings.php" class="btn">Show Bookings</a>
      <div class="user-menu">
        <i class="fas fa-user-circle fa-2x"></i>
        <div class="dropdown-content">
          <a href="profile.php">Profile</a>
          <a href="login.php">Log Out</a>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <h4>Hello <?php echo $_SESSION['mname']; ?></h4>
    <p>Your Servicing History:</p>
    <table>
      <tr>
        <th>Booking ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Servicing Date</th><th>Drop-off Time</th><th>Vehicle</th><th>Vehicle Number</th><th>Services Required</th><th>Comments</th><th>Mechanic Comment</th><th>Status</th><th>Assigned Mechanic</th><th>Action</th>
      </tr>
      <?php
      $phone = $_SESSION['phone'];
      $sql = "SELECT a.*, m.name AS mechanic_name FROM archive a LEFT JOIN mechanic m ON a.mechanic_id = m.id WHERE a.phone='$phone'";
      $result = $db->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
                  <td>{$row['repair_comment']}</td>
                  <td>{$row['status']}</td>
                  <td>{$row['mechanic_name']}</td>
                  <td>
                    <form method='POST'>
                      <input type='hidden' name='delete_id' value='{$row['bid']}'>
                      <button type='submit' name='delete' class='delete-btn'>Delete</button>
                    </form>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='14'>No records found.</td></tr>";
      }
      ?>
    </table>
  </div>
  <div class="footer">
    <a href="booking.php" style="background-color: orange; color: white; padding: 8px 15px; text-decoration: none; font-size: 14px; border-radius: 5px; display: inline-block;">Make A Booking</a>

  </div>
</body>
</html>
