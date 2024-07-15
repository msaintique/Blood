<?php
include 'dbconnect.php';

// Function to fetch all users
function getUsers($conn) {
    $stmt = $conn->query("SELECT * FROM users");
    $users = [];
    while ($row = $stmt->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

// Function to create a new user
function createUser($conn, $name, $contact_number, $city, $blood_group, $gender) {
    $stmt = $conn->prepare("INSERT INTO users (name, contact_number, city, blood_group, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $contact_number, $city, $blood_group, $gender);
    return $stmt->execute();
}

// Function to update a user
function updateUser($conn, $id, $name, $contact_number, $city, $blood_group, $gender) {
    $stmt = $conn->prepare("UPDATE users SET name = ?, contact_number = ?, city = ?, blood_group = ?, gender = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $contact_number, $city, $blood_group, $gender, $id);
    return $stmt->execute();
}

// Function to delete a user
function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Handle POST requests (for creating, updating, deleting users)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'create') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $blood_group = filter_input(INPUT_POST, 'blood_group', FILTER_SANITIZE_STRING);
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
            if (createUser($conn, $name, $contact_number, $city, $blood_group, $gender)) {
                header("Location: indexx.php?success=created");
                exit();
            } else {
                $error_message = "Failed to create user.";
            }
        } elseif ($action == 'update') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $blood_group = filter_input(INPUT_POST, 'blood_group', FILTER_SANITIZE_STRING);
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
            if (updateUser($conn, $id, $name, $contact_number, $city, $blood_group, $gender)) {
                header("Location: indexx.php?success=updated");
                exit();
            } else {
                $error_message = "Failed to update user.";
            }
        } elseif ($action == 'delete') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (deleteUser($conn, $id)) {
                header("Location: indexx.php?success=deleted");
                exit();
            } else {
                $error_message = "Failed to delete user.";
            }
        }
    }
}

// Fetch all users
$users = getUsers($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Management</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>
        
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createUserModal">Create New User</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>City</th>
                    <th>Blood Group</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= $user['name']; ?></td>
                        <td><?= $user['contact_number']; ?></td>
                        <td><?= $user['city']; ?></td>
                        <td><?= $user['blood_group']; ?></td>
                        <td><?= $user['gender']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary editUserBtn" data-id="<?= $user['id']; ?>" data-name="<?= $user['name']; ?>" data-contact="<?= $user['contact_number']; ?>" data-city="<?= $user['city']; ?>" data-blood="<?= $user['blood_group']; ?>" data-gender="<?= $user['gender']; ?>">Edit</button>
                            <form method="post" action="users.php" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="post" action="users.php">
                        <div class="form-group">
                            <label for="createName">Name</label>
                            <input type="text" class="form-control" id="createName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="createContact">Contact Number</label>
                            <input type="text" class="form-control" id="createContact" name="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label for="createCity">City</label>
                            <input type="text" class="form-control" id="createCity" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="createBloodGroup">Blood Group</label>
                            <input type="text" class="form-control" id="createBloodGroup" name="blood_group" required>
                        </div>
                        <div class="form-group">
                            <label for="createGender">Gender</label>
                            <select class="form-control" id="createGender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="action" value="create">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="post" action="users.php">
                        <input type="hidden" id="editUserId" name="id">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editContact">Contact Number</label>
                            <input type="text" class="form-control" id="editContact" name="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label for="editCity">City</label>
                            <input type="text" class="form-control" id="editCity" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="editBloodGroup">Blood Group</label>
                            <input type="text" class="form-control" id="editBloodGroup" name="blood_group" required>
                        </div>
                        <div class="form-group">
                            <label for="editGender">Gender</label>
                            <select class="form-control" id="editGender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="action" value="update">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Edit User
            $('.editUserBtn').click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var contact = $(this).data('contact');
                var city = $(this).data('city');
                var blood = $(this).data('blood');
                var gender = $(this).data('gender');
                $('#editUserId').val(id);
                $('#editName').val(name);
                $('#editContact').val(contact);
                $('#editCity').val(city);
                $('#editBloodGroup').val(blood);
                $('#editGender').val(gender);
                $('#editUserModal').modal('show');
            });
        });
    </script>
</body>
</html>
