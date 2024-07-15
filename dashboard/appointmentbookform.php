<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood Donation Appointment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles for body */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f44336;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for form */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Form container styling */
        .form-container {
            background-color: white;
            color: #f44336;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 600px; /* Increased max-width to accommodate two columns */
            display: flex;
            flex-wrap: wrap; /* Enable wrapping for responsive design */
            justify-content: space-between; /* Space between columns */
        }

        /* Header styling */
        h4 {
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Input, button, and select styles */
        form input, form button, form select {
            width: calc(50% - 15px); /* Adjusted width for two columns with spacing */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding doesn't affect width */
        }

        /* Button styling */
        form button {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%; /* Full width for button */
        }

        form button:hover {
            background-color: #d32f2f;
        }

        /* Select box styling */
        form select {
            background-color: white;
            color: #333;
        }

        /* Link styling */
        a {
            color: #f44336;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Flex layout for checkboxes and radio buttons */
        form div.radio-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
            width: 100%; /* Full width for radio group */
        }

        /* Adjust input width within flex layout */
        form div.radio-group input {
            width: auto;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <h4>Request Blood Donation Appointment</h4>
            <form action="process_request.php" method="POST">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="text" name="location" placeholder="Location" required>
                <select name="sex" required>
                    <option value="" disabled selected>Select Sex</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <input type="date" name="dob" placeholder="Date of Birth" required>
                <input type="number" name="weight" placeholder="Weight (kg)">
                <div class="radio-group">
                    <label>Is it the first time you donate?</label>
                    <input type="radio" id="first_time_yes" name="first_time" value="yes" required>
                    <label for="first_time_yes">Yes</label>
                    <input type="radio" id="first_time_no" name="first_time" value="no">
                    <label for="first_time_no">No</label>
                </div>
                <select name="blood_type" required>
                    <option value="" disabled selected>Select Blood Type</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="unknown">I don't know</option>
                </select>
                <button type="submit"> Request</button>
            </form>
            <a href="../index.php">Back </a>
        </div>
    </div>
</body>
</html>
