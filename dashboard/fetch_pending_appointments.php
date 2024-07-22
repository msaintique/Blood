<?php
include 'dbconnect.php';
$query = "SELECT id, first_name, last_name, phone_number, blood_type, appointment_date, appointment_time, donation_center FROM appointments WHERE status = 'pending'";
$result = mysqli_query($conn, $query);

if ($result) {
    $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($appointments);
} else {
    echo json_encode(['error' => 'Error fetching appointments: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
