<?php
include 'dbconnect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $first_time = mysqli_real_escape_string($conn, $_POST['first_time']);
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);

    // Prepare the SQL query
    $sql = "INSERT INTO appointments (first_name, last_name, email, phone_number, location, sex, dob, weight, first_time, blood_type) 
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$location', '$sex', '$dob', '$weight', '$first_time', '$blood_type')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "Appointment request submitted successfully.";
        header("Location:index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
