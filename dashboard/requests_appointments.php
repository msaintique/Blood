<?php
include 'dbconnect.php';

// Fetch appointment requests including appointment_date and appointment_time
$query = "SELECT id, first_name, last_name, email, phone_number, location, sex, dob, weight, first_time, blood_type, appointment_date, appointment_time, status FROM appointments";
$result = mysqli_query($conn, $query);

if ($result === false) {
    echo "Error fetching appointments: " . mysqli_error($conn);
} else {
    $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

mysqli_close($conn);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Appointment Requests
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Blood Type</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($appointments) && !empty($appointments)): ?>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['first_name']) . " " . htmlspecialchars($appointment['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['email']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['blood_type']); ?></td>
                                        <td><?php echo isset($appointment['appointment_date']) ? htmlspecialchars($appointment['appointment_date']) : 'N/A'; ?></td>
                                        <td><?php echo isset($appointment['appointment_time']) ? htmlspecialchars($appointment['appointment_time']) : 'N/A'; ?></td>
                                        <td>
                                            <button class="btn btn-success" onclick="approveAppointment(<?php echo $appointment['id']; ?>)">Approve</button>
                                            <button class="btn btn-danger" onclick="rejectAppointment(<?php echo $appointment['id']; ?>)">Reject</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No appointments found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveAppointment(id) {
    $.post('process_appointment.php', {id: id, action: 'approve'}, function(response) {
        alert(response);
        location.reload(); // Reload the page after processing
    });
}

function rejectAppointment(id) {
    $.post('process_appointment.php', {id: id, action: 'reject'}, function(response) {
        alert(response);
        location.reload(); // Reload the page after processing
    });
}
</script>
