<?php
//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once dirname(__DIR__) . '/../model/test_scheduleRepo.php';


@session_start();

$login_page = $routes['login'];
$ris_all_schedule_page = $routes['ris_all_schedules'];
$error_page_500 = $routes['internal_server_error'];

$user_id = $_SESSION['user_id'];

$everythingOK = FALSE;
$everythingOKCounter = 0;

$delete_schedule_id = $_POST['delete_schedule_id'];

$decision = false;

echo '<br><h1> Received Patient ID = '.$delete_schedule_id.'</h1><br>';

try {
    $decision = deleteTestSchedule( $delete_schedule_id);
    if ($decision) {
        echo '<br><h1> Decision Update = '.$decision.'</h1><br>';
        header("Location: {$ris_all_schedule_page}");
        exit;
    } else {
        $errorMessage = urldecode("Failed to delete the schedule.");
        header("Location: {$ris_all_schedule_page}?message=$errorMessage");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['backend_error'] = $e->getMessage();
    header("Location: {$error_page_500}");
    exit;
}
