<?php
require 'dbconnect.php';

try {
    // Prepare SQL statement to fetch all donor profiles
    $stmt = $conn->prepare("SELECT * FROM donor_profiles");
    $stmt->execute();

    // Fetch all profiles
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}

// Close database connection
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Profiles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Donor Profiles</h2>
    <?php if (count($profiles) > 0): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Type</th>
                    <th>Weight (kg)</th>
                    <th>Last Donation Date</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($profiles as $profile): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($profile['name']); ?></td>
                        <td><?php echo htmlspecialchars($profile['age']); ?></td>
                        <td><?php echo htmlspecialchars($profile['blood_type']); ?></td>
                        <td><?php echo htmlspecialchars($profile['weight']); ?></td>
                        <td><?php echo htmlspecialchars($profile['last_donation_date']); ?></td>
                        <td>
                            <?php if (!empty($profile['photo_path'])): ?>
                                <img src="<?php echo htmlspecialchars($profile['photo_path']); ?>" alt="Photo" width="100">
                            <?php else: ?>
                                No photo
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No donor profiles found.</p>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
        document.getElementById('appointment-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('book_appointment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('response-message');
                if (data.success) {
                    responseMessage.textContent = 'Appointment booked successfully!';
                    responseMessage.classList.add('alert', 'alert-success');
                } else {
                    responseMessage.textContent = 'Failed to book appointment. Please try again.';
                    responseMessage.classList.add('alert', 'alert-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>