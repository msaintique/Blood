<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin view request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Appointment Requests
                </div>
                <div class="card-body">
                    <div id="message"></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Blood Type</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTableBody">
                            <!-- Appointment rows will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fetch pending appointments from the server
    $.ajax({
        url: 'fetch_pending_appointments.php',
        type: 'GET',
        success: function(data) {
            let appointments = JSON.parse(data);
            let html = '';
            for (let appointment of appointments) {
                html += `<tr id="row-${appointment.id}">
                            <td>${appointment.first_name} ${appointment.last_name}</td>
                            <td>${appointment.phone_number}</td>
                            <td>${appointment.blood_type}</td>
                            <td>${appointment.appointment_date}</td>
                            <td>${appointment.appointment_time}</td>
                            <td>
                                <button class="btn btn-success" onclick="showApproveForm(${appointment.id}, '${appointment.donation_center}')">Approve</button>
                                <button class="btn btn-danger" onclick="rejectAppointment(${appointment.id})">Reject</button>
                            </td>
                         </tr>`;
            }
            $('#appointmentsTableBody').html(html);
        },
        error: function(xhr, status, error) {
            $('#message').html('Error: ' + xhr.responseText);
        }
    });
});

function showApproveForm(id, donation_center) {
    let formHtml = `
        <h2>Approve Appointment</h2>
        <form id="approveForm">
            <input type="hidden" name="approve_appointment" value="true">
            <input type="hidden" name="id" value="${id}">
            
            <label for="donation_center">Donation Center:</label>
            <input type="text" id="donation_center" name="donation_center" required value="${donation_center}">
            
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required>
            
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" id="appointment_time" name="appointment_time" required>
            
            <button type="submit" class="btn btn-primary">Approve Appointment</button>
        </form>
    `;
    $('#message').html(formHtml);

    $('#approveForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'process_appointment.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                let jsonResponse = JSON.parse(response);
                $('#message').html('<div class="alert alert-success">' + jsonResponse.message + '</div>');
                // Remove the approved appointment row
                $('#row-' + id).remove();
            },
            error: function(xhr, status, error) {
                $('#message').html('Error: ' + xhr.responseText);
            }
        });
    });
}

function rejectAppointment(id) {
    $.ajax({
        url: 'process_appointment.php',
        type: 'POST',
        data: {
            id: id,
            reject_appointment: true
        },
        success: function(response) {
            let jsonResponse = JSON.parse(response);
            $('#message').html('<div class="alert alert-danger">' + jsonResponse.message + '</div>');
            // Remove the rejected appointment row
            $('#row-' + id).remove();
        },
        error: function(xhr, status, error) {
            $('#message').html('Error: ' + xhr.responseText);
        }
    });
}
</script>
</body>
</html>
