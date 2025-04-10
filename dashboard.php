




<?php
// Include database connection
include 'db.php';

// Fetch data from the "archive" table
$sql = "SELECT * FROM archive";
$result = $db->query($sql);

?>

 
    <h2>Dashboard</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Service Date</th>
                <th>Service Time</th>
                <th>Vehicle</th>
                <th>Vehicle Number</th>
                <th>Services</th>
                <th>Comments</th>
                <th>Status</th>
                <th>Mechanic ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["bid"]."</td>";
                echo "<td>".$row["mname"]."</td>";
                echo "<td>".$row["phone"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["sdate"]."</td>";
                echo "<td>".$row["dtime"]."</td>";
                echo "<td>".$row["vehicle"]."</td>";
                echo "<td>".$row["vehiclenum"]."</td>";
                echo "<td>".$row["services"]."</td>";
                echo "<td>".$row["comments"]."</td>";
                echo "<td>".$row["status"]."</td>";
                echo "<td>".$row["mechanic_id"]."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close database connection
$db->close();
?>
