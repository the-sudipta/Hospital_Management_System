<?php
//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/userRepo.php';


@session_start();

$login_page = $routes['login'];
$admin_all_users_page = $routes['admin_all_users'];
$error_page_500 = $routes['internal_server_error'];

$user_id = $_SESSION['user_id'];

$everythingOK = FALSE;
$everythingOKCounter = 0;

$re_activate_user_id = $_POST['reactivate_user_id'];

$decision = false;

echo '<br><h1> Received Patient ID = '.$re_activate_user_id.'</h1><br>';

try {
    $decision = updateUserStatus('Active', $re_activate_user_id);
    if ($decision) {
        echo '<br><h1> Decision Update = '.$decision.'</h1><br>';
        header("Location: {$admin_all_users_page}");
        exit;
    } else {
        $errorMessage = urldecode("Failed to delete the patient");
        header("Location: {$admin_all_users_page}?message=$errorMessage");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['backend_error'] = $e->getMessage();
    header("Location: {$error_page_500}");
    exit;
}
