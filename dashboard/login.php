<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password =md5($_POST['password']);

    // Prepare SQL statement to fetch user details
    $sql = "SELECT * FROM users WHERE name = '$name' AND password='$password'";    
    $result = mysqli_query($conn,$sql);

    // Check if user exists in the database
    if ($result->num_rows>0) {
        $row = $result->fetch_assoc();    

      // Password is correct, start a session and set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $row['role'];

            // Redirect user based on role
            if ($row['role'] == 'admin') {
                header("Location: indexx.php"); // Redirect admin to indexx.php
            } else {
                header("Location: appointmentbookform.php"); // Redirect others to appointmentbookform.php
            }
            exit(); // Ensure script stops execution after redirection
        } else {
            // Incorrect password message
            echo "Incorrect password";
        }
    } 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <h1>Login</h1>
            <form method="post">
                <input type="text" name="name" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <a href="registration.php">Create account</a>
        </div>
    </div>
</body>
</html>
