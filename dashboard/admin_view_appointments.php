<?php
include 'dbconnect.php'; // Include your database connection file

// Fetch all appointments
$sql = "SELECT * FROM appointments";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Appointment ID: " . $row['appointment_id'] . "<br>";
        echo "Name: " . $row['first_name'] . " " . $row['last_name'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Phone Number: " . $row['phone_number'] . "<br>";
        echo "Location: " . $row['location'] . "<br>";
        echo "Sex: " . $row['sex'] . "<br>";
        echo "Date of Birth: " . $row['dob'] . "<br>";
        echo "Weight: " . $row['weight'] . "<br>";
        echo "First Time Donor: " . $row['first_time'] . "<br>";
        echo "Blood Type: " . $row['blood_type'] . "<br>";
        echo "Status: " . $row['status'] . "<br>";

        // Add approve/reject buttons with form submission for each appointment
        echo "<form action='update_appointment_status.php' method='POST'>";
        echo "<input type='hidden' name='appointment_id' value='" . $row['appointment_id'] . "'>";
        echo "<button type='submit' name='approve'>Approve</button>";
        echo "<button type='submit' name='reject'>Reject</button>";
        echo "</form>";
        echo "<hr>";
    }
} else {
    echo "No appointments found.";
}

mysqli_close($conn);
?>
