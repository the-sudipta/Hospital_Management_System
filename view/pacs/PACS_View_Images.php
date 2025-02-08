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
$image_location = $routes["image_location"];


// Backend Routes
$logout_controller = $backend_routes['logout_controller'];


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

// Gather Necessary Data
$user_id = $_SESSION["user_id"];
$all_x_ray_images = getImagesByImageType("X-Ray");
$all_mri_images = getImagesByImageType("MRI");
$all_ct_scan_images = getImagesByImageType("CT Scan");


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PACS - Images</title>
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

    /*  Image Viewer CSS  */
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
        }

        .dummy-image p {
            margin-top: 5px;
            font-size: 14px;
            color: #c9d1d9;
        }

    /*    Image in Pop-up window/modal CSS */
        /* Modal as a Pop-up Card */
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

        /* Card-style container */
        .modal-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
            text-align: center;
            position: relative;
        }

        /* Image inside the card */
        /* New Modal Background to Match Your Page */
        .custom-modal-card {
            background: #222;  /* Darker background */
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.6);
            max-width: 600px;  /* Slightly larger */
            width: 90%;
            text-align: center;
            position: relative;
            font-family: Arial, sans-serif;
        }

        /* Enlarged Image */
        .custom-modal-content {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 3px solid #fff;  /* White border around the image */
        }

        /* Details Section */
        .custom-modal-details {
            margin-top: 15px;
            font-size: 14px;
            color: #ddd;
            text-align: left;
            padding: 10px;
            border-top: 1px solid #444; /* Subtle separation */
        }

        /* Static Labels */
        .custom-label {
            font-weight: bold;
            color: #f8c471;  /* Gold color for labels */
        }

        /* Close Button */
        .custom-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #f8c471;  /* Gold color */
            cursor: pointer;
        }
        .custom-close:hover {
            color: white;
        }



    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>Picture Archiving and Communication System</h2>
        <ul class="menu">
            <li onclick="window.location.href='<?php echo $pacs_dashboard; ?>'">Overview</li>
            <li class="active" onclick="window.location.href='<?php echo $pacs_view_images; ?>'">View Images</li>
            <li onclick="window.location.href='<?php echo $pacs_upload_images; ?>'">Upload</li>

        </ul>
        <button class="logout-btn" onclick="window.location.href='<?php echo $logout_controller; ?>'">Logout</button>
    </div>

    <div class="content">
        <div class="top-bar">
            <h1>PACS - Images</h1>
            <button class="logout-btn" onclick="window.location.href='<?php echo $logout_controller; ?>'">Logout</button>
        </div>

        <div id="main-content">

            <div id="images" class="section" style="display:block;">
                <div class="card-container">
                    <div class="card"><h3>X-Ray</h3>
                        <!--                    Show some dummy images as a folder-explorer but in a single column    -->
                        <div class="dummy-images-container">
                            <?php foreach ($all_x_ray_images as $image) :
                                $full_image_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $image_location . $image['image']; // Construct absolute path
                                if (!file_exists($full_image_path)) continue; // Skip if file not found
                                ?>
                                <div class="dummy-image">
                                    <img src="<?php echo $image_location . $image['image']; ?>" onclick="openModal(this)"
                                         data-patient-name="<?php echo getPatientNameByID($image['patient_id']); ?>"
                                         data-upload-date="<?php echo $image['upload_date']; ?>"
                                         data-report-id="<?php echo $image['report_id']; ?>"
                                         data-report-text="<?php echo getReportTextByReportID($image['report_id']) ?: 'Awaiting doctor’s review'; ?>"
                                         alt="X-Ray"
                                    >
                                    <p><?php echo getPatientNameByID($image['patient_id']); ?></p>
<!--                                    <p><?php echo getPatientNameByID($image['patient_id']) . " - " . $image['upload_date']; ?></p>-->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card"><h3>MRI</h3>
                        <!--                    Show some dummy images as a folder-explorer but in a single column    -->
                        <div class="dummy-images-container">
                            <?php foreach ($all_mri_images as $image) :
                                $full_image_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $image_location . $image['image'];
                                if (!file_exists($full_image_path)) continue;
                                ?>
                                <div class="dummy-image">
                                    <img src="<?php echo $image_location . $image['image']; ?>" onclick="openModal(this)"
                                         data-patient-name="<?php echo getPatientNameByID($image['patient_id']); ?>"
                                         data-upload-date="<?php echo $image['upload_date']; ?>"
                                         data-report-id="<?php echo $image['report_id']; ?>"
                                         data-report-text="<?php echo getReportTextByReportID($image['report_id']) ?: 'Awaiting doctor’s review'; ?>"
                                         alt="MRI"
                                    >
                                    <p><?php echo getPatientNameByID($image['patient_id']); ?></p>
<!--                                    <p><?php echo getPatientNameByID($image['patient_id']) . " - " . $image['upload_date']; ?></p>-->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card"><h3>CT Scan</h3>
                        <!--                    Show some dummy images as a folder-explorer but in a single column    -->
                        <div class="dummy-images-container">
                            <?php foreach ($all_ct_scan_images as $image) :
                                $full_image_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $image_location . $image['image'];
                                if (!file_exists($full_image_path)) continue;
                                ?>
                                <div class="dummy-image">
                                    <img src="<?php echo $image_location . $image['image']; ?>" onclick="openModal(this)"
                                         data-patient-name="<?php echo getPatientNameByID($image['patient_id']); ?>"
                                         data-upload-date="<?php echo $image['upload_date']; ?>"
                                         data-report-id="<?php echo $image['report_id']; ?>"
                                         data-report-text="<?php echo getReportTextByReportID($image['report_id']) ?: 'Awaiting doctor’s review'; ?>"
                                         alt="CT Scan"
                                    >
                                    <p><?php echo getPatientNameByID($image['patient_id']); ?></p>
<!--                                    <p><?php echo getPatientNameByID($image['patient_id']) . " - " . $image['upload_date']; ?></p>-->
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="imageModal" class="modal">
    <div class="custom-modal-card">
        <span class="custom-close" onclick="closeModal()">&times;</span>
        <img class="custom-modal-content" id="modalImage">
        <div class="custom-modal-details" id="imageDetails">
            <!-- Dynamic details will be inserted here -->
        </div>
    </div>
</div>




<script>

//  Modal Controller
function openModal(imgElement) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    var detailsContainer = document.getElementById("imageDetails");

    modal.style.display = "flex";
    modalImg.src = imgElement.src;

    // Fetch details from data attributes
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
