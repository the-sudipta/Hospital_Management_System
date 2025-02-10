<?php
//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/patientRepo.php';


@session_start();

$login_page = $routes['login'];
$his_all_patients_page = $routes['his_all_patients'];
$error_page_500 = $routes['internal_server_error'];

$user_id = $_SESSION['user_id'];

$everythingOK = FALSE;
$everythingOKCounter = 0;

$delete_patient_id = $_POST['delete_patient_id'];

$decision = false;

echo '<br><h1> Received Patient ID = '.$delete_patient_id.'</h1><br>';

try {
    $decision = deletePatient( $delete_patient_id);
    if ($decision) {
        echo '<br><h1> Decision Update = '.$decision.'</h1><br>';
        header("Location: {$his_all_patients_page}");
        exit;
    } else {
        $errorMessage = urldecode("Failed to delete the patient");
        header("Location: {$his_all_patients_page}?message=$errorMessage");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['backend_error'] = $e->getMessage();
    header("Location: {$error_page_500}");
    exit;
}
