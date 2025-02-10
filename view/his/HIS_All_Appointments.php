<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
require_once __DIR__ . '/../../model/appointmentRepo.php';
//include '../Loader.php';

// Navigation Routes Frontend
$Login_page = $routes['login'];
$his_dashboard = $routes["his_dashboard"];
$his_all_appointment = $routes["his_all_appointments"];
$his_all_bills = $routes["his_all_bills"];
$his_all_patients = $routes["his_all_patients"];
$his_create_appointment = $routes["his_create_appointment"];
$his_create_bill = $routes["his_create_bill"];
$his_create_patient = $routes["his_create_patient"];
$his_single_appointment = $routes["his_single_appointment"];
$his_single_bill = $routes["his_single_bill"];
$his_single_patient = $routes["his_single_patient"];




// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$delete_appointment_controller = $backend_routes['delete_appointment_controller'];


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}


// Gather Necessary Data
$user_id = $_SESSION["user_id"];
$all_appointments = findAllAppointments();




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIS - All Patients</title>
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

    </style>
</head>
<body>

<!-- Main Body -->

<!-- Centered Table -->
<div class="table-container" style="position: relative;">
    <div class="add-new-button" style="position: absolute; top: 10px; left: 10px;" ><a href="<?php echo $his_create_appointment; ?>" style="">+ Add New</a></div>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search...">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>View</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <?php
        // Assuming $all_patients is an array of associative arrays
        foreach ($all_appointments as $appointment) {
            $patient_name = getPatientNameByID($appointment['patient_id']);
            echo "<tr>
                    <td>{$appointment['id']}</td>
                    <td>{$patient_name}</td>
                    <td>{$appointment['appointment_date']}</td>
                    <td>{$appointment['status']}</td>
                    <td>
                        <form action='$his_single_appointment' method='POST'>
                            <input type='hidden' name='view_appointment_id' value='{$appointment['id']}'>
                            <button type='submit' class='view-btn'>View</button>
                        </form>
                    </td>
                    <td>
                        <form action='$delete_appointment_controller' method='POST'>
                            <input type='hidden' name='delete_appointment_id' value='{$appointment['id']}'>
                            <button type='submit' class='delete-btn'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</div>





<div class="nav-button" onclick="toggleNav()">☰</div>
<div class="nav-panel" id="navPanel">
    <a href="<?php echo $his_all_patients; ?>">Patients</a>
    <a href="<?php echo $his_all_appointment; ?>">Appointments</a>
    <a href="<?php echo $his_all_bills; ?>">Bills</a>
    <a href="<?php echo $logout_controller; ?>">Logout</a>
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



</body>
</html>
