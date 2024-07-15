<?php
include 'dbconnect.php'; // Include your database connection file

$sql = "SELECT * FROM appointments WHERE status = 'Pending'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointment Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h4>Appointment Requests</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Blood Type</th>
                <th>Location</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['blood_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                    <td>
                        <form action="process_appointment.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="process_appointment.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
mysqli_close($conn);
?>
