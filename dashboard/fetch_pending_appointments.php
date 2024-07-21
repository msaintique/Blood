<?php
include 'dbconnect.php';

// Fetch pending appointments
$query = "SELECT id, first_name, last_name, phone_number, blood_type, appointment_date, appointment_time, donation_center, status FROM appointments WHERE status = 'pending'";
$result = mysqli_query($conn, $query);

if ($result === false) {
    echo "Error fetching appointments: " . mysqli_error($conn);
} else {
    $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($appointments);
}

mysqli_close($conn);
?>
