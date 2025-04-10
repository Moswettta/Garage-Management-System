<?php
// Include database connection
include('includes/conn.php'); 

// Ensure session is started only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['mname'])) {
    echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
    exit();
}

// Get the logged-in user's name
$mname = $_SESSION['mname'];

// Cancel booking
if (isset($_POST['cancel_booking'])) {
    $bid = mysqli_real_escape_string($conn, $_POST['bid']);
    $query = "DELETE FROM bookings WHERE bid='$bid'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking Cancelled Successfully!'); window.location.href='bookings.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch user bookings
$query = "SELECT * FROM bookings WHERE mname='$mname' ORDER BY sdate DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h2 {
            color: #007bff;
            text-align: center;
        }
        .cancel-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .cancel-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

 <div class="header">
   <h2><a href="members.php" style="color: white; text-decoration: none; background-color: transparent;">Home</a></h2>
          
      <div class="user-menu">
        <i class="fas fa-user-circle fa-2x"></i>
        <div class="dropdown-content">
          <a href="profile.php">Profile</a>
          <a href="logout.php">Log Out</a>
        </div>
      </div>
    </div>
  </div>

<div class="container">
    <h2>My Bookings</h2>
    <br>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Servicing Date</th>
                    <th>Time</th>
                    <th>Vehicle</th>
                    <th>Services</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['bid']); ?></td>
                        <td><?php echo htmlspecialchars($row['sdate']); ?></td>
                        <td><?php echo htmlspecialchars($row['dtime']); ?></td>
                        <td><?php echo htmlspecialchars($row['vehicle']) . " (" . htmlspecialchars($row['vehiclenum']) . ")"; ?></td>
                        <td><?php echo htmlspecialchars($row['services']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="bid" value="<?php echo htmlspecialchars($row['bid']); ?>">
                                <button type="submit" name="cancel_booking" class="cancel-btn">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No bookings found.</p>
    <?php } ?>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
