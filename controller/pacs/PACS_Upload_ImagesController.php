<?php


global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/test_imageRepo.php';



session_start(); // Ensure session is started

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow cross-origin requests if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Ensure request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}


$uploader_id = $_SESSION['user_id'];
$uploadDir = __DIR__ . "/uploads/";

// Create uploads directory if not exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}


// Collect input fields
$patient_id = isset($_POST['patientId']) ? htmlspecialchars($_POST['patientId']) : null;
$report_id = isset($_POST['reportId']) ? htmlspecialchars($_POST['reportId']) : null;
$image_type = isset($_POST['image_type']) ? htmlspecialchars($_POST['image_type']) : null;

if (!$patient_id || !$report_id || !$image_type) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// Allowed image types
$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/dicom'];
$maxFileSize = 5 * 1024 * 1024; // 5MB limit

$uploadedFiles = [];
$upload_date = date('Y-m-d H:i:s'); // Current timestamp

if (!empty($_FILES['images'])) {
    $fileCount = count($_FILES['images']['name']);

    for ($i = 0; $i < $fileCount; $i++) {
        $fileTmpName = $_FILES['images']['tmp_name'][$i];
        $fileName = $_FILES['images']['name'][$i];
        $fileSize = $_FILES['images']['size'][$i];
        $fileType = mime_content_type($fileTmpName);

        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(["error" => "Invalid file type: $fileName"]);
            exit;
        }

        // Validate file size
        if ($fileSize > $maxFileSize) {
            echo json_encode(["error" => "File too large: $fileName"]);
            exit;
        }

        // Generate unique filename
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = "{$patient_id}_{$report_id}_{$image_type}_" . time() . "_$i.$fileExtension";
        $targetPath = $uploadDir . $newFileName;

        // Move file to uploads folder
        if (move_uploaded_file($fileTmpName, $targetPath)) {
            $uploadedFiles[] = $newFileName;

            // Insert image details into database
            $inserted_at = createTestImage($newFileName, $image_type, $upload_date, $patient_id, $report_id, $uploader_id);
        } else {
            echo json_encode(["error" => "Failed to upload: $fileName"]);
            exit;
        }
    }
}



// Success response
echo json_encode([
    "message" => "Images uploaded successfully",
    "uploaded_files" => $uploadedFiles
]);

