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
    }
    .container {
      display: flex;
      width: 90%;
      max-width: 1200px;
      background: #fff;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            padding-top: 20px;
            position: fixed;
            top: 80px; /* Push sidebar below the header */
            height: calc(100% - 90px); /* Ensure it takes full height minus header */
            left: 0;
            overflow-y: auto; /* Allows scrolling if the sidebar content overflows */
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
    }
    h3 {
      text-align: center;
      margin-bottom: 20px;
    }
    .search-form {
      display: flex;
      justify-content: center;
      gap: 10px;
    }
    .search-form input, .search-form button {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1em;
    }
    .search-form button {
      background: #047a94;
      color: white;
      cursor: pointer;
      border: none;
      padding: 10px 15px;
    }
    .search-form button:hover {
      background: #035f73;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        text-align: center;
      }
      .search-form {
        flex-direction: column;
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
      <h3>Search Bookings</h3>
      <form action="a_searchedbookings.php" method="post" class="search-form">
        <input type="date" name="searchdate" required>
        <button type="submit" name="searchbookings">Search</button>
      </form>
    </div>
  </div>
</body>
</html>
