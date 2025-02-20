<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../../routes.php';


require_once dirname(__DIR__) . '/model/CalculationRepo.php';
require_once dirname(__DIR__) . '/model/userRepo.php';



@session_start();


$Admin_create_user_page = $routes['admin_create_user'];
$Admin_all_users_page = $routes['admin_all_users'];

$errorMessage = "";

//echo $_SERVER['REQUEST_METHOD'];
$everythingOKCounter = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "Got Req";

    //* Email Validation
    $email = $_POST['create_email'];
    $previous_user = NULL;
    $previous_user = findUserByEmail($email);
    if (empty($email)) {

        $everythingOK = FALSE;
        $everythingOKCounter += 1;

        echo '<br>Email Error : Email is Empty<br>';
        $errorMessage = urldecode("Email has more than 120 Characters or It is empty");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Email Error : Email does not have `@`<br>';
        $errorMessage = urldecode("Email does not have `@`");
    } elseif ($previous_user != NULL) {
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Email Error : Email already exists<br>';
        $errorMessage = urldecode("Email already exists");
    }else {
        $everythingOK = TRUE;
    }

    //* Password Validation
    $password = $_POST['create_password'];
    if (validatePassword($password) !== '') {
        $error_message  = validatePassword($password);
        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Password Error : '.$error_message.'<br>';
        $errorMessage = urldecode($error_message);
    }else {
        $everythingOK = TRUE;
    }

    //* Get Role
    $role = $_POST['create_role'];

    //* Current DateTime
    $dateTime = date('Y-m-d H:i:s');


    if ($everythingOK && $everythingOKCounter === 0) {
        $data = createUser($email, $password, $role, $dateTime, 'Active');

//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($data["id"]) . ' <br>';
        if ($data >0) {
            header("Location: {$Admin_all_users_page}");
        } else {
            echo '<br>Returning to Create User page because user could not be created<br>';
            $errorMessage = urldecode("User could not be created");
            header("Location: {$Admin_create_user_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Login page because The data user provided is not properly validated.<br>';
        header("Location: {$Admin_create_user_page}?message=$errorMessage");
        exit;
    }


}


