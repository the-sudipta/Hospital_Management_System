<?php

//include_once '../Navigation_Links.php';
global $routes;
require '../routes.php';


require_once __DIR__ . '/../model/UserRepo.php';


@session_start();


$Login_page = $routes['login'];
$Admin_Dashboard_page = $routes['admin_dashboard'];
$HIS_Dashboard_page = $routes['his_dashboard'];
$PACS_Dashboard_page = $routes['pacs_dashboard'];
$RIS_Dashboard_page = $routes['ris_dashboard'];
$errorMessage = "";

//echo $_SERVER['REQUEST_METHOD'];
$everythingOKCounter = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "Got Req";

    //* Email Validation
    $email = $_POST['email'];
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
    } else {
        $everythingOK = TRUE;
    }

    //* Password Validation
    $password = $_POST['password'];
    if (empty($password) || strlen($password) < 8) {
        // check if password size in 8 or more and  check if it is empty

        $everythingOK = FALSE;
        $everythingOKCounter += 1;
        echo '<br>Password Error : Password has less than 8 Characters or It is empty<br>';
        $errorMessage = urldecode("Password has less than 8 Characters or It is empty");
    } else {
        $everythingOK = TRUE;
    }


    if ($everythingOK && $everythingOKCounter === 0) {
        $data = findUserByEmailAndPassword($email, $password);

//        echo '<br><br>';
        echo '<br>Everything is ok<br>';
        echo '<br>ID found = ' . isset($data["id"]) . ' <br>';
        if ($data && isset($data["id"])) {
            $_SESSION["data"] = $data;
            $_SESSION["user_id"] = $data["id"];
            $_SESSION["user_role"] = $data["role"];
            $_SESSION["user_status"] = $data["status"];

            if ($data['role'] === 'admin') {
                header("Location: {$Admin_Dashboard_page}");
                exit;
            } elseif ($data['role'] === 'his'){
                header("Location: {$HIS_Dashboard_page}");
                exit;
            }elseif ($data['role'] === 'pacs'){
                header("Location: {$PACS_Dashboard_page}");
                exit;
            }elseif ($data['role'] === 'ris'){
                header("Location: {$RIS_Dashboard_page}");
                exit;
            } else {
                $errorMessage = urldecode("Role did not match to any valid roles");
                header("Location: {$Login_page}?message=$errorMessage");
                exit;
            }
        } else {
            echo '<br>Returning to Login page because ID Password did not match<br>';
            $errorMessage = urldecode("Email and Password did not match");
            header("Location: {$Login_page}?message=$errorMessage");
            exit;
        }
    } else {
        echo '<br>Returning to Login page because The data user provided is not properly validated like 
                in password: 1-upper_case, 1-lower_case, 1-number, 1-special_character and at least 8 character long it must be provided <br>';
        header("Location: {$Login_page}?message=$errorMessage");
        exit;
    }


}


