<?php
error_reporting(0);
session_start();
include('includes/server.php'); // Ensure this file has a valid database connection



// Check if the user is logged in
if (!isset($_SESSION['mname'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's details
$mname = $_SESSION['mname'];
$query = "SELECT * FROM members WHERE mname=?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $mname);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if (isset($_POST['update'])) {
    $name = $_POST['mname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = md5($password); // Consistent with login system
        $update_query = "UPDATE members SET mname=?, email=?, phone=?, password=? WHERE mname=?";
        $stmt = $db->prepare($update_query);
        $stmt->bind_param("sssss", $name, $email, $phone, $password, $mname);
    } else {
        $update_query = "UPDATE members SET mname=?, email=?, phone=? WHERE mname=?";
        $stmt = $db->prepare($update_query);
        $stmt->bind_param("ssss", $name, $email, $phone, $mname);
    }

    if ($stmt->execute()) {
        $_SESSION['mname'] = $name; // Update session name
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/barbcss.css">
    <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
</head>
<style>
 /* General Styles */
/* General Styles */
body {
    font-family: 'Poppins', sans-serif; /* Modern font */
    margin: 0;
    padding: 0;
    background-color: #f4f4f4; /* Soft grey */
    color: #333;
}

/* Header Styling */
.header {
    background-color: #007bff;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
}

.header h2 a {
    color: white;
    text-decoration: none;
    font-size: 22px;
    font-weight: 600;
}

/* User Menu Dropdown */
.user-menu {
    position: relative;
    display: inline-block;
    margin-left: 15px;
    cursor: pointer;
}

.user-menu i {
    color: white;
    font-size: 24px;
    transition: 0.3s ease;
}

.user-menu:hover i {
    color: #f8f9fa;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 35px;
    background-color: white;
    min-width: 140px;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    opacity: 0;
    transform: translateY(-5px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.dropdown-content a {
    color: black;
    padding: 12px 15px;
    text-decoration: none;
    display: block;
    font-size: 15px;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.user-menu:hover .dropdown-content {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Page Layout */
.container-fluid {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Centers vertically */
    margin-top: 80px; /* Pushes below header */
}

/* Edit Profile Form */
.col-sm-3 {
    width: 320px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Form Headings */
h3 {
    margin-bottom: 15px;
    font-size: 18px;
}

/* Form Controls */
.form-control {
    margin-bottom: 10px;
    text-align: left;
}

.form-control label {
    font-size: 14px;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.form-control input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

/* Update Button */
.barbbutton {
    width: 100%;
    padding: 8px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    font-size: 14px;
    cursor: pointer;
}

.barbbutton:hover {
    background-color: #0056b3;
}




  </style>
</head>
<body>
  <div class="header">
   <h2><a href="members.php" style="color: white; text-decoration: none; background-color: transparent;">Home</a></h2>
    <div>
      <a href="bookings.php" class="btn">Show Bookings</a>
      <div class="user-menu">
        <i class="fas fa-user-circle fa-2x"></i>
        <div class="dropdown-content">
          <a href="profile.php">Profile</a>
          <a href="login.php">Log Out</a>
        </div>
      </div>
    </div>
  </div>

<div class="container-fluid">
    <div class="col-sm-3">
        <h3>Edit Profile</h3>
        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?> </p>
        <?php endif; ?>
        <form method="post">
            <div class="form-control">
                <label><b>Name</b></label>
                <input type="text" name="mname" value="<?php echo htmlspecialchars($user['mname']); ?>" required>
            </div>
            <div class="form-control">
                <label><b>Email</b></label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-control">
                <label><b>Phone</b></label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="form-control">
                <label><b>New Password</b> (Leave blank to keep current password)</label>
                <input type="password" name="password">
            </div>
            <button type="submit" name="update" class="barbbutton">Update Profile</button>
        </form>
    </div>
</div>
</body>
</html>
