<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = md5($_POST['password']); // Not recommended for secure password hashing
    $contact_number = $_POST['contact_number'];
    $city = $_POST['city'];
    $blood_group = $_POST['blood_group'];
    $gender = $_POST['gender'];

    // Escape all input values to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $password = mysqli_real_escape_string($conn, $password);
    $contact_number = mysqli_real_escape_string($conn, $contact_number);
    $city = mysqli_real_escape_string($conn, $city);
    $blood_group = mysqli_real_escape_string($conn, $blood_group);
    $gender = mysqli_real_escape_string($conn, $gender);

    // SQL query to insert data into the users table
    $sql = "INSERT INTO users (name, password, contact_number, city, blood_group, gender) 
            VALUES ('$name', '$password', '$contact_number', '$city', '$blood_group', '$gender')";

    // Perform the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "User registered successfully";
        header("Location:login.php");
    } else {
        echo "Error: " . mysqli_error($conn); // Display MySQL error if query fails
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/css.css">
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <h1>Register</h1>
            <form method="post">
                <input type="text" name="name" placeholder="Name" required>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <button type="button" onclick="togglePassword()">Show/Hide Password</button>
                <input type="text" name="contact_number" placeholder="Contact Number" required>
                <input type="text" name="city" placeholder="City" required>
                <select name="blood_group" required>
                    <option value="" disabled selected>Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="I don't know">I don't know</option>
                </select>
                <div>
                    <input type="radio" name="gender" value="male" required> Male
                    <input type="radio" name="gender" value="female" required> Female
                </div>
                <button type="submit">Create Account</button>
            </form>
            <a href="../index.php">Back</a>
        </div>
    </div>
</body>
</html>
