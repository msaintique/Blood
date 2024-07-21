<?php
require_once '../vendor/autoload.php'; // Adjust the path as necessary

function send_email($to, $subject, $body) {
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
        ->setUsername('msaintique@gmail.com') // SMTP username
        ->setPassword('saintique2001'); // SMTP password

    // Create the Mailer using the created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message($subject))
        ->setFrom(['msaintique@gmail.com' => 'Blood Donation Platform'])
        ->setTo([$to])
        ->setBody($body, 'text/html');

    // Send the message
    try {
        $result = $mailer->send($message);
        if ($result) {
            error_log("Email sent successfully to $to");
            return true;
        } else {
            error_log("Failed to send email to $to");
            return false;
        }
    } catch (Exception $e) {
        error_log("Message could not be sent. Error: {$e->getMessage()}");
        return false;
    }
}
?>
