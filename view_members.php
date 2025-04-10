<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Members</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
  <?php include('includes/server.php'); ?>
  <?php include('includes/errors.php'); ?>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      color: #333;
    }
    .header {
      width: 100%;
      background: #047a94;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 1.5em;
      font-weight: bold;
    }
    
    .container {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
    }
    .sidebar .hdr {
      font-size: 1.5em;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 5px;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #1a252f;
    }
    .main-content {
      flex: 1;
      padding: 20px;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 20px;
      border-radius: 8px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #2c3e50;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .delete-btn {
      color: red;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }
    .delete-btn:hover {
      color: darkred;
    }
  </style>
</head>
<body>
  <div class="header">Admin Panel | <a href="logout.php" style="color: white; text-decoration: none;">Logout</a></div>
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
      <a href="a_members.php">View Members</a> <!-- Updated sidebar link -->
    </div>
    <div class="main-content">
      <h3 align="center">All Members</h3>
      <table id="table_id" class="display">
        <?php
          // Delete member functionality
          if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            // Perform deletion query
            $delete_sql = "DELETE FROM members WHERE mid = ?";
            $stmt = $db->prepare($delete_sql);
            $stmt->bind_param("i", $delete_id);  // "i" means integer
            if ($stmt->execute()) {
              // Successfully deleted, show message
              echo "<script>alert('Member deleted successfully');</script>";
            } else {
              echo "<script>alert('Error deleting record');</script>";
            }
            // Close the prepared statement
            $stmt->close();
          }

          // Fetch members from the database
          $sql = "SELECT * FROM members";  // Assuming you have a 'members' table
          $result = $db->query($sql);
          if ($result->num_rows > 0) {
              echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Password</th><th>Action</th></tr></thead><tbody>";
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>" . $row["mid"]. "</td><td>" . $row["mname"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone"] . "</td><td>" . $row["password"] . "</td>
                        <td><a href=view_members.php?delete_id=" . $row['mid'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this member?\")'>Delete</a></td></tr>";
              }
              echo "</tbody>";
          } else {
              echo "<tr><td colspan='6' align='center'>No members found</td></tr>";
          }
        ?>
      </table>
    </div>
  </div>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      new DataTable("#table_id");
    });
  </script>
</body>
</html>
