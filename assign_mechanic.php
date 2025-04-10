<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/barbcss.css" rel="stylesheet">
  <title>Assign Mechanic</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <?php include('includes/server.php');?>
  <?php include('includes/errors.php');?>
  <style>
  .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;
  }
  </style>
</head>
<body>
  <?php include('includes/adminnavbar.php'); ?>
  <div class="container-fluid">
    <div class="row" style="margin: 15px;">
      <h3 align="center" style="margin-bottom: 40px;">Assign Mechanic</h3>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="mb-3">
          <label for="booking_id" class="form-label">Booking ID:</label>
          <input type="text" class="form-control" id="booking_id" name="booking_id" required>
        </div>
        <div class="mb-3">
          <label for="mechanic_id" class="form-label">Mechanic:</label>
          <select class="form-select" id="mechanic_id" name="mechanic_id" required>
            <option value="">Select Mechanic</option>
            <?php
            $sql = "SELECT * FROM mechanic";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            }
            ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" name="assign_mechanic">Assign</button>
      </form>
      <?php
      if(isset($_POST['assign_mechanic'])) {
          $booking_id = $_POST['booking_id'];
          $mechanic_id = $_POST['mechanic_id'];

          // Update the booking with the assigned mechanic
          $update_sql = "UPDATE archive SET mechanic_id='$mechanic_id' WHERE bid='$booking_id'";
          if ($db->query($update_sql) === TRUE) {
              echo "<p class='text-success'>Mechanic assigned successfully!</p>";
          } else {
              echo "<p class='text-danger'>Error: " . $db->error . "</p>";
          }
      }
      ?>
    </div>
  </div>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
