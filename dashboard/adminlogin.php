<?php
session_start();

// Hardcoded admin credentials
$admin_email = 'msaintique@gmail.com';
$admin_password = '0780798099';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verify credentials
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location:dashboard/indexx.php');
        exit;
    } else {
        $error_message = "Invalid credentials";
    }
}
?>
<style>
    
    body {
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f0f0f0;
    }
    .login-box {
      width: 350px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .login-logo a {
      font-size: 24px;
      font-weight: bold;
      color: #333;
      text-decoration: none;
    }
    .login-card-body {
      padding: 0;
    }
    .login-card-body .card {
      border: none;
      box-shadow: none;
    }
    .input-group-text {
      background-color: #f8f9fa;
      border-color: #ced4da;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }
    .btn-primary:focus, .btn-primary.focus {
      box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
    }
    .alert-danger {
      color: #721c24;
      background-color: #f8d7da;
      border-color: #f5c6cb;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
    }
  </style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</b>Login</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
          <?= $error_message ?>
        </div>
      <?php endif; ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Include your JavaScript here -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
