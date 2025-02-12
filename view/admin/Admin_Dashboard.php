<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
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


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}


// Gather Necessary Data
$user_id = $_SESSION["user_id"];





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .circle-nav {
            position: relative;
            width: 350px;
            height: 350px;
            background: #161b22;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 15px rgba(88, 166, 255, 0.3);
        }

        .circle-nav .nav-item {
            position: absolute;
            width: 60px;
            height: 60px;
            background: #21262d;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }


        .circle-nav .nav-item:hover {
            transform: scale(1.5);
            background: #58a6ff;
        }

        .circle-nav .nav-item span {
            display: none;
            position: absolute;
            top: 75px;
            background: #58a6ff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .circle-nav .nav-item:hover span {
            display: block;
            z-index: -999;
        }


        .nav-item a {
            text-decoration: none;
            color: inherit;
            pointer-events: auto; /* Ensure links work */
            cursor: pointer;
        }

        .circle-nav .nav-item {
            z-index: 1; /* Set a base z-index */
        }
        .circle-nav .nav-item:hover {
            z-index: 10; /* Bring hovered item forward */
        }



        .nav-item:nth-child(1) { top: 20px; left: 50%; transform: translateX(-50%); }
        .nav-item:nth-child(2) { top: 80px; left: 80px; }
        .nav-item:nth-child(3) { top: 50%; left: 20px; transform: translateY(-50%); }
        .nav-item:nth-child(4) { bottom: 80px; left: 80px; }
        .nav-item:nth-child(5) { bottom: 20px; left: 50%; transform: translateX(-50%); }
        .nav-item:nth-child(6) { bottom: 80px; right: 80px; }
        .nav-item:nth-child(7) { top: 50%; right: 20px; transform: translateY(-50%); }
        .nav-item:nth-child(8) { top: 80px; right: 80px; }

        .nav-item a {
            text-decoration: none; /* Remove underline */
            color: inherit; /* Inherit text color from parent */
            cursor: default; /* Show default cursor */
        }
    </style>
</head>
<body>

<div class="circle-nav">


    <div class="nav-item"><span>Logs</span> <a style="cursor: pointer" href="<?php echo $admin_all_logs; ?>"><i class="fas fa-scroll"></i></a></div>
    <div class="nav-item"><span>Users</span><a style="cursor: pointer" href="<?php echo $admin_all_users; ?>"> <i class="fas fa-user"></i>  </a></div>
    <div class="nav-item"><span>Appointments</span> <a style="cursor: pointer" href="<?php echo $admin_all_appointments; ?>"><i class="fas fa-calendar-alt"></i></a></div>
    <div class="nav-item"><span>Bills</span> <a style="cursor: pointer" href="<?php echo $admin_all_bills; ?>"><i class="fas fa-file-invoice-dollar"></i></a></div>
    <div class="nav-item"><span>Patients</span> <a style="cursor: pointer" href="<?php echo $admin_all_patients; ?>"><i class="fas fa-procedures"></i></a></div>
    <div class="nav-item"><span>Schedules</span> <a style="cursor: pointer" href="<?php echo $admin_all_schedules; ?>"><i class="fas fa-clock"></i>  </a></div>
    <div class="nav-item"><span>Reports</span> <a style="cursor: pointer" href="<?php echo $admin_all_reports; ?>"><i class="fas fa-chart-bar"></i></a></div>
    <div class="nav-item"><span>Images</span> <a style="cursor: pointer" href="<?php echo $admin_all_images; ?>"><i class="fas fa-images"></i>️</a></div>
    <div class="nav-item"><span>Logout</span> <a style="cursor: pointer" href="<?php echo $logout_controller; ?>"><i class="fas fa-sign-out-alt"></i></a></div>
<!--    <div class="nav-item"><span>Home</span> <a style="cursor: pointer" href="--><?php //echo $admin_dashboard; ?><!--">🏠</a></div>-->


</div>




</body>
</html>




