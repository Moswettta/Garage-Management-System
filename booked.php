<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <title>Service Nepal</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/barbcss.css">
  <?php include('includes/server.php');?>
  <?php include('includes/errors.php');?>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="js/vehiclesearchjs.js"></script>
  <style>
    .header {
      background-color: #007bff;
      padding: 10px 20px;
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

  <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <h4>Booking made successfully!</h4>
            <p>Your Booking Details:</p>
            <table class="table table-striped table-bordered table-sm" style="width:90%;">
                <?php
                    $phone=$_SESSION['phone'];
                    $sql = "SELECT * FROM bookings WHERE phone='$phone' ORDER BY bid DESC LIMIT 1";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<tr><th>Booking ID</th><td>" . $row["bid"]. "</td></tr><tr><th>Name</th><td>" . $row["mname"]. "</td></tr><tr><th>Phone</th><td>" . $row["phone"]. "</td></tr><tr><th>Email</th><td>" . $row["email"] . "</td></tr><tr><th>Servicing Date</th><td>" . $row["sdate"] . "</td></tr><tr><th>Drop-off Time</th><td>" . $row["dtime"] . "</td></tr><tr><th>Vehicle Model</th><td>" . $row["vehicle"] . "</td></tr><tr><th>Vehicle Number</th><td>" . $row["vehiclenum"] . "</td></tr><tr><th>Services Required</th><td>" . $row["services"] . "</td></tr><tr><th>Additional Comments</th><td>" . $row["comments"] . "</td></tr>";
                        echo "<tr><td colspan='2' class='text-center'><form method='POST' action=''><input type='hidden' name='bid' value='" . $row["bid"] . "'><button type='submit' name='cancel_booking' class='btn btn-danger'>Cancel Booking</button></form></td></tr>";
                    } else {
                        echo "<tr><td colspan='2'>No booking details found.</td></tr>";
                    }
                ?>
            </table>
        </div>
    </div>
  </div>
  
  <?php
    if (isset($_POST['cancel_booking'])) {
        $bid = $_POST['bid'];
        $cancel_sql = "DELETE FROM bookings WHERE bid='$bid'";
        if ($db->query($cancel_sql) === TRUE) {
            echo "<script>alert('Booking canceled successfully!'); window.location.href='member.php';</script>";
        } else {
            echo "<script>alert('Error canceling booking.');</script>";
        }
    }
  ?>
  
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
