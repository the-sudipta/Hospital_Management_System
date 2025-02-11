<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/test_scheduleRepo.php';


$Login_page = $routes['login'];
$single_schedule_page = $routes['ris_single_schedule'];
$all_schedule_page = $routes['ris_all_schedules'];
$errorMessage = "";


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
    $update_schedule_id = $_POST['update_schedule_id'];


    //* Exam Type Validation
    $exam_type = $_POST['exam_type'];

    if (empty($exam_type)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Exam Type Error: Exam Date is empty<br>';
        $errorMessage = urldecode("Exam date is empty");
    } elseif (strlen($exam_type) > 50) { // Check if the length exceeds 50 characters
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Exam Type Error: Exam date is more than 50 characters long<br>';
        $errorMessage = urldecode("Exam date is more than 50 characters long");
    } else {
        $everythingOK = TRUE;
    }



    //* Appointment Date Validation
    $schedule_date = $_POST['schedule_date'];
    $current_date = date("Y-m-d"); // Get today's date

    if (empty($schedule_date)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Schedule Date Error: Schedule Date is empty<br>';
        $errorMessage = urldecode("Schedule Date is empty");
    } elseif ($schedule_date < $current_date) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Schedule Date Error: Past dates are not allowed.<br>';
        $errorMessage = urldecode("Past dates are not allowed");
    } else {
        $everythingOK = TRUE;
    }






    if ($everythingOK && $everythingOKCounter === 0) {


        $decision = updateTestSchedule($exam_type, $schedule_date, $update_schedule_id);
//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($appointment_id) . ' <br>';
        if ($decision) {

            header("Location: {$all_schedule_page}");
            exit;



        } else {
            echo '<br>Returning to Single Schedule page because Schedule data could not be updated in the database<br>';
            $errorMessage = urldecode("Cannot update Schedule data");
            header("Location: {$single_schedule_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Single Schedule page because The data user provided is not properly validated. <br>';
        header("Location: {$single_schedule_page}?message=$errorMessage");
        exit;
    }






}