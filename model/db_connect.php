<?php

require __DIR__ . '/../routes.php';

global $routes;

$database_error_page = $routes["database_error"];

function db_conn()
{
    $servername = "localhost";
    $username = "u899200555_hospital_manag";
    $password = "Hospital_Manag#1";
    $dbname = "u899200555_hospital_manag";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {

        $_SESSION['error_location'] = "db_connect";
        $_SESSION['database_error'] = $conn->connect_error;
        global $routes;
        $database_error_page = $routes["database_error"];
        header("Location: {$database_error_page}");

//        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
