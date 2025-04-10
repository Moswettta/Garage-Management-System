<?php
session_start();
include 'db.php'; // Database connection

// Check if the mechanic is logged in
if (!isset($_SESSION['mechanic_id']) || !isset($_SESSION['mechanic_name'])) {
    header("Location: mechanic_login.php");
    exit();
}

$mechanic_id = $_SESSION['mechanic_id'];
$mechanic_name = $_SESSION['mechanic_name'];

// Fetch assigned bookings for the logged-in mechanic
$sql = "SELECT * FROM bookings WHERE mechanic_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle form submission for updating repair status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $repair_status = $_POST['repair_status'];
    $repair_comment = $_POST['repair_comment'];

    // Update the database
    $update_sql = "UPDATE bookings SET status = ?, repair_comment = ? WHERE bid = ?";
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->bind_param("ssi", $repair_status, $repair_comment, $booking_id);
    $update_stmt->execute();

    header("Location: mechanic_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanic Dashboard</title>
    <link rel="stylesheet" href="css/custom_styles.css"> <!-- External CSS -->
</head>
<body>
<header>
    <div class="header-left">
        <a href="mechanic_dashboard.php" class="btn">Home</a>
        
    </div>
    <div class="header-center">
        <h1>Mechanic Dashboard</h1>
    </div>
    <div class="header-right">
        <span class="mechanic-name">Welcome, <?php echo htmlspecialchars($mechanic_name); ?>!</span>
        <a href="mechaniclogin.php" class="btn logout">Log Out</a>
    </div>
</header>

<style>
/* GENERAL PAGE STYLING */
body {
    background-color: #eef2f3;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* 🔹 HEADER STYLING */
header {
    background-color: #003366;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
}

.header-left, .header-right {
    display: flex;
    align-items: center;
}

.header-center h1 {
    margin: 0;
    font-size: 22px;
    text-align: center;
}

.mechanic-name {
    font-size: 14px;
    margin-right: 15px;
}

.btn {
    background-color: #0056b3;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    margin: 0 5px;
    border-radius: 5px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #004080;
}

.logout {
    background-color: #dc3545;
}

.logout:hover {
    background-color: #a82833;
}

/* 🔹 TABLE STYLING */
.container {
    max-width: 95%;
    margin: 30px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    font-size: 24px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background: #003366;
    color: white;
    font-size: 14px;
    text-transform: uppercase;
}

/* STATUS COLORS */
.status-active {
    color: #28a745;
    font-weight: bold;
}

.status-repaired {
    color: #007bff;
    font-weight: bold;
}

.status-not-repaired {
    color: #dc3545;
    font-weight: bold;
}

/* FORM STYLING */
.update-status form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.update-status select, 
.update-status textarea, 
.update-status button {
    margin: 5px 0;
    padding: 8px;
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.update-status button {
    background-color: #003366;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
    padding: 8px 15px;
    border-radius: 5px;
}

.update-status button:hover {
    background-color: #001f4d;
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }
}
</style>

<div class="container">
    <h2>Assigned Bookings</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Servicing Date</th>
                <th>Drop-off Time</th>
                <th>Vehicle</th>
                <th>User Comment</th>
                <th>Status</th>
                <th>Update Repair Status</th>
                <th>Mechanic Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status_class = ($row['status'] == 'Repaired') ? 'status-repaired' : (($row['status'] == 'Not Repaired') ? 'status-not-repaired' : 'status-active');

                    echo "<tr>";
                    echo "<td>{$row['bid']}</td>";
                    echo "<td>{$row['mname']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['sdate']}</td>";
                    echo "<td>{$row['dtime']}</td>";
                    echo "<td>{$row['vehicle']}</td>";
                    echo "<td class='user-comment'>{$row['comments']}</td>";
                    echo "<td class='$status_class'>{$row['status']}</td>";
                    echo "<td class='update-status'>
                            <form method='post'>
                                <input type='hidden' name='booking_id' value='{$row['bid']}'>
                                <select name='repair_status' required>
                                    <option value='Active' " . ($row['status'] == 'Active' ? 'selected' : '') . ">Active</option>
                                    <option value='Repaired' " . ($row['status'] == 'Repaired' ? 'selected' : '') . ">Repaired</option>
                                    <option value='Not Repaired' " . ($row['status'] == 'Not Repaired' ? 'selected' : '') . ">Not Repaired</option>
                                </select>
                                <textarea name='repair_comment' placeholder='Enter repair comment'>{$row['repair_comment']}</textarea>
                                <button type='submit' name='update_status'>Update</button>
                            </form>
                        </td>";
                    echo "<td>{$row['repair_comment']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11' class='no-bookings'>No bookings assigned yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
