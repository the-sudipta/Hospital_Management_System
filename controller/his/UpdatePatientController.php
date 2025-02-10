<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once __DIR__ . '/../../model/patientRepo.php';


@session_start();


$create_patient_page = $routes['his_create_patient'];
$all_patients_page = $routes['his_all_patients'];
$errorMessage = "";

//echo $_SERVER['REQUEST_METHOD'];
$everythingOKCounter = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "Got Req";

    $update_id = $_POST['update_patient_id'];

    //* Name Validation
    $name = $_POST['name'];
    if (empty($name) || strlen($name) > 100) {

        $everythingOK = FALSE;
        $everythingOKCounter += 1;

        echo '<br>Name Error : Name is Empty<br>';
        $errorMessage = urldecode("Name has more than 100 Characters or It is empty");
    } else {
        $everythingOK = TRUE;
    }

    //* Date of Birth Validation
    $date_of_birth = $_POST['date_of_birth'];
    $current_date = date("Y-m-d"); // Get today's date

    if (empty($date_of_birth)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Date of Birth Error: Date of Birth is empty<br>';
        $errorMessage = urldecode("Date of Birth is empty");
    } elseif ($date_of_birth > $current_date) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Date of Birth Error: Future dates are not allowed.<br>';
        $errorMessage = urldecode("Future dates are not allowed");
    } else {
        $everythingOK = TRUE;
    }

    //* Gender Validation
    $gender = $_POST['gender'];

    if (empty($gender)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Gender Error: Gender is empty<br>';
        $errorMessage = urldecode("Gender is empty");
    } elseif (!in_array($gender, ["Male", "Female", "Other"])) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Gender Error: Invalid gender selection<br>';
        $errorMessage = urldecode("Invalid gender selection");
    } else {
        $everythingOK = TRUE;
    }

    //* Contact Validation
    $contact = $_POST['contact'];

    if (empty($contact)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Contact Error: Contact is empty<br>';
        $errorMessage = urldecode("Contact is empty");
    } elseif (!preg_match("/^\+?[0-9]{8,15}$/", $contact)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Contact Error: Invalid contact number format or there should be 8 to 15 digits only<br>';
        $errorMessage = urldecode("Invalid contact number format or there should be 8 to 15 digits only");
    } else {
        $everythingOK = TRUE;
    }

    // Address Validation
    $address = $_POST['address'];

    if (empty($address)) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Address Error: Address is empty<br>';
        $errorMessage = urldecode("Address is empty");
    } elseif (strlen($address) > 150) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Address Error: Address has more than 150 characters<br>';
        $errorMessage = urldecode("Address has more than 150 characters");
    } else {
        $everythingOK = TRUE;
    }






    if ($everythingOK && $everythingOKCounter === 0) {


        $decision = updatePatient($name, $date_of_birth, $gender, $contact, $address, $update_id);
//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($patient_id) . ' <br>';
        if ($decision) {

            header("Location: {$all_patients_page}");
            exit;

        } else {
            echo '<br>Returning to Create Patient page because Patient data could not be stored in the database<br>';
            $errorMessage = urldecode("Cannot store Patient data");
            header("Location: {$create_patient_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Create Patient page because The data user provided is not properly validated. <br>';
        header("Location: {$create_patient_page}?message=$errorMessage");
        exit;
    }


} else{

}


