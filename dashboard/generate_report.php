<?php
include 'dbconnect.php';

$response = [
    'approved' => [],
    'pending' => [],
    'rejected' => []
];

$query = "SELECT id, first_name, last_name, phone_number, blood_type, appointment_date, appointment_time, donation_center, status FROM appointments";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] == 'approved') {
            $response['approved'][] = $row;
        } elseif ($row['status'] == 'pending') {
            $response['pending'][] = $row;
        } elseif ($row['status'] == 'rejected') {
            $response['rejected'][] = $row;
        }
    }
} else {
    $response['error'] = 'Error fetching appointments: ' . mysqli_error($conn);
}

mysqli_close($conn);

echo json_encode($response);
?>
