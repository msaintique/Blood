<?php
include 'send_email_swift.php'; // Adjust the path as necessary

// Test values (replace with actual email address)
$to = '57joel39@gmail.com';
$subject = 'Test Email';
$body = 'This is a test email message.';

// Call send_email() with test values
if (send_email($to, $subject, $body)) {
    echo "Test email sent successfully.";
} else {
    echo "Test email sending failed.";
}
?>
