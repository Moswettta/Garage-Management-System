<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/barbcss.css" rel="stylesheet">
  <title>Analyze Reviews</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.css"/>

  <?php include('includes/server.php');?>
  <?php include('includes/errors.php');?>
  <style>
    .footer {
      left: 0;
      bottom: 0;
      width: 100%;
      text-align: center;
    }
    table#table_id.dataTable tbody tr.Highlight > .sorting_1 {
      background-color: #FFBFBF !important;
    }
    table#table_id.dataTable tbody tr.Highlight {
        background-color: #FFBFBF !important;
    }
    table#table_id.dataTable tbody tr.HighlightG > .sorting_1 {
      background-color: #B1F3B1 !important;
    }
    table#table_id.dataTable tbody tr.HighlightG {
        background-color: #B1F3B1 !important;
    }
    /* Sidebar styles */
    .sidebar {
      background-color: #f8f9fa;
      padding: 20px;
      border-right: 1px solid #dee2e6; /* Add border-right */
      height: 100vh; /* Make sidebar full height */
    }
    .sidebar .hdr {
      background-color: #047a94;
      color: white;
      padding: 10px 20px;
      font-weight: bold;
      font-size: 1.2em;
      margin-bottom: 15px;
    }
    .sidebar .linkb {
      display: block;
      color: #047a94;
      padding: 5px 20px;
      margin-bottom: 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .sidebar .linkb:hover {
      background-color: #047a94;
      color: white;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <?php include('includes/adminnavbar.php'); ?>

  <!-- Sidebar -->
  <div class="col-sm-3 sidebar">
    <div class="hdr">Admin Panel</div>
     <a href="admindashboard.php" class="linkb">Home</a>
    <a href="a_bookingstoday.php" class="linkb">View Today's Bookings</a>
    <a href="a_bookings.php" class="linkb">View All Bookings</a>
    <a href="a_searchbookings.php" class="linkb">Search Completed Bookings</a>
    <a href="a_cancellations.php" class="linkb">View Cancelled Bookings</a>
    <a href="a_vehicle.php" class="linkb">Add or Delete Vehicle</a>
    <a href="a_employee.php" class="linkb">Add or Delete Employee</a>
    <a href="a_reviews.php" class="linkb">Analyze Reviews</a>
  </div>

  <!-- Main content -->
  <div class="container-fluid">
    <div class="row" style="margin: 15px;">
      <h3 align="center" style="margin-bottom: 40px;">Reviews</h3>
      <table id="table_id" class="display">
        <?php
          $sql = "SELECT * FROM reviews";
          $result = $db->query($sql);

          if ($result->num_rows > 0) {
              echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Review Content</th><th>Review Date</th><th style=\"display:none\">Score</th><th>Actions</th><th></th></tr></thead><tbody>";
              // output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr><td>" . $row["rid"]. "</td><td>" . $row["mname"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone"]. "</td><td>" . $row["rcontent"] . "</td><td>" . $row["rdate"] . "</td><td style=\"display:none\">" . $row["score"] . "</td><td><a href=\"a_reviews.php?deletereview=" . $row['rid'] . "\">Delete</a></td><td><a href=\"mailto:". $row["email"] ."\">Send Email</a></td></tr>";
              }
          } else {
              echo "0 results";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
  <script type="text/javascript">
    $(document).ready( function () {
      var table = $('#table_id').DataTable({
        createdRow: function (row, data, dataIndex, cells) {
          if (data[6] === '0') {
            $(row).addClass('Highlight');
          }
          if (data[6] === '1') {
            $(row).addClass('HighlightG');
          }
        }
      });
    } );
  </script>
</body>
</html>
