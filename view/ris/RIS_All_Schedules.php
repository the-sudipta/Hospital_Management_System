<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
require_once __DIR__ . '/../../model/test_scheduleRepo.php';
//include '../Loader.php';

// Navigation Routes Frontend
$Login_page = $routes['login'];
$ris_dashboard = $routes["ris_dashboard"];
$ris_all_reports = $routes["ris_all_reports"];
$ris_all_schedule = $routes["ris_all_schedules"];
$ris_create_report = $routes["ris_create_report"];
$ris_create_schedule = $routes["ris_create_schedule"];
$ris_single_report = $routes["ris_single_report"];
$ris_single_schedule = $routes["ris_single_schedule"];





// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$delete_schedule_controller = $backend_routes['delete_schedule_controller'];


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}


// Gather Necessary Data
$user_id = $_SESSION["user_id"];
$all_schedules = findAllTestSchedules();



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
    <title>RIS - All Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: linear-gradient(45deg, #161b22, #0d1117);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .navbar h1 {
            color: #58a6ff;
            font-size: 24px;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            position: absolute;
            right: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #c9d1d9;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .nav-links a:hover {
            background: #58a6ff;
            color: black;
            transform: scale(1.1);
        }

        .navbar .nav-links .active {
            background: #58a6ff;
            color: black;
            transform: scale(1.1);
        }

        .dashboard {
            display: flex;
            height: 100%;
            flex-direction: column;
            overflow-y: auto;
            padding: 20px;
            gap: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: #21262d;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(88, 166, 255, 0.3);
        }

        .card h3 {
            margin-bottom: 10px;
            color: #58a6ff;
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
            z-index: 9999; /* Ensures it stays above everything */
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

    <style>
        /* Custom card styles */
        .stats-card {
            position: relative;
            overflow: hidden;
            padding: 25px;
            border-radius: 12px;
            transition: all 0.4s ease-in-out;
        }

        .stats-card::before {
            content: "";
            position: absolute;
            top: -100%;
            left: -100%;
            width: 250%;
            height: 250%;
            background: radial-gradient(circle, rgba(88, 166, 255, 0.2) 10%, transparent 70%);
            transition: all 0.5s ease-in-out;
        }

        .stats-card:hover::before {
            top: 0;
            left: 0;
        }

        .stats-card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0px 10px 20px rgba(88, 166, 255, 0.5);
        }

        .stats-card h3 {
            font-size: 22px;
            font-weight: bold;
            color: #58a6ff;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #c9d1d9;
            transition: all 0.5s ease;
        }
    </style>

    <style>
        /* Custom styles for the calendar */
        .calendar {
            background: #21262d;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(88, 166, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .calendar:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(88, 166, 255, 0.5);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #58a6ff;
            margin-bottom: 10px;
        }

        .calendar-btn {
            background: none;
            border: none;
            color: #58a6ff;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .calendar-btn:hover {
            color: #ffffff;
            transform: scale(1.2);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            font-weight: bold;
        }

        .calendar-day {
            color: #c9d1d9;
            padding: 5px;
        }

        .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-date {
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            background: #161b22;
            color: #c9d1d9;
        }

        .calendar-date:hover {
            background: #58a6ff;
            color: #000;
            transform: scale(1.1);
        }

        .scheduled {
            background: rgba(88, 166, 255, 0.3);
            border: 2px solid #58a6ff;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #21262d;
            padding: 20px;
            border-radius: 10px;
            color: #c9d1d9;
            width: 300px;
            text-align: center;
        }

        .close-modal {
            float: right;
            font-size: 20px;
            cursor: pointer;
            color: #58a6ff;
        }

        .close-modal:hover {
            color: red;
        }
    </style>

    <style>
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

        .table-container tr td {
            color: #c9d1d9;
            word-wrap: break-word; /* Ensures long words break */
            overflow-wrap: break-word; /* Supports better text wrapping */
            white-space: normal; /* Allows wrapping */
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

    </style>

</head>
<body>

<!-- Backend Validation Modal -->
<div id="backendValidationModal" class="alert">
    <span onclick="close_backend_modal();">&times;</span>
    <p id="backendValidationMessage"><?php echo $error_message; ?></p>
</div>

<!-- Navbar -->
<nav class="navbar">
    <h1>RIS - Schedule</h1>
    <div class="nav-links">
        <a href="<?php echo $ris_dashboard; ?>">Home</a>
        <a href="<?php echo $ris_all_reports; ?>">Reports</a>
        <a class="active" href="<?php echo $ris_all_schedule; ?>">Schedules</a>
        <a href="<?php echo $logout_controller; ?>">Logout</a>
    </div>
</nav>


<!-- Page Content Here -->
<!-- Centered Table -->
<div class="table-container" style="position: relative;">
    <div class="add-new-button" style="position: absolute; top: 10px; left: 10px;" ><a href="<?php echo $ris_create_schedule; ?>" style="">+ Add New</a></div>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search...">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Exam Type</th>
            <th>View</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <?php
        $statuses = [
            'pending' => 'badge-pending',
            'reviewed' => 'badge-completed',
            'cancelled' => 'badge-cancelled'
        ];

        foreach ($all_schedules as $schedule) {
            $patient_name = getPatientNameByID($schedule['patient_id']);

            // Check if report_text is empty or null
//            $report_text = !empty($report['report_text']) ? $report['report_text'] : "<span style='color: yellow;'>Under Processing</span>";

            echo "<tr>
                    <td>{$schedule['id']}</td>
                    <td>{$patient_name}</td>
                    <td>{$schedule['exam_type']}</td>
                    <td>
                        <form action='$ris_single_schedule' method='POST'>
                            <input type='hidden' name='view_schedule_id' value='{$schedule['id']}'>
                            <button type='submit' class='view-btn'>View</button>
                        </form>
                    </td>
                    <td>
                        <form action='$delete_schedule_controller' method='POST'>
                            <input type='hidden' name='delete_schedule_id' value='{$schedule['id']}'>
                            <button type='submit' class='delete-btn'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>

        </tbody>
    </table>
</div>





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

<script>
    //    Table Script
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

</body>
</html>





