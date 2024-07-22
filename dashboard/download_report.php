<?php
include 'dbconnect.php';

// Function to create CSV content
function createCSV($data, $filename) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    // Output column headings
    fputcsv($output, ['ID', 'Name', 'Phone Number', 'Blood Type', 'Appointment Date', 'Appointment Time', 'Donation Center', 'Status']);

    // Output rows
    foreach ($data as $row) {
        fputcsv($output, [
            $row['id'],
            $row['first_name'] . ' ' . $row['last_name'],
            $row['phone_number'],
            $row['blood_type'],
            $row['appointment_date'],
            $row['appointment_time'],
            $row['donation_center'],
            $row['status']
        ]);
    }

    fclose($output);
}

// Fetch all appointments
$query = "SELECT id, first_name, last_name, phone_number, blood_type, appointment_date, appointment_time, donation_center, status FROM appointments";
$result = mysqli_query($conn, $query);

$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

mysqli_close($conn);

// Create and download CSV file
createCSV($data, 'appointments_report.csv');
?>
