<?php

require_once __DIR__ . '/../model/UserRepo.php';
require_once __DIR__ . '/../model/TokenRepo.php';
require_once __DIR__ . '/../model/TripRepo.php';
require_once __DIR__ . '/../model/DriverRepo.php';
require_once __DIR__ . '/../model/NotificationRepo.php';
require_once __DIR__ . '/../model/CalculationRepo.php';

@session_start();


function getDriverName($user_id){
    $driver_details = findDriverByUserID($user_id);
    return $driver_details['name'];
}

function isAnyTokenActive($user_id)
{
    $all_tokens = findAllTokensByUser_id($user_id);

    foreach ($all_tokens as $token) {
        if (strtolower($token['status']) === "active") {
            return true; // An active token exists
        }
    }

    return false; // No active tokens found
}

function getCurrentActiveToken($user_id)
{
    $all_tokens = findAllTokensByUser_id($user_id);
    $token_row = null;
    foreach ($all_tokens as $token) {
        if (strtolower($token['status']) === "active") {
            $token_row = $token;
        }
    }

    return $token_row;
}

//function getTripDetails($token_id)
//{
//    $trip_row= null;
//    $trip_row = findTripByTokenID($token_id);
//    return $trip_row;
//}

function getNextTrip($token_id)
{
    $user_id = $_SESSION['user_id'];
    $trip_row = null;
    $trip_row = findTripByTokenID($token_id);
    if ($trip_row != null && $trip_row['user_id'] === $user_id) {
        return $trip_row;
    }
    return null;
}

function getMyTrips($user_id)
{
    return findAllTripsByUserID($user_id);
}

function getTripContainerBgColor($trip)
{
    // Default background color (white)
    $tripContainerBg = "#ffffff";

    // Check if trips exist
    if (!empty($trip)) {
        // Get the first trip's status
        $trip_status = strtolower($trip['status'] ?? 'unknown');

        // Assign background color based on status
        switch ($trip_status) {
            case 'ongoing':
                $tripContainerBg = "#dbffde"; // Green for Ongoing
                break;
            case 'pending':
                $tripContainerBg = "#fff2db"; // Orange for Pending
                break;
            case 'completed':
                $tripContainerBg = "#dbf4ff"; // Blue for Completed
                break;
        }
    }

    return $tripContainerBg;
}