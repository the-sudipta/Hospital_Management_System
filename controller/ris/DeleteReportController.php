<?php
//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/reportRepo.php';


@session_start();

$login_page = $routes['login'];
$ris_all_report_page = $routes['ris_all_reports'];
$error_page_500 = $routes['internal_server_error'];

$user_id = $_SESSION['user_id'];

$everythingOK = FALSE;
$everythingOKCounter = 0;

$delete_report_id = $_POST['delete_report_id'];

$decision = false;

echo '<br><h1> Received Patient ID = '.$delete_report_id.'</h1><br>';

try {
    $decision = deleteReport( $delete_report_id);
    if ($decision) {
        echo '<br><h1> Decision Update = '.$decision.'</h1><br>';
        header("Location: {$ris_all_report_page}");
        exit;
    } else {
        $errorMessage = urldecode("Failed to delete the bill");
        header("Location: {$ris_all_report_page}?message=$errorMessage");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['backend_error'] = $e->getMessage();
    header("Location: {$error_page_500}");
    exit;
}
