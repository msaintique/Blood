<?php
include 'dbconnect.php';
include 'infobip.php'; // Assuming this is the file where you have the SMS sending logic

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_appointment'])) {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $donation_center = mysqli_real_escape_string($conn, $_POST['donation_center']);
    
    // Update the appointment status to approved and add donation center
    function approveAppointment($appointment_id, $donation_center) {
        global $conn;
        
        // Update appointment status to 'approved' and add donation center
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
}
?>    