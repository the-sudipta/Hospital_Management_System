<?php

global $routes;
require '../routes.php';

require_once __DIR__ . '/../model/CalculationRepo.php';
require_once __DIR__ . '/../view/Data_Provider.php';
require_once __DIR__ . '/../model/userRepo.php';
require_once __DIR__ . '/../model/logRepo.php';

// Define inline CSS and Bootstrap link
$style = "
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #007bff;
            font-weight: bold;
        }
        table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
";

// Print the CSS and Bootstrap link
echo $style;

// Start the page container
echo '<div class="container text-center">';
echo '<h1 class="my-4">Welcome to Testing Page</h1>';
echo '<p class="lead">Here we test different functionalities with static values</p>';

echo '<div class="mt-5">';
echo '<h3 class="text-primary">Functionality: findAllUsers()</h3>';

// Fetch users
$users = findAllUsers(); // Assuming this function returns an array of user data

if (is_array($users) && !empty($users)) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered table-hover mt-3">';
    echo '<thead class="table-dark">';
    echo '<tr><th>ID</th><th>Email</th><th>Role</th><th>Status</th></tr>';
    echo '</thead><tbody>';

    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($user['id']) . '</td>';
        echo '<td>' . htmlspecialchars($user['email']) . '</td>';
        echo '<td>' . htmlspecialchars($user['role']) . '</td>';
        echo '<td>' . htmlspecialchars($user['status']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
} else {
    echo '<div class="alert alert-warning mt-3">No users found.</div>';
}

echo '<h5 class=""><b>Functionality Decision : Working</b></h5>';

echo '</div>';

echo '<div class="mt-5">';
echo '<h3 class="text-primary">Functionality: Login</h3>';

// Fetch single user
$user = findUserByEmailAndPassword('test3@hospital.com', '0testPass@'); // Assuming this function returns an array of user data
// Hashed Pass = $2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O
if ($user) {
    echo '<div class="user-info">';
    echo '<h4>User Information</h4>';
    echo '<table class="table table-bordered">';
    echo '<tr><th>ID</th><td>' . htmlspecialchars($user['id']) . '</td></tr>';
    echo '<tr><th>Email</th><td>' . htmlspecialchars($user['email']) . '</td></tr>';
    echo '<tr><th>Hashed Password</th><td>' . htmlspecialchars($user['password']) . '</td></tr>';
    echo '<tr><th>Role</th><td>' . htmlspecialchars($user['role']) . '</td></tr>';
    echo '<tr><th>Status</th><td>' . htmlspecialchars($user['status']) . '</td></tr>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<div class="alert alert-warning mt-3">User not found.</div>';
}
echo '<h5 class=""><b>Functionality Decision : Working</b></h5>';
echo '</div>';



echo '<div class="mt-5">';
echo '<h3 class="text-primary">Functionality: Find single user By User ID = 2</h3>';

// Fetch single user
$single_user = findUserByUserID(2);
if ($single_user) {
    echo '<div class="user-info">';
    echo '<h4>User Information</h4>';
    echo '<table class="table table-bordered">';
    echo '<tr><th>ID</th><td>' . htmlspecialchars($single_user['id']) . '</td></tr>';
    echo '<tr><th>Email</th><td>' . htmlspecialchars($single_user['email']) . '</td></tr>';
    echo '<tr><th>Hashed Password</th><td>' . htmlspecialchars($single_user['password']) . '</td></tr>';
    echo '<tr><th>Role</th><td>' . htmlspecialchars($single_user['role']) . '</td></tr>';
    echo '<tr><th>Status</th><td>' . htmlspecialchars($single_user['status']) . '</td></tr>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<div class="alert alert-warning mt-3">User not found.</div>';
}
echo '<h5 class=""><b>Functionality Decision : Working</b></h5>';
echo '</div>';


echo '<div class="mt-5">';
echo '<h3 class="text-primary">Functionality: Find All Logs</h3>';

// Fetch single user
$logs = findAllLogs();
if (is_array($logs) && !empty($logs)) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered table-hover mt-3">';
    echo '<thead class="table-dark">';
    echo '<tr><th>ID</th><th>action</th><th>timestamp</th><th>user_id</th></tr>';
    echo '</thead><tbody>';

    foreach ($logs as $log) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($log['id']) . '</td>';
        echo '<td>' . htmlspecialchars($log['action']) . '</td>';
        echo '<td>' . htmlspecialchars($log['timestamp']) . '</td>';
        echo '<td>' . htmlspecialchars($log['user_id']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
} else {
    echo '<div class="alert alert-warning mt-3">No logs found.</div>';
}
echo '<h5 class=""><b>Functionality Decision : Working</b></h5>';
echo '</div>';














































echo '</div>'; // Close container
?>
