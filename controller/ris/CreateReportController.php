<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once dirname(__DIR__) . '/../model/reportRepo.php';


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

    //* Get the Patient ID
    $patient_id_of_the_report = $_POST['patient_id'];


    //* Appointment Date Validation
    $report_text = $_POST['report_text'];
    $current_date = date("Y-m-d"); // Get today's date

    $report_text = isset($_POST['report_text']) && trim($_POST['report_text']) !== "" ? $_POST['report_text'] : "";
    $status = is_null($report_text) || $report_text === "" ? 'Pending' : 'Reviewed';







    if ($everythingOK && $everythingOKCounter === 0) {


        $report_id = createReport($report_text, $status, $current_date, $patient_id_of_the_report, $user_id);
//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($appointment_id) . ' <br>';
        if ($report_id > 0) {

            header("Location: {$all_reports_page}");
            exit;



        } else {
            echo '<br>Returning to Create Report page because Report data could not be stored in the database<br>';
            $errorMessage = urldecode("Cannot store Report data");
            header("Location: {$create_report_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Create Report page because The data user provided is not properly validated. <br>';
        header("Location: {$create_report_page}?message=$errorMessage");
        exit;
    }






}
