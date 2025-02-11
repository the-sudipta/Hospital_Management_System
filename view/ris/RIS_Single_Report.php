<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
require_once __DIR__ . '/../../model/reportRepo.php';
require_once __DIR__ . '/../../model/patientRepo.php';
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

// Image Link
$paper_plane_image = $image_routes["paper_plane"];



// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$delete_report_controller = $backend_routes['delete_report_controller'];
$update_report_controller = $backend_routes['update_report_controller'];

$update_report_id = -1;

@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}



if (isset($_POST['view_report_id'])) {
    $update_report_id = $_POST['view_report_id'];
    // Redirect to prevent resubmission
    header("Location: {$ris_single_report}?id={$update_report_id}");
    exit();
}



// After redirection, retrieve the ID from GET
if (isset($_GET['id'])) {
    $update_report_id = $_GET['id'];
}

$single_report_data = findReportByID($update_report_id);
$patient_details = findPatientByID($single_report_data['patient_id']);




// Gather Necessary Data
$user_id = $_SESSION["user_id"];




$error_message = "";
// Message from Backend
if (isset($_GET['message'])) {
    $error_message = htmlspecialchars($_GET['message']);
    $show_backend_error_modal = true;
}


$statuses = [
    'pending' => 'status-pending',
    'reviewed' => 'status-completed',
    'cancelled' => 'status-cancelled'
];

$status = strtolower($single_report_data['status']); // Normalize status to lowercase
$status_class = $statuses[$status] ?? 'status-pending'; // Default to 'pending' if unknown


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
        /* Status Badge Styling */
        .status-badge {
            display: inline-block;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            padding: 10px;
            color: white;
            border: none;
            width: 100%;
        }

        .status-pending { background: #f39c12; }    /* Orange */
        .status-completed { background: #2ecc71; }  /* Green */
        .status-cancelled { background: #e74c3c; }  /* Red */
    </style>

    <!-- Searchable Dropdown CSS  -->
    <style>
        .custom-dropdown {
            position: relative;
            width: 100%;
        }

        .custom-dropdown input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: rgba(13, 17, 23, 0.7);
            color: #c9d1d9;
            font-size: 1rem;
            box-shadow: 0 0 8px rgba(88, 166, 255, 0.3);
            cursor: pointer;
        }

        .dropdown-options {
            display: none;
            position: absolute;
            width: 100%;
            background: rgba(22, 27, 34, 0.9);
            border-radius: 8px;
            border: 1px solid rgba(88, 166, 255, 0.4);
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0 0 15px rgba(88, 166, 255, 0.3);
            z-index: 1000;
        }

        .dropdown-item {
            padding: 10px;
            color: #c9d1d9;
            cursor: pointer;
            transition: background 0.2s ease-in-out;
            text-align: left; /* Left-align the text */
        }

        .dropdown-item:hover {
            background: rgba(88, 166, 255, 0.3);
        }
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
    <h1>RIS - Reports</h1>
    <div class="nav-links">
        <a href="<?php echo $ris_dashboard; ?>">Home</a>
        <a class="active" href="<?php echo $ris_all_reports; ?>">Reports</a>
        <a href="<?php echo $ris_all_schedule; ?>">Schedules</a>
        <a href="<?php echo $logout_controller; ?>">Logout</a>
    </div>
</nav>


<!-- Page Content Here -->

<div class="form-container" id="formContainer" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <h2>Report Details</h2>
    <form id="report-form" action="<?php echo $update_report_controller; ?>" method="POST">

        <input type='hidden' name='update_report_id' value="<?php echo $update_report_id; ?>">

        <div class="input-group">
            <input type="text" id="patient_name" name="patient_name" value="<?php echo $patient_details['name']; ?>" disabled>
            <label for="patient_name">Patient Name</label>
            <span class="error-message"></span>
        </div>

        <div class="input-group">
            <input type="text" id="report_text" name="report_text" value="<?php echo $single_report_data['report_text']; ?>" autocomplete="off" autofocus>
            <label for="report_text">Report Text</label>
            <span class="error-message"></span>
        </div>

        <div class="input-group">
            <input type="text" id="created_at" name="created_at" value="<?php echo $single_report_data['created_at']; ?>" disabled>
            <label for="created_at">Report Created At</label>
            <span class="error-message"></span>
        </div>

        <div class="input-group">
            <!-- Visible Status Badge -->
            <span class="status-badge <?php echo $status_class; ?>">
                <?php echo ucfirst(htmlspecialchars($status)); ?>
            </span>
            <input type="hidden" id="status" name="status" value="<?php echo htmlspecialchars($status); ?>">
            <label for="status">Report Status</label>
            <span class="error-message"></span>
        </div>




        <button type="submit" class="submit-btn">Update Report</button>
    </form>
</div>

<img src="<?php echo $paper_plane_image; ?>" id="paperPlane" class="paper-plane">








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
    document.getElementById("report-form").addEventListener("submit", function (event) {
        let isValid = true;
        let inputs = document.querySelectorAll(".form-container input, .form-container select, .form-container textarea");

        inputs.forEach(input => {
            let errorSpan = input.nextElementSibling.nextElementSibling;

            // Allow empty value for "report_text"
            if (input.id === "report_text" && input.value.trim() === "") {
                input.classList.remove("input-error");
                errorSpan.style.opacity = "0";
                return; // Skip further validation for this field
            }

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

</script>

<script>
    document.getElementById("report-form").addEventListener("submit", function(event) {
        let isValid = true;
        let inputs = document.querySelectorAll(".form-container input, .form-container select, .form-container textarea");

        inputs.forEach(input => {
            // Allow empty value for "report_text"
            if (input.id === "report_text" && input.value.trim() === "") {
                return;
            }

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
    //    Dynamic Search inside the Dropdown
    function toggleDropdown() {
        document.getElementById("dropdown_list").style.display = "block";
    }

    function filterPatients() {
        let input = document.getElementById("patient_search").value.toLowerCase();
        let items = document.querySelectorAll(".dropdown-item");

        items.forEach(item => {
            item.style.display = item.innerText.toLowerCase().includes(input) ? "block" : "none";
        });
    }

    function selectPatient(id, text) {
        document.getElementById("patient_search").value = text;
        document.getElementById("patient_id").value = id;
        document.getElementById("dropdown_list").style.display = "none";
    }

    document.addEventListener("click", function(event) {
        let dropdown = document.getElementById("dropdown_list");
        let searchBox = document.getElementById("patient_search");

        if (!dropdown.contains(event.target) && event.target !== searchBox) {
            dropdown.style.display = "none";
        }
    });
</script>


</body>
</html>





