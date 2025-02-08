<?php
global $routes, $backend_routes, $image_routes;
require '../../routes.php';
require_once __DIR__ . '/../../model/CalculationRepo.php';
require_once __DIR__ . '/../../view/Data_Provider.php';
//include '../Loader.php';

// Navigation Routes Frontend
$Login_page = $routes['login'];
$pacs_dashboard = $routes["pacs_dashboard"];
$pacs_view_images = $routes["pacs_view_images"];
$pacs_upload_images = $routes["pacs_upload_images"];


// Backend Routes
$logout_controller = $backend_routes['logout_controller'];
$pacs_upload_images_controller = $backend_routes['pacs_upload_images_controller'];

@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

// Gather Necessary Data
$user_id = $_SESSION["user_id"];

$allPatientsInfo = getAllPatientsInfo();
$allReportsInfo = getAllReportsInfo();



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACS - Upload Images</title>
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
        }

        .dashboard {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #161b22;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width 0.3s ease;
        }

        .sidebar h2 {
            text-align: center;
            color: #58a6ff;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            padding: 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .menu li:hover, .menu li.active {
            background: #58a6ff;
            transform: scale(1.05);
            color: black;
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #161b22;
            border-radius: 10px;
        }

        .top-bar h1 {
            font-size: 24px;
        }

        .logout-btn {
            padding: 10px 20px;
            background: #ff5555;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background: #ff2222;
            transform: scale(1.1);
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

        .fun-section {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .fun-box {
            flex: 1;
            min-width: 200px;
            background: #21262d;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .fun-box:hover {
            background: #58a6ff;
            color: black;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: fixed;
                height: 100vh;
                left: -100%;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }
        }

    /*  File Upload CSS  */

        .upload-container {
            border: 2px dashed #58a6ff;
            padding: 20px;
            margin: 30px;
            text-align: center;
            border-radius: 10px;
            background: #161b22;
            transition: background 0.3s ease, border 0.3s ease;
            cursor: pointer;
        }

        .upload-container:hover {
            background: #21262d;
            border-color: #c9d1d9;
        }

        .upload-container.active {
            background: #21262d;
            border-color: #c9d1d9;
        }

        .upload-container p {
            margin-top: 10px;
            color: #c9d1d9;
        }

        .preview-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 15px;
            gap: 10px;
            justify-content: center;
        }

        .preview-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid #58a6ff;
            transition: transform 0.3s ease;
        }

        .preview-image:hover {
            transform: scale(1.1);
            border-color: #c9d1d9;
        }

        .hidden-file-input {
            display: none;
        }

        .upload-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background: #58a6ff;
            border: none;
            border-radius: 5px;
            color: black;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .upload-btn:hover {
            background: #2f81f7;
            transform: scale(1.05);
        }

    /*  Drop-Down CSS  */
        .custom-dropdown {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: #21262d;
            color: #c9d1d9;
            border: 2px solid #58a6ff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .custom-dropdown:hover {
            border-color: #c9d1d9;
        }

        .custom-dropdown:focus {
            outline: none;
            background: #ff5555;
            color: white;
            border-color: #c9d1d9;
            box-shadow: 0px 0px 10px rgba(88, 166, 255, 0.6);
        }

    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>Picture Archiving and Communication System</h2>
        <ul class="menu">
            <li onclick="window.location.href='<?php echo $pacs_dashboard; ?>'">Overview</li>
            <li onclick="window.location.href='<?php echo $pacs_view_images; ?>'">View Images</li>
            <li class="active" onclick="window.location.href='<?php echo $pacs_upload_images; ?>'">Upload</li>

        </ul>
        <button class="logout-btn" onclick="window.location.href='<?php echo $logout_controller; ?>'">Logout</button>
    </div>

    <div class="content">
        <div class="top-bar">
            <h1>PACS - Upload</h1>
            <button class="logout-btn" onclick="window.location.href='<?php echo $logout_controller; ?>'">Logout</button>
        </div>

        <div id="main-content">
            <div id="upload_image" class="section" style="display:block;">
                <div class="card-container">
                    <div class="card"><h3>Upload Test Images</h3></div>
                </div>
                <!-- Write HTML, CSS, JS code to upload any kind of image here, inside this "card-container" div -->
                <div class="upload-container" id="drop-area">
                    <p>Drag & Drop Images Here or <span style="color: #58a6ff; text-decoration: underline; cursor: pointer;" onclick="document.getElementById('file-input').click();">Browse</span></p>
                    <input type="file" id="file-input" class="hidden-file-input" multiple accept="image/*">
                </div>

                <!-- Dropdowns for Patient ID, Report ID, and Image Type -->
                <select id="patientId" class="custom-dropdown">
                    <option value="" disabled selected>Select Patient</option>
                    <?php foreach ($allPatientsInfo as $patient): ?>
                        <option value="<?php echo $patient['id']; ?>">
                            <?php echo 'P' . str_pad($patient['id'], 3, '0', STR_PAD_LEFT). ' - '.$patient['name']. ' - '.$patient['dob']. ' - '.$patient['address']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select id="reportId" class="custom-dropdown">
                    <option value="" disabled selected>Select Report</option>
                    <?php foreach ($allReportsInfo as $report): ?>
                        <option value="<?php echo $report['id']; ?>">
                            <?php echo 'R' . str_pad($report['id'], 3, '0', STR_PAD_LEFT) . ' - ' . getPatientNameByID($report['patient_id']). ' - ' . $report['created_at']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <select id="image_type" class="custom-dropdown">
                    <option value="" disabled selected>Select Test Type</option>
                    <option value="X-Ray">X-Ray</option>
                    <option value="MRI">MRI</option>
                    <option value="CT Scan">CT Scan</option>
                </select>

                <div class="preview-container" id="preview-container"></div>

                <button class="upload-btn" onclick="uploadFiles()">Upload Images</button>

            </div>
        </div>
    </div>
</div>

<script>
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("file-input");
    const previewContainer = document.getElementById("preview-container");

    // Prevent default behavior for drag events
    ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop area on drag over
    ["dragenter", "dragover"].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add("active"), false);
    });

    ["dragleave", "drop"].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove("active"), false);
    });

    // Handle file drop
    dropArea.addEventListener("drop", handleDrop, false);
    fileInput.addEventListener("change", handleFiles, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles({ target: { files } });
    }

    function handleFiles(e) {
        const files = e.target.files;
        previewContainer.innerHTML = ""; // Clear previous previews
        selectedFiles = [];

        Array.from(files).forEach(file => {
            if (file.type.startsWith("image/")) {
                selectedFiles.push(file);
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = () => {
                    const img = document.createElement("img");
                    img.src = reader.result;
                    img.classList.add("preview-image");
                    previewContainer.appendChild(img);
                };
            } else {
                alert("Only image files are allowed!");
            }
        });
    }

    function uploadFiles() {
        if (selectedFiles.length === 0) {
            alert("Please select images to upload.");
            return;
        }

        const patientId = document.getElementById("patientId").value;
        const reportId = document.getElementById("reportId").value;
        const image_type = document.getElementById("image_type").value;

        if (!patientId || !image_type || !reportId) {
            alert("Please fill in all fields.");
            return;
        }

        const formData = new FormData();
        selectedFiles.forEach(file => formData.append("images[]", file));
        formData.append("patientId", patientId);
        formData.append("reportId", reportId);
        formData.append("image_type", image_type);

        fetch("<?php echo $pacs_upload_images_controller; ?>", {
            method: "POST",
            body: formData
        })
            // .then(response => response.text())
            .then(result => {
                alert(result);
                fileInput.value = ""; // Reset input
                previewContainer.innerHTML = ""; // Clear previews
                document.getElementById("patientId").value = ""; // Clear inputs
                document.getElementById("reportId").value = "";
                document.getElementById("image_type").value = "";
                selectedFiles = [];
            })
            .catch(error => console.error("Error uploading files:", error));
    }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        var allReports = <?php echo json_encode($allReportsInfo); ?>;

        $("#patientId").change(function () {
            var selectedPatientId = $(this).val();

            $("#reportId option").each(function () {
                var reportId = $(this).val();
                if (reportId !== "") { // Exclude the default "Select Report" option
                    var report = allReports.find(r => r.id == reportId);
                    if (report && report.patient_id != selectedPatientId) {
                        $(this).hide(); // Hide reports that don't match selected patient
                    } else {
                        $(this).show(); // Show reports that match selected patient
                    }
                }
            });
        });
    });
</script>


</body>
</html>
