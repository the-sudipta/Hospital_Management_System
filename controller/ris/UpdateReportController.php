<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/reportRepo.php';


$Login_page = $routes['login'];
$create_report_page = $routes['ris_create_report'];
$all_reports_page = $routes['ris_all_reports'];
$errorMessage = "";
$everythingOK = true;


@session_start();
if($_SESSION["user_id"] <= 0){
    echo '<h1>'.$_SESSION["user_id"] .'</h1>';
    header("Location: {$Login_page}");
}

$user_id = $_SESSION["user_id"] ;

//echo $_SERVER['REQUEST_METHOD'];
$everythingOKCounter = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "Got Req";

    //* Get the Report ID
    $report_id = $_POST['update_report_id'];


    //* Appointment Date Validation
    $report_text = $_POST['report_text'];
    $current_date = date("Y-m-d"); // Get today's date

    $report_text = isset($_POST['report_text']) && trim($_POST['report_text']) !== "" ? $_POST['report_text'] : "";
    $status = is_null($report_text) || $report_text === "" ? 'Pending' : 'Reviewed';







    if ($everythingOK && $everythingOKCounter === 0) {


        $decision = updateReportTextAndStatus($report_text, 'Reviewed', $report_id);
//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($appointment_id) . ' <br>';
        if ($decision) {

            header("Location: {$all_reports_page}");
            exit;



        } else {
            echo '<br>Returning to Create Report page because Report data could not be updated in the database<br>';
            $errorMessage = urldecode("Cannot update Report data");
            header("Location: {$create_report_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Create Report page because The data user provided is not properly validated. <br>';
        header("Location: {$create_report_page}?message=$errorMessage");
        exit;
    }






}