<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Garage Management System Admin Panel</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <?php 
    // Database connection
    include('includes/server.php'); 
    include('includes/errors.php'); 
    $db = mysqli_connect('localhost', 'root', '', 'carbdb');

    if (!$db) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    if(isset($_SESSION['ename'])) {
        function getCount($db, $table) {
            $query = "SELECT COUNT(*) as count FROM $table";
            $result = mysqli_query($db, $query);
            if (!$result) {
                die("Query failed for $table: " . mysqli_error($db));
            }
            $row = mysqli_fetch_assoc($result);
            return $row['count'] ?? 0;
        }

        $mechanics_count = getCount($db, "mechanic");
        $members_count = getCount($db, "members");
        $cars_serviced_count = getCount($db, "vehicles");
    }
  ?>

  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
    .header { background: #047a94; color: white; padding: 15px; text-align: center; font-size: 1.5em; }
    .sidebar { 
        width: 250px; 
        background: #2c3e50; 
        padding: 15px; 
        position: fixed; 
        height: 100%;
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
    .main-content { margin-left: 270px; padding: 20px; }
    .dashboard-cards { display: flex; gap: 20px; }
    .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); text-align: center; flex: 1; transition: 0.3s; }
    .card:hover { transform: scale(1.05); box-shadow: 4px 4px 15px rgba(0,0,0,0.2); }
    .card h3 { color: #2c3e50; }
    .card p { font-size: 2em; font-weight: bold; color: #3498db; }
  </style>
</head>
<body>
  <div class="header">Garage Management System Admin Panel</div>
  
  <div class="sidebar">
    <?php if(isset($_SESSION['ename'])): ?>
      <a href="admin.php" class="linkb">Dashboard</a>
      <a href="a_bookingstoday.php" class="linkb">View Today's Bookings</a>
      <a href="a_bookings.php" class="linkb">View All Bookings</a>
      <a href="a_searchbookings.php" class="linkb">Search Completed Bookings</a>
      <a href="a_cancellations.php" class="linkb">View Cancelled Bookings</a>
      <a href="a_vehicle.php" class="linkb">Add or Delete Vehicle</a>
      <a href="a_employee.php" class="linkb">Add or Delete Employee</a>
      <a href="addmember.php" class="linkb">View Members</a>
      <a href="addmember.php" class="linkb">Add Member</a>
      <a href="mechanic.php" class="linkb">Add or View Mechanics</a>
      <a href="a_reviews.php" class="linkb">Analyze Reviews</a>
      <a href="assign_mechanic.php" class="linkb">Assign Mechanic</a>
    <?php else: ?>
      <p>Please log in to view the admin panel.</p>
    <?php endif; ?>
  </div>

  <div class="main-content">
    <?php if(isset($_SESSION['ename'])): ?>
      <div class="dashboard-cards">
        <div class="card">
          <h3>Mechanics</h3>
          <p><?php echo $mechanics_count; ?></p>
        </div>
        <div class="card">
          <h3>Members</h3>
          <p><?php echo $members_count; ?></p>
        </div>
        <div class="card">
          <h3>Cars Serviced</h3>
          <p><?php echo $cars_serviced_count; ?></p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
