<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
require_once __DIR__ . '/../../model/patientRepo.php';
require_once __DIR__ . '/../../model/reportRepo.php';
require_once __DIR__ . '/../../model/test_imageRepo.php';
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

$image_location = $routes["image_location"];

$paper_plane_image = $image_routes["paper_plane"];




// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$update_patient_controller = $backend_routes['update_patient_controller'];

// Gather Necessary Data
$user_id = $_SESSION["user_id"];
$all_patients = getAllPatientsInfo();
$error_message = "";
$upcoming_test_schedule = "";
$upcoming_appointment_date = "";
$update_patient_id = -1;


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

// Message from Backend
if (isset($_GET['message'])) {
    $error_message = htmlspecialchars($_GET['message']);
    $show_backend_error_modal = true;
}



if (isset($_POST['view_patient_id'])) {
    $update_patient_id = $_POST['view_patient_id'];
    // Redirect to prevent resubmission
    header("Location: {$his_single_patient}?id={$update_patient_id}");
    exit();
}

// After redirection, retrieve the ID from GET
if (isset($_GET['id'])) {
    $update_patient_id = $_GET['id'];
}

$single_patient_data = findPatientById($update_patient_id);
$all_reports_of_the_patient = findAllReportsByPatientID($update_patient_id);
$all_images_of_the_patient = findAllTestImagesByPatientID($update_patient_id);
$upcoming_test_schedule = getUpcomingTestSchedule($update_patient_id);
$upcoming_appointment_date = getUpcomingAppointment($update_patient_id);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIS - Update Patient Info</title>
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

    </style>

    <style>
        /*        Patient Form CSS    */
        @keyframes pulse {
            0% { box-shadow: 0 0 15px rgba(88, 166, 255, 0.3); }
            50% { box-shadow: 0 0 25px rgba(88, 166, 255, 0.6); }
            100% { box-shadow: 0 0 15px rgba(88, 166, 255, 0.3); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }

        .form-container {
            background: rgba(22, 27, 34, 0.6);
            padding: 25px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(88, 166, 255, 0.4);
            box-shadow: 0 0 20px rgba(88, 166, 255, 0.3);
            animation: pulse 3s infinite alternate;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #58a6ff;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: rgba(13, 17, 23, 0.7);
            color: #c9d1d9;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 8px rgba(88, 166, 255, 0.3);
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-bottom: 2px solid #1f6feb;
            box-shadow: 0 0 12px rgba(88, 166, 255, 0.7);
        }

        .input-group label {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #58a6ff;
            font-size: 1rem;
            transition: 0.3s;
            pointer-events: none;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label,
        .input-group select:focus + label,
        .input-group select:not([value=""]) + label,
        .input-group textarea:focus + label,
        .input-group textarea:not(:placeholder-shown) + label {
            top: -15px;
            left: 8px;
            font-size: 0.9rem;
            color: #1f6feb;
        }

        .error-message {
            color: #ff7b72;
            font-size: 0.8rem;
            position: absolute;
            left: 10px;
            bottom: -20px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .input-error {
            border: 2px solid #ff7b72 !important;
            animation: shake 0.3s ease-in-out;
        }

        .submit-btn {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #1f6feb, #58a6ff);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(88, 166, 255, 0.4);
        }

    </style>

    <style>
        /* Initially Hide the Paper Plane */
        .paper-plane {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150px;
            height: 150px;
            opacity: 0;
            transform: translate(-50%, -50%);
            transition: opacity 0.5s ease-in-out, transform 1s ease-in-out;
        }

        /* Form Fade-Out Animation */
        .form-fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        /* Paper Plane Slide Animation */
        .fly-away {
            opacity: 1 !important;
            /*transform: translate(100vw, -50vh) rotate(45deg);*/
            transform: translateX(100vw);
            transition: transform 1.5s ease-in-out;
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

    <style>
        /*    2 Side-By-Side cards    */
        .form-wrapper {
            display: flex;
            gap: 20px; /* Space between forms */
            justify-content: center; /* Center align the forms */
        }

    </style>

    <style>

        /*    Right Side Container CSS    */

        #formContainer_right_side {
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .content {
            width: 100%;
            text-align: center;
            min-height: 150px; /* Ensures content area stays visible */
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .breadcrumb-tabs {
            position: absolute;
            bottom: 10px; /* Positions the tabs at the bottom */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .tab {
            background-color: #f0f0f0;
            color: black;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .tab:hover {
            background-color: #ddd;
        }

        .tab.active {
            background: linear-gradient(45deg, #1f6feb, #58a6ff);
            color: white;
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.2);
            transform: translateY(+4px);
        }

        .separator {
            width: 85%;
            height: 2px;
            background-color: #ccc; /* Adjust color */
            border: none;
            margin-bottom: 10px; /* Space before the tabs */
        }
    </style>

    <style>
        /*    Right Side Container's 3 cards CSS    */
        .cards-container {
            display: flex;
            flex-wrap: wrap; /* Allows cards to wrap when needed */
            justify-content: center; /* Centers items when wrapping */
            gap: 15px;
            margin-top: 20px;
        }


        .detail-card {
            background: rgba(20, 20, 30, 0.9);
            border-radius: 10px;
            padding: 15px;
            width: 30%; /* Adjust this based on your layout */
            min-width: 250px; /* Ensures the cards don’t shrink too much */
            box-shadow: 0px 0px 15px rgba(0, 191, 255, 0.5);
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .detail-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 0px 25px rgba(0, 191, 255, 0.7);
        }

        .detail-card h3 {
            color: #3a82f7;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .detail-card p {
            color: #ccc;
            font-size: 14px;
        }

        .detail-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 0px 25px rgba(0, 191, 255, 0.7);
        }

    </style>

    <style>
        /*    Report table CSS    */

        /* Scrollable Table Wrapper */
        .table-wrapper {
            max-height: 250px;
            overflow-x: auto;
            overflow-y: auto;
            border-radius: 10px;
            border: 1px solid #2d333b;
            padding: 5px;
            background: #161b22;
        }

        /* Table Styling */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            background: #0d1117;
        }

        /* Table Headers */
        .report-table th {
            background: #0d1117;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #58a6ff;  /* Blue accent */
            border-bottom: 2px solid #2d333b;
        }

        /* Table Rows */
        .report-table td {
            padding: 10px;
            border-bottom: 1px solid #2d333b;
            color: #c9d1d9;  /* Soft grayish-white */
        }

        /* Alternate Row Colors */
        .report-table tr:nth-child(even) {
            background: #161b22;
        }

        /* Status Colors */
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        /* Pending Status - Soft Yellow */
        .status-pending {
            background: #ffdd57;
            color: #000;
        }

        /* Reviewed Status - Blue */
        .status-reviewed {
            background: #28A745;
            color: #fff;
        }

        /* Custom Scrollbar */
        .table-wrapper::-webkit-scrollbar {
            width: 10px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #0d1117;
            border-radius: 10px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #58a6ff;
            border-radius: 10px;
            border: 2px solid #161b22;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #1f6feb;
        }

    </style>

    <style>
        /*    Image Display CSS    */

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
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
            color: #58a6ff;
        }

        .dummy-images-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10px;
        }

        .dummy-image {
            background: #161b22;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .dummy-image:hover {
            transform: scale(1.1);
            background: #58a6ff;
        }

        .dummy-image img {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            object-fit: cover;
            cursor: pointer;
        }

        .dummy-image p {
            margin-top: 5px;
            font-size: 14px;
            color: #c9d1d9;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .custom-modal-card {
            position: relative; /* Ensures the close button is positioned within this div */
            background: #222;
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.6);
            max-width: 600px;
            width: 90%;
            text-align: center;
        }

        .custom-modal-content {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 3px solid #fff;
        }

        .custom-modal-details {
            margin-top: 15px;
            font-size: 14px;
            color: #ddd;
            text-align: left;
            padding: 10px;
            border-top: 1px solid #444;
        }

        .custom-label {
            font-weight: bold;
            color: #f8c471;
        }

        .custom-close {
            position: absolute;
            top: 10px;
            right: 10px; /* Adjusted to stay inside the modal card */
            font-size: 28px;
            font-weight: bold;
            color: #f8c471;
            cursor: pointer;
            background: transparent;
            border: none;
        }

        .custom-close:hover {
            color: white;
        }


    </style>




</head>
<body>


<!-- Backend Validation Modal -->
<div id="backendValidationModal" class="alert">
    <span onclick="close_backend_modal();">&times;</span>
    <p id="backendValidationMessage"><?php echo $error_message; ?></p>
</div>

<!-- Main Body -->
<div class="form-wrapper">
    <div class="form-container" id="formContainer">
        <h2>Update Patient Information</h2>
        <form id="patient-form" action="<?php echo $update_patient_controller; ?>" method="POST">
            <input type='hidden' name='update_patient_id' value="<?php echo $single_patient_data['id']?>">
            <div class="input-group">
                <input type="text" id="name" name="name" value="<?php echo $single_patient_data['name']?>">
                <label for="name">Name</label>
                <span class="error-message"></span>
            </div>

            <div class="input-group">
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $single_patient_data['dob']?>">
                <label for="date_of_birth">Date of Birth</label>
                <span class="error-message"></span>
            </div>

            <div class="input-group">
                <select id="gender" name="gender">
                    <option value="" disabled <?php echo empty($single_patient_data['gender']) ? 'selected' : ''; ?>></option>
                    <option value="Male" <?php echo ($single_patient_data['gender'] == "Male") ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($single_patient_data['gender'] == "Female") ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($single_patient_data['gender'] == "Other") ? 'selected' : ''; ?>>Other</option>
                </select>
                <label for="gender">Gender</label>
                <span class="error-message"></span>
            </div>

            <div class="input-group">
                <input type="text" id="contact" name="contact" value="<?php echo $single_patient_data['contact']?>">
                <label for="contact">Contact</label>
                <span class="error-message"></span>
            </div>

            <div class="input-group">
                <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($single_patient_data['address']); ?></textarea>
                <label for="address">Address</label>
                <span class="error-message"></span>
            </div>

            <button type="submit" class="submit-btn">Update Patient Info</button>
        </form>
    </div>

    <div class="form-container" id="formContainer_right_side">
        <div class="content">
            <div id="detailsContent" class="tab-content active">
                <h2>Details Section</h2>
                <div class="cards-container">
                    <div class="detail-card">
                        <h3>Upcoming Test Schedule</h3>
                        <p><?php echo (is_array($upcoming_test_schedule)) ? htmlspecialchars($upcoming_test_schedule['exam_type']).' - '.htmlspecialchars($upcoming_test_schedule['date']) : 'No upcoming test scheduled'; ?></p>
                    </div>
                    <div class="detail-card">
                        <h3>Appointments</h3>
                        <p><?php echo (!empty($upcoming_appointment_date))? htmlspecialchars($upcoming_appointment_date) : 'No upcoming Appointment scheduled'; ?></p>
                    </div>

                    <div class="table-wrapper">
                        <table class="report-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Report Text</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($all_reports_of_the_patient as $report): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($report['id']); ?></td>
                                    <td><?php echo !empty($report['report_text']) ? htmlspecialchars($report['report_text']) : 'Awaiting doctor’s review'; ?></td>
                                    <td>
                            <span class="status
                                <?php echo ($report['status'] == 'Pending') ? 'status-pending' : 'status-reviewed'; ?>">
                                <?php echo $report['status']; ?>
                            </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div id="testImagesContent" class="tab-content">
                <div id="images" class="section">
                    <div class="card-container">
                        <h3>Diagnostic Images</h3>
                        <div class="card">

                            <div class="dummy-images-container">
                                <?php foreach ($all_images_of_the_patient as $image) :
                                    $full_image_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $image_location . $image['image'];
                                    if (!file_exists($full_image_path)) continue;
                                    ?>
                                    <div class="dummy-image">
                                        <img src="<?php echo $image_location . $image['image']; ?>"
                                             onclick="openModal(this)"
                                             data-patient-name="<?php echo getPatientNameByID($image['patient_id']); ?>"
                                             data-upload-date="<?php echo $image['upload_date']; ?>"
                                             data-report-id="<?php echo $image['report_id']; ?>"
                                             data-report-text="<?php echo getReportTextByReportID($image['report_id']) ?: 'Awaiting doctor’s review'; ?>"
                                             alt="X-Ray">
                                        <p><?php echo $image['id'] .' - '. $image['image_type']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="breadcrumb-tabs">
            <div class="tab" id="detailsTab" onclick="switchTab('details')">Details</div>
            <div class="tab" id="testImagesTab" onclick="switchTab('testImages')">Diagnosis</div>
        </div>
    </div>

</div>

<img src="<?php echo $paper_plane_image; ?>" id="paperPlane" class="paper-plane">

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <div class="custom-modal-card">
        <span class="custom-close" onclick="closeModal()">&times;</span>
        <img id="modalImage" class="custom-modal-content">
        <div id="imageDetails" class="custom-modal-details"></div>
    </div>
</div>




<div class="nav-button" onclick="toggleNav()">☰</div>
<div class="nav-panel" id="navPanel">
    <a href="<?php echo $his_all_patients; ?>">Patients</a>
    <a href="<?php echo $his_all_appointment; ?>">Appointments</a>
    <a href="<?php echo $his_all_bills; ?>">Bills</a>
    <a href="<?php echo $logout_controller; ?>">Logout</a>
</div>

<script>
    //    Page Navigation
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
</script>

<script>
    document.getElementById("patient-form").addEventListener("submit", function (event) {
        let isValid = true;
        let inputs = document.querySelectorAll(".form-container input, .form-container select, .form-container textarea");

        inputs.forEach(input => {
            let errorSpan = input.nextElementSibling.nextElementSibling;
            if (input.value.trim() === "") {
                input.classList.add("input-error");
                errorSpan.innerText = input.previousElementSibling.innerText + " is required.";
                errorSpan.style.opacity = "1";
                isValid = false;
            } else {
                input.classList.remove("input-error");
                errorSpan.style.opacity = "0";
            }
        });

        if (!isValid) {
            event.preventDefault(); // Stop animation & submission if validation fails
        }
    });

    document.querySelectorAll(".form-container input, .form-container select, .form-container textarea").forEach(input => {
        input.addEventListener("input", () => {
            input.classList.remove("input-error");
            input.nextElementSibling.nextElementSibling.style.opacity = "0";
        });
    });

    // Prevent selecting future dates in the calendar
    document.querySelectorAll('input[type="date"]').forEach(dateInput => {
        let today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
        dateInput.setAttribute("max", today);
    });
</script>

<script>
    document.getElementById("patient-form").addEventListener("submit", function(event) {
        let isValid = true;
        let inputs = document.querySelectorAll(".form-container input, .form-container select, .form-container textarea");

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault(); // Stop animation & submission if validation fails
            return;
        }

        event.preventDefault(); // Prevent form submission for animation

        let formContainer = document.getElementById("formContainer");
        let paperPlane = document.getElementById("paperPlane");
        let form = this; // Reference to the form

        // Fade out the form
        formContainer.classList.add("form-fade-out");

        setTimeout(() => {
            formContainer.style.display = "none"; // Hide the form completely
            paperPlane.style.opacity = "1"; // Show the paper plane

            // Make the paper plane fly out
            setTimeout(() => {
                paperPlane.classList.add("fly-away");

                // **Submit the form after animation**
                setTimeout(() => {
                    form.submit();
                }, 1000); // Adjust timing if needed (should be after the fly-away animation)

            }, 100);

        }, 500); // Wait for form fade-out to complete
    });
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


<script>
//    JavaScript for Tab Switching
    function showTab(tab) {
        document.getElementById('detailsContent').style.display = (tab === 'details') ? 'block' : 'none';
        document.getElementById('testImagesContent').style.display = (tab === 'testImages') ? 'block' : 'none';

        // Change button styles
        document.getElementById('detailsTab').style.backgroundColor = (tab === 'details') ? '#007bff' : '#f1f1f1';
        document.getElementById('detailsTab').style.color = (tab === 'details') ? 'white' : 'black';

        document.getElementById('testImagesTab').style.backgroundColor = (tab === 'testImages') ? '#007bff' : '#f1f1f1';
        document.getElementById('testImagesTab').style.color = (tab === 'testImages') ? 'white' : 'black';
    }
</script>

<script>
    function switchTab(tabName) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));

        // Hide all content sections
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        // Activate the selected tab and show its content
        document.getElementById(tabName + 'Tab').classList.add('active');
        document.getElementById(tabName + 'Content').classList.add('active');
    }

    // Set default active tab
    document.addEventListener('DOMContentLoaded', () => {
        switchTab('details');
    });

</script>

<script>
//    Image Display Modal
    function openModal(imgElement) {
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("modalImage");
        var detailsContainer = document.getElementById("imageDetails");

        modal.style.display = "flex";
        modalImg.src = imgElement.src;

        var patientName = imgElement.getAttribute("data-patient-name");
        var uploadDate = imgElement.getAttribute("data-upload-date");
        var reportId = imgElement.getAttribute("data-report-id");
        var reportText = imgElement.getAttribute("data-report-text");

        detailsContainer.innerHTML = `
        <p><span class="custom-label">Patient Name:</span> ${patientName}</p>
        <p><span class="custom-label">Upload Date:</span> ${uploadDate}</p>
        <p><span class="custom-label">Report ID:</span> ${reportId}</p>
        <p><span class="custom-label">Report Text:</span> ${reportText}</p>
    `;
    }

    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }

</script>


</body>
</html>
