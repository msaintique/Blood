<?php
include 'dbconnect.php';
include 'intouchsms.php'; // Assuming this is the file where you have the SMS sending logic

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_appointment'])) {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $donation_center = mysqli_real_escape_string($conn, $_POST['donation_center']);
    
    // Update the appointment status to approved
    $sql = "UPDATE appointments SET status = 'approved', donation_center = '$donation_center' WHERE id = $appointment_id";
    
    if (mysqli_query($conn, $sql)) {
        // Fetch the appointment details
        $result = mysqli_query($conn, "SELECT * FROM appointments WHERE id = $appointment_id");
        $appointment = mysqli_fetch_assoc($result);

        // Prepare the SMS message
        $message = "Thank you, " . $appointment['first_name'] . " " . $appointment['last_name'] . 
                   ". Your blood donation appointment is approved. Please visit " . $donation_center . 
                   " on " . $appointment['appointment_date'] . " at " . $appointment['appointment_time'] . 
                   ". Thank you for your contribution.";

        // Send the SMS
        $sms_response = send_sms($appointment['phone_number'], $message);

        if ($sms_response) {
            echo "Appointment approved and SMS sent successfully.";
        } else {
            echo "Appointment approved but SMS sending failed.";
        }
    } else {
        echo "Error approving appointment: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blood Donation Platform - Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-xxxxxx" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
    .status-approved {
        color: green;
    }
    .status-rejected {
        color: red;
    }
    .status-pending {
        color: orange;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="indexx.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Blood Donation</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link active" onclick="loadContent('admin_dashboard.php')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="loadContent('admin_view_messages.php')">
              <i class="nav-icon far fa-envelope"></i>
              <p>Messages</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="loadContent('users.php')">
              <i class="nav-icon far fa-user"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="loadContent('requests_appointments.php')">
                <i class="far fa-calendar-check nav-icon"></i>
                <p>Requests Appointments</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <div class="content-wrapper" id="content">
    <div id="dashboard-content">
        <!-- Default content goes here, can be the dashboard overview -->
    </div>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2023-2024 <a href="indexx.php">Blood Donation Platform</a>.</strong>
    All rights reserved.
  </footer>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  function loadContent(page) {
    $.ajax({
      url: page,
      type: 'GET',
      success: function(response) {
        $('#dashboard-content').html(response);
      },
      error: function(xhr, status, error) {
        console.error('Error loading content:', error);
      }
    });
  }
  $(document).ready(function() {
    loadContent('admin_dashboard.php');
  });
</script>
</body>
</html>
