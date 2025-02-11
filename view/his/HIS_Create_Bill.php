<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
require_once __DIR__ . '/../../model/patientRepo.php';
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

$paper_plane_image = $image_routes["paper_plane"];




// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$create_bill_controller = $backend_routes['create_bill_controller'];

// Gather Necessary Data
$user_id = $_SESSION["user_id"];
$all_patients = getAllPatientsInfo();
$error_message = "";
$update_appointment_id = -1;


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



$all_patients = findAllPatients();


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIS - Create Bill</title>

    <!--  Dynamic Search Purpose  -->
    <!-- Include jQuery and Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

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

    <style>
        /*    CSS for Number type input field, Spinner Removed    */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
<div class="form-container" id="formContainer">
    <h2>Appointment Details</h2>
    <form id="patient-form" action="<?php echo $create_bill_controller; ?>" method="POST">

        <div class="input-group">
            <input type="number" id="bill_amount" name="bill_amount" step="any">
            <label for="bill_amount">Billing Amount</label>
            <span class="error-message"></span>
        </div>


        <div class="input-group">
            <div class="custom-dropdown">
                <input type="text" id="patient_search" placeholder="Search Patient..." onkeyup="filterPatients()" onclick="toggleDropdown()">
                <div id="dropdown_list" class="dropdown-options">
                    <?php foreach ($all_patients as $patient): ?>
                        <div class="dropdown-item" onclick="selectPatient('<?php echo htmlspecialchars($patient['id']); ?>', '<?php echo htmlspecialchars($patient['id'] . ' - ' . $patient['name'] . ' - ' . $patient['address']); ?>')">
                            <?php echo htmlspecialchars($patient['id'] . ' - ' . $patient['name'] . ' - ' . $patient['address']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <input type="hidden" id="patient_id" name="patient_id">
            <label for="patient_id">Patient</label>
            <span class="error-message"></span>
        </div>

        <button type="submit" class="submit-btn">Create Bill</button>
    </form>
</div>

<img src="<?php echo $paper_plane_image; ?>" id="paperPlane" class="paper-plane">




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
        dateInput.setAttribute("min", today);
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
