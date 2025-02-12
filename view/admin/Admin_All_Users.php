<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
require_once __DIR__ . '/../../model/userRepo.php';
//include '../Loader.php';

// Navigation Routes Frontend
$Login_page = $routes['login'];

$admin_dashboard = $routes["admin_dashboard"];
// Admin User Functionalities
$admin_all_users = $routes["admin_all_users"];
$admin_create_user = $routes["admin_create_user"];
$admin_single_user = $routes["admin_single_user"];
// Admin Patient Functionalities
$admin_all_patients = $routes["admin_all_patients"];
$admin_create_patient = $routes["admin_create_patient"];
$admin_single_patient = $routes["admin_single_patient"];
// Admin Appointment Functionalities
$admin_all_appointments = $routes["admin_all_appointments"];
$admin_create_appointment = $routes["admin_create_appointment"];
$admin_single_appointment = $routes["admin_single_appointment"];
// Admin Schedule Functionalities
$admin_all_schedules = $routes["admin_all_schedules"];
$admin_create_schedule = $routes["admin_create_schedule"];
$admin_single_schedule = $routes["admin_single_schedule"];
// Admin Report Functionalities
$admin_all_reports = $routes["admin_all_reports"];
$admin_create_report = $routes["admin_create_report"];
$admin_single_report = $routes["admin_single_report"];
// Admin Bill Functionalities
$admin_all_bills = $routes["admin_all_bills"];
$admin_create_bill = $routes["admin_create_bill"];
$admin_single_bill = $routes["admin_single_bill"];
// Admin Image Functionalities
$admin_all_images = $routes["admin_all_images"];
$admin_upload_image = $routes["admin_upload_image"];
$admin_show_single_image = $routes["admin_show_single_image"];
// Admin Log Functionalities
$admin_all_logs = $routes["admin_all_logs"];
$admin_create_log = $routes["admin_create_log"];
$admin_single_log = $routes["admin_single_log"];






// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$delete_user_controller = $backend_routes['delete_user_controller'];
$re_active_user_controller = $backend_routes['re_active_user_controller'];


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}


// Gather Necessary Data
$user_id = $_SESSION["user_id"];
$all_users = findAllUsers();


$error_message = "";
// Message from Backend
if (isset($_GET['message'])) {
    $error_message = htmlspecialchars($_GET['message']);
    $show_backend_error_modal = true;
}




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Users</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #0d1117;
            color: #c9d1d9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        .center-circle {
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, #58a6ff, #0d1117);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
            box-shadow: 0 0 15px #58a6ff;
            animation: pulse 2s infinite alternate;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 15px #58a6ff; transform: scale(1); }
            100% { box-shadow: 0 0 30px #58a6ff; transform: scale(1.1); }
        }

        .nav-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #58a6ff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
        }

        .nav-button:hover {
            transform: scale(1.1);
            background: #1f6feb;
        }

        .active {
            background: #1f6feb;
        }


        .nav-panel {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 200px;
            background: #161b22;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            transition: transform 0.3s, opacity 0.3s;
            display: none;
            z-index: 999;
        }

        .nav-panel.open {
            display: block;
            transform: translateY(0);
        }

        .nav-panel a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: #c9d1d9;
            transition: background 0.3s;
        }

        .nav-panel a:hover {
            background: #58a6ff;
            color: black;
        }

        /*  Table CSS  */
        .table-container {
            width: 80%;
            margin: auto;
            background: #161b22;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container thead {
            position: sticky;
            top: 0;
            background: #0d1117; /* Ensure header visibility */
            z-index: 2;
        }

        .table-container tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .table-container th, .table-container td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #2d333b;
            white-space: nowrap; /* Prevent text wrapping */
        }

        .table-container tbody {
            display: block;
            max-height: 300px; /* Set max height */
            overflow-y: auto; /* Enable scrolling */
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #2d333b;

        }

        th {
            background: #0d1117;
            color: #58a6ff;
        }

        td {
            color: #c9d1d9;
        }

        .table-container tbody tr td{
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }

        /* Custom Scrollbar */
        .table-container tbody::-webkit-scrollbar {
            width: 10px;
        }

        .table-container tbody::-webkit-scrollbar-track {
            background: #ff5555;  /* Your requested background color */
            border-radius: 10px;
        }

        .table-container tbody::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 10px;
            border: 2px solid #ff5555;
        }

        .table-container tbody::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.9);
        }

        .view-btn {
            background: #58a6ff;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-btn {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .view-btn:hover { background: #1f6feb; }
        .delete-btn:hover { background: #cc0000; }

        #searchInput {
            float: right;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #58a6ff;
            background: #0d1117;
            color: #c9d1d9;
        }

        .add-new-button {
            background: #58a6ff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .add-new-button:hover {
            background: #1f6feb;
            transform: translateY(-2px);
        }

        .add-new-button a {
            all: unset; /* Resets all default link styles */
            cursor: pointer; /* Ensures it still looks clickable */
            text-decoration: none;
        }


        /*  Status color code  */
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
        }

        .badge-pending { background: #f39c12; }    /* Orange */
        .badge-confirmed { background: #3498db; }  /* Blue */
        .badge-completed { background: #2ecc71; }  /* Green */
        .badge-cancelled { background: #e74c3c; }  /* Red */

        @keyframes borderAnimation {
            0% {
                border-image-source: linear-gradient(45deg, red, white);
            }
            50% {
                border-image-source: linear-gradient(45deg, blue, white);
            }
            100% {
                border-image-source: linear-gradient(45deg, green, white);
            }
        }

        //* Style for visually disabled button */
        .delete-btn:disabled {
            background-color: #ccc !important;
            color: #666 !important;
            cursor: not-allowed !important;
            border: 1px solid #999 !important;
            opacity: 0.6;
        }

        /* Style for Re-Activate button */
        .reactivate-btn {
            background-color: #28a745; /* Green */
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .reactivate-btn:hover {
            background-color: #218838;
        }


    </style>

    <style>
        /*  CSS for Error Message Modal  */

        /* Backend Error - Red & Warn-Like */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
            display: none;
            font-family: 'Poppins', sans-serif;
            animation: fadeInSlide 0.5s ease-in-out;
        }
        #backendValidationModal {
            background: rgba(255, 0, 0, 0.2);
            color: white;
            border-left: 5px solid #ff4b2b;
            backdrop-filter: blur(8px);
        }

        /* Close Button */
        .alert span {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            position: absolute;
            top: 5px;
            right: 10px;
            transition: transform 0.3s ease;
        }

        .alert span:hover {
            transform: scale(1.2);
        }

        /* Alert Text */
        .alert p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }


    </style>

</head>
<body>

<!-- Main Body -->


<!-- Backend Validation Modal -->
<div id="backendValidationModal" class="alert">
    <span onclick="close_backend_modal();">&times;</span>
    <p id="backendValidationMessage"><?php echo $error_message; ?></p>
</div>


<!-- Centered Table -->
<div class="table-container" style="position: relative;">
    <div class="add-new-button" style="position: absolute; top: 10px; left: 10px;" ><a href="<?php echo $admin_create_user; ?>" style="">+ Add New</a></div>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search...">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <?php
        $statuses = [
            'active' => 'badge-completed',
            'deactivated' => 'badge-cancelled'
        ];

        foreach ($all_users as $user) {
            $status_lower = strtolower($user['status']);
            $role_lower = strtolower($user['role']);
            $badge_class = $statuses[$status_lower] ?? 'badge-default';

            // Disable delete button if role is 'admin' OR status is 'deactivated'
            $delete_disabled = ($role_lower === 'admin' || $status_lower === 'deactivated') ? 'disabled' : '';

            echo "<tr>
            <td>{$user['id']}</td>
            <td>{$user['email']}</td>
            <td style='
                        color: " .
                ($role_lower == 'admin' ? '#ff4500' :  // Orange-Red
                    ($role_lower == 'his' ? '#9b59b6' :   // Purple
                        ($role_lower == 'pacs' ? '#e67e22' :  // Deep Orange
                            ($role_lower == 'ris' ? '#f5f5f5' :   // Smoke-White (Off-White)
                                '#555')))) . ";

                        font-weight: bold;
                        animation: borderAnimation 2s infinite alternate;
                '>{$user['role']}</td>
            <td>{$user['created_at']}</td>
            <td><span class='badge $badge_class'>{$user['status']}</span></td>
            <td>";

            // Show "Delete" button for active users, "Re-Activate" button for deactivated users
            if ($status_lower === 'deactivated') {
                echo "<form action='$re_active_user_controller' method='POST'>
                    <input type='hidden' name='reactivate_user_id' value='{$user['id']}'>
                    <button type='submit' class='reactivate-btn'>Re-Activate</button>
                  </form>";
            } else {
                echo "<form action='$delete_user_controller' method='POST'>
                    <input type='hidden' name='delete_user_id' value='{$user['id']}'>
                    <button type='submit' class='delete-btn' $delete_disabled>De-activate</button>
                  </form>";
            }

            echo "</td>
          </tr>";
        }
        ?>
        </tbody>
    </table>
</div>





<div class="nav-button" onclick="toggleNav()">☰</div>
<div class="nav-panel" id="navPanel">
    <a href="<?php echo $admin_dashboard ; ?>">Home</a>
    <a class="active" href="<?php echo $admin_all_users ; ?>">Users</a>
    <a href="<?php echo $admin_all_patients ; ?>">Patients</a>
    <a href="<?php echo $admin_all_appointments ; ?>">Appointments</a>
    <a href="<?php echo $admin_all_schedules ; ?>">Schedules</a>
    <a href="<?php echo $admin_all_reports ; ?>">Reports</a>
    <a href="<?php echo $admin_all_bills ; ?>">Bills</a>
    <a href="<?php echo $admin_all_images ; ?>">Images</a>
    <a href="<?php echo $admin_all_logs ; ?>">Logs</a>
    <a href="<?php echo $logout_controller ; ?>">Logout</a>
</div>

<script>
    function toggleNav() {
        let navPanel = document.getElementById('navPanel');
        if (navPanel.style.display === "none" || navPanel.style.display === "") {
            navPanel.style.display = "block";
            setTimeout(() => navPanel.classList.add("open"), 10);
        } else {
            navPanel.classList.remove("open");
            setTimeout(() => navPanel.style.display = "none", 300);
        }
    }

    function searchTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toLowerCase();
        let rows = document.getElementById("tableBody").getElementsByTagName("tr");

        for (let row of rows) {
            let textContent = row.textContent.toLowerCase();
            row.style.display = textContent.includes(filter) ? "" : "none";
        }
    }

</script>

<script>
    // Show and Close Error Modal for Backend Validation
    window.onload = function () {
        var errorMessage = "<?php echo addslashes($error_message); ?>";
        if (errorMessage.trim() !== "") {
            document.getElementById('backendValidationModal').style.display = 'block';
        }
    };

    function close_backend_modal() {
        document.getElementById("backendValidationModal").style.display = "none";
    }
</script>




</body>
</html>
