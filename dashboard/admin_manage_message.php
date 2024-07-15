<?php
require "../vendor/autoload.php"; // Adjust the path to autoload.php as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (example using PDO)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blood";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $message_id = filter_input(INPUT_POST, 'message_id', FILTER_VALIDATE_INT);
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

        if ($action === 'delete') {
            // Delete message
            $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = :id");
            $stmt->bindParam(':id', $message_id);
            $stmt->execute();
            echo "Message deleted successfully.";
            // Redirect or display message as needed
        } elseif ($action === 'send_message') {
            // Send message to user
            $admin_reply_message = filter_input(INPUT_POST, 'admin_reply_message', FILTER_SANITIZE_STRING);

            // Retrieve user's email from database
            $stmt = $conn->prepare("SELECT email FROM contact_messages WHERE id = :id");
            $stmt->bindParam(':id', $message_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $user_email = $result['email'];

                // Send email to user (example using PHP's mail function)
                $subject = "Reply from Admin";
                $body = "Dear User,\n\n" . $admin_reply_message;
                $headers = "From: admin@example.com";

                if (mail($user_email, $subject, $body, $headers)) {
                    echo "Message sent successfully.";
                } else {
                    echo "Failed to send message.";
                }
            } else {
                echo "User not found.";
            }
        } else {
            echo "Invalid action.";
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null; // Close database connection
} else {
    echo "Invalid request method.";
}
?>
