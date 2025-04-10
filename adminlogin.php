<?php
session_start();
if(isset($_SESSION['admin_username'])) {
    header("Location: adm.php"); // Redirect to admin dashboard if already logged in
    exit();
}
if(isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
} else {
    $login_error = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="css/admin_login_style.css"> <!-- Custom CSS file -->
    <style>
        /* Add any additional styles here */
        .container {
            margin-top: 100px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Admin Login</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="admin_process.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <?php if(!empty($login_error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $login_error; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
