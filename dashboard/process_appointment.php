<?php
require_once __DIR__ . '/vendor/autoload.php'; // Use Composer autoload
include 'dbconnect.php';

header('Content-Type: application/json'); // Set content type for JSON responses

$response = [];

function formatPhoneNumber($phone) {
    // Ensure the phone number has the country code prefix
    if (strpos($phone, '+') !== 0) {
        return '+250' . ltrim($phone, '0'); // Assuming the country code is +250 (Rwanda)
    }
    return $phone;
}

if (isset($_POST['approve_appointment'])) {
    $id = $_POST['id'];
    $donation_center = $_POST['donation_center'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    // Update the appointment with the new details
    $query = "UPDATE appointments SET status='approved', donation_center=?, appointment_date=?, appointment_time=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $donation_center, $appointment_date, $appointment_time, $id);

    if ($stmt->execute()) {
        // Fetch phone number
        $query = "SELECT phone_number FROM appointments WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointment = $result->fetch_assoc();

        $phone_number = formatPhoneNumber($appointment['phone_number']); // Format the phone number

        // Create the message
        $message = "Thank you for scheduling an appointment to donate blood. Your appointment is on $appointment_date at $appointment_time. Please visit the donation center at $donation_center.";

        // Send SMS via Infobip API
        $apiKey = '5299f1afb7369919c07460e27546a77b-6b192be2-5d16-459d-86f6-f7f5478a4203';
        $apiUrl = 'https://j3lr8v.api.infobip.com/sms/2/text/advanced';

        $smsData = [
            'messages' => [
                [
                    'destinations' => [
                        ['to' => $phone_number]
                    ],
                    'from' => 'Blood Donation',
                    'text' => $message
                ]
            ]
        ];

        $request = new HTTP_Request2();
        $request->setUrl($apiUrl);
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(['follow_redirects' => TRUE]);
        $request->setHeader([
            'Authorization' => 'App ' . $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);
        $request->setBody(json_encode($smsData));

        try {
            $infobipResponse = $request->send();
            $responseBody = $infobipResponse->getBody();
            $responseStatus = $infobipResponse->getStatus();
            
            if ($responseStatus == 200) {
                $response['message'] = "Appointment approved and SMS sent.";
            } else {
                $response['message'] = 'Unexpected HTTP status: ' . $responseStatus . ' ' . $infobipResponse->getReasonPhrase();
                $response['error'] = $responseBody;
            }
        } catch (HTTP_Request2_Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    } else {
        $response['message'] = "Failed to approve appointment: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_POST['reject_appointment'])) {
    $id = $_POST['id'];

    // Reject the appointment
    $query = "UPDATE appointments SET status='rejected' WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['message'] = "Appointment rejected.";
    } else {
        $response['message'] = "Failed to reject appointment: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($conn);

// Ensure the response is properly encoded as JSON
echo json_encode($response);
?>
