<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once dirname(__DIR__) . '/../model/billingRepo.php';


$Login_page = $routes['login'];
$create_bill_page = $routes['his_create_bill'];
$all_bill_page = $routes['his_all_bills'];
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


    //* Bill Amount Validation
    $bill_amount = $_POST['bill_amount'];

    // Convert Number with decimal points to string
    if (empty($bill_amount)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Bill Amount Error: Bill Amount is empty<br>';
        $errorMessage = urldecode("Bill Amount is empty");
    } elseif (!is_numeric($bill_amount)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        // If $bill_amount is not a numerical (integer or decimal) type
        echo '<br>Bill Amount Error: Only Numerical Data Allowed.<br>';
        $errorMessage = urldecode("Only Numerical Data Allowed");
    } else {
        $everythingOK = TRUE;
    }





    $current_date = date("Y-m-d"); // Get today's date



    if ($everythingOK && $everythingOKCounter === 0) {


//        $appointment_id = createBilling($current_date, 'Pending', $appointed_patient_id, $user_id);
        $appointment_id = createBilling($appointed_patient_id, $bill_amount, 'Pending', $current_date);
//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($appointment_id) . ' <br>';
        if ($appointment_id > 0) {

            header("Location: {$all_bill_page}");
            exit;



        } else {
            echo '<br>Returning to Create Appointment page because Appointment data could not be stored in the database<br>';
            $errorMessage = urldecode("Cannot store Appointment data");
            header("Location: {$create_bill_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Create Patient page because The data user provided is not properly validated. <br>';
        header("Location: {$create_bill_page}?message=$errorMessage");
        exit;
    }






}
