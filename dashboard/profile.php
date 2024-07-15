<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Platform</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="profile">
    <div class="container">
        <div class="section-heading">
            <h2>Donor Profile</h2>
        </div>
        <div class="profile-content">
            <form id="profile-form" action="profileconnect.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age">
                </div>
                <div class="mb-3">
                    <label for="blood-type" class="form-label">Blood Type</label>
                    <select class="form-control" id="blood-type" name="blood-type">
                        <option value=""></option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dont-know-blood-type">
                        <label class="form-check-label" for="dont-know-blood-type">I don't know</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" class="form-control" id="weight" name="weight" placeholder="Enter your weight">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dont-know-weight">
                        <label class="form-check-label" for="dont-know-weight">I don't know</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="last-donation-date" class="form-label">Last Donation Date</label>
                    <input type="date" class="form-control" id="last-donation-date" name="last-donation-date">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dont-remember">
                        <label class="form-check-label" for="dont-remember">I don't remember</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save Profile</button>
            </form>
            <div id="message" class="mt-3"></div>
        </div>
    </div>
</section>

<script>
document.getElementById("profile-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = new FormData(this);

    fetch("profile_process.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Display success message
        alert("Data inserted successfully: " + data);
        // Optionally, reset the form
        document.getElementById("profile-form").reset();
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error inserting data.");
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
