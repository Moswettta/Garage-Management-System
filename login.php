<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "carbdb";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration
if (isset($_POST['register'])) {
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = md5($_POST['password']); // For better security, use password_hash()

    $sql = "INSERT INTO members (mname, email, phone, password) VALUES ('$mname', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Member registered successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle login using mname
if (isset($_POST['login'])) {
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM members WHERE mname='$mname' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['mid'] = $row['mid'];
        $_SESSION['mname'] = $row['mname'];
        $_SESSION['email'] = $row['email'];

        // Redirect to profile page
        header("Location: members.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Garage Ms.</title>
  <script src="https://kit.fontawesome.com/57c187a429.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Urbanist', sans-serif;
      background: linear-gradient(to right, #f0f4f8, #e0eafc);
      color: #333;
    }
    header {
      background: #111;
      padding: 20px;
      text-align: center;
    }
    header a {
      background: #444;
      color: #fff;
      padding: 10px 20px;
      margin: 0 10px;
      text-decoration: none;
      border-radius: 8px;
      transition: 0.3s ease;
      font-weight: 600;
    }
    header a:hover {
      background: #0af;
      color: #fff;
    }
    .container-fluid {
      max-width: 1200px;
      margin: 40px auto;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }
    .card-box {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      transition: transform 0.3s ease;
    }
    .card-box:hover {
      transform: translateY(-5px);
    }
    h3 {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
    }
    .form-control {
      margin-bottom: 15px;
      position: relative;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
      color: #444;
    }
    input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 2px solid #ddd;
      transition: 0.3s ease;
      font-size: 16px;
    }
    input:focus {
      border-color: #007BFF;
      outline: none;
    }
    .barbbutton {
      width: 100%;
      padding: 12px;
      background: #007BFF;
      color: white;
      border: none;
      font-size: 16px;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s ease;
    }
    .barbbutton:hover {
      background: #0056b3;
    }
    .link-button {
      background: transparent;
      border: none;
      color: #007BFF;
      font-size: 14px;
      cursor: pointer;
      text-decoration: underline;
      margin-top: 15px;
    }
    .hidden {
      display: none;
    }
    .form-control i {
      position: absolute;
      top: 40px;
      right: 10px;
      visibility: hidden;
    }
    .form-control.success input {
      border-color: #28a745;
    }
    .form-control.error input {
      border-color: #dc3545;
    }
    .form-control.success i.fa-check-circle,
    .form-control.error i.fa-exclamation-circle {
      visibility: visible;
    }
    .form-control small {
      color: #dc3545;
      font-size: 12px;
      visibility: hidden;
    }
    .form-control.error small {
      visibility: visible;
    }
  </style>
</head>
<body>

<header>
  <a href="mechaniclogin.php">Mechanical Log In</a>
  <a href="admn.php">Admin Log In</a>
</header>

<div class="container-fluid">
  <div class="card-box" id="loginBox">
    <h3>Log In</h3>
    <form method="post">
      <div class="form-control">
        <label for="mname">User Name</label>
        <input type="text" placeholder="Enter Member Name" name="mname" required>
      </div>
      <div class="form-control">
        <label for="password">Password</label>
        <input type="password" placeholder="Enter Password" name="password" required>
      </div>
      <button type="submit" name="login" class="barbbutton">Login</button>
    </form>
    <button class="link-button" onclick="toggleRegister(true)">Register as New User</button><br>


   <a href="index.php" class="btn btn-home" style="display: block; text-align: center; margin: 30px auto; width: fit-content; background-color: #007BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
  <i class="fas fa-home"></i> Return Home
</a>

     </div>




  <div class="card-box hidden" id="registerBox">
    <h3>Register</h3>
    <form method="post" id="form" class="form" onsubmit="return checkInputs();">
      <div class="form-control">
        <label for="mname">Name</label>
        <input type="text" name="mname" id="mname" placeholder="Enter Name" maxlength="50">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <div class="form-control">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Enter Email" maxlength="50">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <div class="form-control">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" maxlength="10">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <div class="form-control">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter Password" maxlength="50">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <div class="form-control">
        <label for="password2">Confirm Password</label>
        <input type="password" name="confirmpassword" id="password2" placeholder="Enter Password Again" maxlength="50">
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
      </div>
      <button type="submit" name="register" class="barbbutton">Register</button>
      <button class="link-button" type="button" onclick="toggleRegister(false)">Back to Login</button>
    </form>
  </div>
</div>

<script>
  function toggleRegister(showRegister) {
    document.getElementById('loginBox').classList.toggle('hidden', showRegister);
    document.getElementById('registerBox').classList.toggle('hidden', !showRegister);
  }

  const username = document.getElementById('mname');
  const phone = document.getElementById('phone');
  const email = document.getElementById('email');
  const password = document.getElementById('password');
  const password2 = document.getElementById('password2');

  function checkInputs() {
    const usernameValue = username.value.trim();
    const phoneValue = phone.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    if (usernameValue === '' || !/^[a-zA-Z\s]*$/.test(usernameValue)) {
      setErrorFor(username, 'Valid name required');
      return false;
    } else setSuccessFor(username);

    if (phoneValue === '' || !/^[0-9]{10}$/.test(phoneValue)) {
      setErrorFor(phone, 'Valid phone required');
      return false;
    } else setSuccessFor(phone);

    if (emailValue === '' || !/^\S+@\S+\.\S+$/.test(emailValue)) {
      setErrorFor(email, 'Valid email required');
      return false;
    } else setSuccessFor(email);

    if (passwordValue === '' || !/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/.test(passwordValue)) {
      setErrorFor(password, '6-20 chars, one number, one uppercase, one lowercase');
      return false;
    } else setSuccessFor(password);

    if (password2Value !== passwordValue) {
      setErrorFor(password2, 'Passwords do not match');
      return false;
    } else setSuccessFor(password2);

    return true;
  }

  function setErrorFor(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-control error';
    formControl.querySelector('small').innerText = message;
  }

  function setSuccessFor(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
  }
</script>

</body>
</html>
