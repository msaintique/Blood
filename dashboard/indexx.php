<?php
include 'dbconnect.php';
$user_count_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM users");
$user_count = mysqli_fetch_assoc($user_count_result)['count'];

// Fetch number of messages sent
$message_count_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM contact_messages");
$message_count = mysqli_fetch_assoc($message_count_result)['count'];

// Fetch number of appointment requests
$appointment_count_result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM appointments");
$appointment_count = mysqli_fetch_assoc($appointment_count_result)['count'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blood Donation Platform - Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
      <img src="image/giving2.jpg" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="generateReport()">
              <i class="nav-icon far fa-file-excel"></i>
              <p>Generate Report</p>
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

  function generateReport() {
    $.ajax({
      url: 'generate_report.php',
      type: 'GET',
      success: function(data) {
        let report = JSON.parse(data);
        let html = '<h2>Appointments Report</h2>';

        if (report.error) {
          html += '<div class="alert alert-danger">Error: ' + report.error + '</div>';
        } else {
          html += '<h3>Approved Appointments</h3>';
          html += generateTable(report.approved);
          html += '<h3>Pending Appointments</h3>';
          html += generateTable(report.pending);
          html += '<h3>Rejected Appointments</h3>';
          html += generateTable(report.rejected);
        }

        $('#dashboard-content').html(html);
      },
      error: function(xhr, status, error) {
        console.error('Error generating report:', error);
      }
    });
  }
  function generateReport() {
    $.ajax({
        url: 'generate_report.php',
        type: 'GET',
        success: function(data) {
            let report = JSON.parse(data);
            let html = '<h2>Appointments Report</h2>';

            if (report.error) {
                html += '<div class="alert alert-danger">Error: ' + report.error + '</div>';
            } else {
                html += '<h3>Approved Appointments</h3>';
                html += generateTable(report.approved);
                html += '<h3>Pending Appointments</h3>';
                html += generateTable(report.pending);
                html += '<h3>Rejected Appointments</h3>';
                html += generateTable(report.rejected);
                html += '<button onclick="downloadReport()">Download Report</button>';
            }

            $('#dashboard-content').html(html);
        },
        error: function(xhr, status, error) {
            console.error('Error generating report:', error);
        }
    });
}

function generateTable(data) {
    let html = '<table class="table table-bordered">';
    html += '<thead><tr><th>ID</th><th>Name</th><th>Phone Number</th><th>Blood Type</th><th>Appointment Date</th><th>Appointment Time</th><th>Donation Center</th><th>Status</th></tr></thead>';
    html += '<tbody>';

    data.forEach(function(item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>';
        html += '<td>' + item.first_name + ' ' + item.last_name + '</td>';
        html += '<td>' + item.phone_number + '</td>';
        html += '<td>' + item.blood_type + '</td>';
        html += '<td>' + item.appointment_date + '</td>';
        html += '<td>' + item.appointment_time + '</td>';
        html += '<td>' + item.donation_center + '</td>';
        html += '<td class="' + 'status-' + item.status + '">' + item.status + '</td>';
        html += '</tr>';
    });

    html += '</tbody></table>';
    return html;
}

function downloadReport() {
    window.location.href = 'download_report.php';
}

</script>
</body>
</html>
