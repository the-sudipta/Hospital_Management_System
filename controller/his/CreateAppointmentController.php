<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once dirname(__DIR__) . '/../model/appointmentRepo.php';


$Login_page = $routes['login'];
$create_appointment_page = $routes['his_create_appointment'];
$all_appointment_page = $routes['his_all_appointments'];
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
    $appointed_patient_id = $_POST['patient_id'];


    //* Appointment Date Validation
    $appointment_date = $_POST['appointment_date'];
    $current_date = date("Y-m-d"); // Get today's date

    if (empty($appointment_date)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Appointment Date Error: Appointment Date is empty<br>';
        $errorMessage = urldecode("Appointment Date is empty");
    } elseif ($appointment_date < $current_date) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Appointment Date Error: Past dates are not allowed.<br>';
        $errorMessage = urldecode("Past dates are not allowed");
    } else {
        $everythingOK = TRUE;
    }






    if ($everythingOK && $everythingOKCounter === 0) {


        $appointment_id = createAppointment($appointment_date, 'Pending', $appointed_patient_id, $user_id);
//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($appointment_id) . ' <br>';
        if ($appointment_id > 0) {

            header("Location: {$all_appointment_page}");
            exit;



        } else {
            echo '<br>Returning to Create Appointment page because Appointment data could not be stored in the database<br>';
            $errorMessage = urldecode("Cannot store Appointment data");
            header("Location: {$create_appointment_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Create Patient page because The data user provided is not properly validated. <br>';
        header("Location: {$create_appointment_page}?message=$errorMessage");
        exit;
    }






}
