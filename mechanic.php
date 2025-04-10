<?php
// Include server configuration and error handling files

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize variables to store form input
$name = $email = $address = $password = '';

// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your actual database username
$password = ""; // Replace with your actual database password
$dbname = "carbdb"; // Replace with your actual database name

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the mechanic already exists
    $check_stmt = $conn->prepare("SELECT id FROM mechanic WHERE email = ?");
    $check_stmt->bind_param("s", $_POST['email']);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Mechanic with this email already exists!";
    } else {
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO mechanic (name, email, address, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $address, $password);

        // Set parameters and execute only if form fields are not empty
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_POST['password'])) {
            $name = sanitize($_POST['name']);
            $email = sanitize($_POST['email']);
            $address = sanitize($_POST['address']);
            $password = sanitize($_POST['password']);

            // Execute the query
            if ($stmt->execute()) {
                echo "New mechanic added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "All fields are required!";
        }

        // Close statement
        $stmt->close();
    }

    // Close check statement and database connection
    $check_stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Mechanic</title>
    <link rel="stylesheet" type="text/css" href="css/barbcss.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
    <style>
        /* Sidebar styles */
        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #dee2e6;
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

        /* Main content styles */
        .main-content {
            padding: 20px;
        }

        .mechanic-list {
            margin-top: 20px;
            list-style-type: none;
            padding: 0;
        }

        .mechanic-item {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .mechanic-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .mechanic-table th,
        .mechanic-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        .mechanic-table th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<?php include('includes/adminnavbar.php'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="sidebar">
                <?php if(isset($_SESSION['ename'])): ?>
                    <a href="a_bookingstoday.php" class="linkb">View Today's Bookings</a>
                    <a href="a_bookings.php" class="linkb">View All Bookings</a>
                    <a href="a_searchbookings.php" class="linkb">Search Completed Bookings</a>
                    <a href="a_cancellations.php" class="linkb">View Cancelled Bookings</a>
                    <a href="a_vehicle.php" class="linkb">Add or Delete Vehicle</a>
                    <a href="a_employee.php" class="linkb">Add or Delete Employee</a>
                    <a href="mechanic.php" class="linkb">Add or view mechanics</a>
                    <a href="a_reviews.php" class="linkb">Analyze Reviews</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="container">
                <h2>Add Mechanic</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name"><br>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email"><br>
                    <label for="address">Address:</label><br>
                    <input type="text" id="address" name="address"><br>
                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password"><br><br>
                    <input type="submit" value="Submit">
                </form>

                <!-- Display list of mechanics -->
                <?php
                $servername = "localhost";
$username = "root"; // Replace with your actual database username
$password = ""; // Replace with your actual database password
$dbname = "barbdb";
                // Connect to the database
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check database connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to fetch mechanics
                $sql = "SELECT id, name, email, address FROM mechanic";
                $result = $conn->query($sql);

                // Display list of mechanics
                echo "<h2>List of Mechanics</h2>";
                echo "<table class='mechanic-table'>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Address</th></tr></thead>";
                echo "<tbody>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No mechanics found.</td></tr>";
                }
                echo "</tbody>";
                echo "</table>";

                // Close database connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</div>
<?php if(isset($_SESSION['mname'])): ?>
    Logged in as customer.
<?php endif; ?>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
