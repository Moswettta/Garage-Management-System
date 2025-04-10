<?php
session_start();
include 'db.php'; // Include database connection

// Mechanic Authentication
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM mechanic WHERE email='$email' AND password='$password'";
    $result = $db->query($sql);

    if ($result->num_rows == 1) {
        // Mechanic found, set session variables and redirect to dashboard
        $row = $result->fetch_assoc();
        $_SESSION['mechanic_id'] = $row['id'];
        $_SESSION['mechanic_name'] = $row['name'];
        header("location: mechanic_dashboard.php");
        exit;
    } else {
        // Mechanic not found, display error message
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mechanic Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4895ef;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --danger-color: #ef233c;
      --success-color: #4cc9f0;
      --mechanic-color: #f77f00;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f77f00 0%, #fcbf49 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    
    .login-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px;
      padding: 40px;
      text-align: center;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease;
    }
    
    .login-container:hover {
      transform: translateY(-5px);
    }
    
    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--mechanic-color), #fcbf49);
    }
    
    .logo {
      margin-bottom: 30px;
    }
    
    .logo i {
      font-size: 50px;
      color: var(--mechanic-color);
      background: linear-gradient(135deg, var(--mechanic-color), #fcbf49);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    h2 {
      color: var(--dark-color);
      margin-bottom: 25px;
      font-weight: 700;
      font-size: 28px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .form-group {
      margin-bottom: 25px;
      text-align: left;
      position: relative;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--dark-color);
      font-weight: 600;
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .form-control {
      width: 100%;
      padding: 15px 20px 15px 45px;
      border: 2px solid #e9ecef;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s;
      background-color: #f8f9fa;
    }
    
    .form-control:focus {
      border-color: var(--mechanic-color);
      box-shadow: 0 0 0 3px rgba(247, 127, 0, 0.2);
      outline: none;
      background-color: white;
    }
    
    .input-icon {
      position: absolute;
      left: 15px;
      top: 40px;
      color: var(--mechanic-color);
      font-size: 18px;
    }
    
    .btn {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .btn-login {
      background: linear-gradient(135deg, var(--mechanic-color), #fcbf49);
      color: white;
      box-shadow: 0 4px 15px rgba(247, 127, 0, 0.3);
    }
    
    .btn-login:hover {
      background: linear-gradient(135deg, #e67300, var(--mechanic-color));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(247, 127, 0, 0.4);
    }
    
    .btn-home {
      background: white;
      color: var(--dark-color);
      border: 2px solid #e9ecef;
    }
    
    .btn-home:hover {
      background: #f8f9fa;
      border-color: var(--mechanic-color);
      color: var(--mechanic-color);
    }
    
    .alert {
      color: var(--danger-color);
      background-color: rgba(239, 35, 60, 0.1);
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-left: 4px solid var(--danger-color);
    }
    
    .alert i {
      margin-right: 8px;
    }
    
    .btn i {
      margin-right: 8px;
    }
    
    .footer-text {
      margin-top: 25px;
      color: #6c757d;
      font-size: 14px;
    }
    
    @media (max-width: 480px) {
      .login-container {
        padding: 30px 20px;
      }
      
      h2 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="logo">
      <i class="fas fa-tools"></i>
    </div>
    <h2>Mechanic Login</h2>

    <?php if (isset($error)) { ?>
      <div class="alert">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $error; ?>
      </div>
    <?php } ?>

    <form method="post">
      <div class="form-group">
        <label for="email">Email Address</label>
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <i class="fas fa-lock input-icon"></i>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
      </div>
      
      <button type="submit" class="btn btn-login">
        <i class="fas fa-sign-in-alt"></i> Login
      </button>
      
      <a href="index.php" class="btn btn-home">
        <i class="fas fa-home"></i> Return Home
      </a>
    </form>
    
    <p class="footer-text">Authorized personnel only</p>
  </div>

</body>
</html>