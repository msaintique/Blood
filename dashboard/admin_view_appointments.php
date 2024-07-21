<?php
include 'dbconnect.php'; // Include your database connection file

// Fetch all appointments
$sql = "SELECT * FROM appointments";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Requests</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Appointment Requests</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="card mb-4">
            <div class="card-header">
                <strong>Appointment ID:</strong> <?php echo isset($row['appointment_id']) ? $row['appointment_id'] : 'N/A'; ?>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo (isset($row['first_name']) ? $row['first_name'] : 'N/A') . " " . (isset($row['last_name']) ? $row['last_name'] : 'N/A'); ?></p>
                <p><strong>Email:</strong> <?php echo isset($row['email']) ? $row['email'] : 'N/A'; ?></p>
                <p><strong>Phone Number:</strong> <?php echo isset($row['phone_number']) ? $row['phone_number'] : 'N/A'; ?></p>
                <p><strong>Location:</strong> <?php echo isset($row['location']) ? $row['location'] : 'N/A'; ?></p>
                <p><strong>Sex:</strong> <?php echo isset($row['sex']) ? $row['sex'] : 'N/A'; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo isset($row['dob']) ? $row['dob'] : 'N/A'; ?></p>
                <p><strong>Weight:</strong> <?php echo isset($row['weight']) ? $row['weight'] : 'N/A'; ?></p>
                <p><strong>First Time Donor:</strong> <?php echo isset($row['first_time']) ? $row['first_time'] : 'N/A'; ?></p>
                <p><strong>Blood Type:</strong> <?php echo isset($row['blood_type']) ? $row['blood_type'] : 'N/A'; ?></p>
                <p><strong>Status:</strong> <?php echo isset($row['status']) ? $row['status'] : 'N/A'; ?></p>

                <form action="update_appointment_status.php" method="POST" class="mt-3">
                    <input type="hidden" name="appointment_id" value="<?php echo isset($row['appointment_id']) ? $row['appointment_id'] : ''; ?>">
                    <button type="submit" name="approve" class="btn btn-success">Approve</button>
                    <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    <?php
        }
    } else {
        echo "<div class='alert alert-info'>No appointments found.</div>";
    }

    mysqli_close($conn);
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
