<?php
require "../vendor/autoload.php"; // Adjust the path to autoload.php as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = filter_input(INPUT_POST, 'contact_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'contact_email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'contact_phone', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'contact_message', FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Database connection (example using PDO)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blood";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to insert data into database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) 
                                VALUES (:name, :email, :phone, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':message', $message);

        // Execute the query
        $stmt->execute();

        // Output success message
        echo "Message stored successfully in the database.";
        header("Location:index.php");

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null; // Close database connection
} else {
    echo "Invalid request method.";
}
?>
