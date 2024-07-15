<?php
// Include database connection file
require 'dbconnect.php';

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs (you may add more validation as per your requirements)
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $blood_type = htmlspecialchars($_POST['blood_type']);
    $location = htmlspecialchars($_POST['location']);
    $appointment_date = $_POST['appointment_date'];

    try {
        // Prepare SQL statement to insert data into appointments table
        $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone_number, blood_type, location, appointment_date) 
                                VALUES (:name, :email, :phone_number, :blood_type, :location, :appointment_date)");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':blood_type', $blood_type);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':appointment_date', $appointment_date);

        // Execute the statement
        $stmt->execute();

        // Redirect to success page after successful insertion
        header("Location: appointment_success.php");
        exit;
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
    // Close database connection
    $conn = null;
}
?>
