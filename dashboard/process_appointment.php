<?php
include 'dbconnect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    
    // Get appointment details
    $sql = "SELECT * FROM appointments WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $appointment = mysqli_fetch_assoc($result);

    if ($appointment) {
        $status = $action == 'approve' ? 'Approved' : 'Rejected';

        // Update appointment status
        $update_sql = "UPDATE appointments SET status = '$status' WHERE id = '$id'";
        if (mysqli_query($conn, $update_sql)) {
            if ($action == 'approve') {
                // Send SMS notification
                sendSMS($appointment['phone_number'], "Your appointment is approved. Please visit us on " . $appointment['appointment_date'] . " at " . $appointment['appointment_time'] . ".");

                echo "Appointment has been " . strtolower($status) . " and SMS sent.";
            } else {
                echo "Appointment has been " . strtolower($status) . ".";
            }
        } else {
            echo "Error updating appointment: " . mysqli_error($conn);
        }
    } else {
        echo "Appointment not found.";
    }

    mysqli_close($conn);
}
function sendSMS($phone_number, $message) {
    $url = "https://www.intouchsms.co.rw";
    $fields = array(
        'sender' => '+250780798099',  // Replace with your actual sender ID
        'recipients' => $phone_number,
        'message' => $message
    );

    $headers = array(
        'Content-Type: application/json',
        'Authorization: a49131f101b9b7f413a60e73e335e5356370d56f6'  // Replace with your Intouch SMS API key
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Message sent successfully!';
    }
    curl_close($ch);
}
?>
