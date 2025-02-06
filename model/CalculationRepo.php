<?php


require_once __DIR__ . '/../model/db_connect.php';
require_once __DIR__ . '/../model/TripRepo.php';


@session_start();


function generateToken($pickup_location, $destination){
    // Generate a token combining the "pickup_location-destination-6 Random Numbers"
    // It is not necessary to use the full locations. An example token like : RAM-UTT-123456
    $pickup_code = strtoupper(substr($pickup_location, 0, 3));
    $destination_code = strtoupper(substr($destination, 0, 3));
    $random_number = rand(100000, 999999);
    $token = $pickup_code . '-' . $destination_code . '-' . $random_number;
    return $token;
}


function getNextToken($user_id)
{
    $next_token = null;
    $all_tokens = findAllTokensByUser_id($user_id);
    $earliest_assigned_time = PHP_INT_MAX;

    foreach ($all_tokens as $token_row) {
        $assigned_time = strtotime($token_row['assigned_at']);
        $status = strtolower($token_row['status']);

        // Only consider "pending" tokens
        if ($status === "pending") {
            // Find the token with the earliest assigned time
            if ($assigned_time < $earliest_assigned_time) {
                $earliest_assigned_time = $assigned_time;
                $next_token = $token_row;
                $_SESSION["active_token_id"] = $token_row['id'];
                // After Requesting a token, the status of that token needs to be changed to 'Active'
            }
        }
    }

    return $next_token;
}


function getPreviousToken($user_id)
{
    $previous_token_row = null;
    $all_tokens = findAllTokensByUser_id($user_id);
    $latest_assigned_time = 0; // Store the latest expired token timestamp

    foreach ($all_tokens as $token_row) {
        $assigned_time = strtotime($token_row['assigned_at']);
        $status = strtolower($token_row['status']);

        // Only consider "expired" tokens
        if ($status === "expired") {
            // Find the token with the latest assigned time
            if ($assigned_time > $latest_assigned_time) {
                $latest_assigned_time = $assigned_time;
                $previous_token_row = $token_row;
            }
        }
    }

    return $previous_token_row;
}


function getMyTodaysTripCount($user_id) : int
{
    $trip_count = 0;
    $all_my_trips = findAllTripsByUserID($user_id);

    // Get today's date (formatted as YYYY-MM-DD)
    $today = date('Y-m-d');

    foreach ($all_my_trips as $trip) {
        // Extract end_time date (YYYY-MM-DD format)
        $end_time_date = isset($trip['end_time']) ? date('Y-m-d', strtotime($trip['end_time'])) : null;
        $status = strtolower($trip['status'] ?? '');

        // Check if trip ended today and is marked as completed
        if ($end_time_date === $today && $status === 'completed') {
            $trip_count++;
        }
    }

    return $trip_count;
}


function getMyTodaysEarning($user_id)
{
    return getMyTodaysTripCount($user_id) * 800;
}


function getMyTodaysTripMap($user_id)
{
    $all_my_trips = findAllTripsByUserID($user_id);

    // Get today's date (YYYY-MM-DD format)
    $today = date('Y-m-d');

    // Initialize an array to store formatted trip data
    $tripMapData = [];
    $tripSerial = 1; // Start trip serial from 1

    foreach ($all_my_trips as $trip) {
        // Extract the date part from end_time
        $tripDate = isset($trip['end_time']) ? date('Y-m-d', strtotime($trip['end_time'])) : null;
        $tripStatus = strtolower($trip['status'] ?? ''); // Convert status to lowercase

        // Process only completed trips from today
        if ($tripDate === $today && $tripStatus === 'completed') {
            $pickup_coords = getCoordinatesFromAddress($trip['pickup_location']);
            $destination_coords = getCoordinatesFromAddress($trip['destination']);

            // Ensure we got valid coordinates
            if ($pickup_coords && $destination_coords) {
                $tripMapData[] = [
                    "serial"          => $tripSerial++, // Assign Serial Number
                    "trip_id"         => $trip['id'],
                    "pickup_location" => $pickup_coords, // Converted to lat,lng
                    "destination"     => $destination_coords, // Converted to lat,lng
                    "pickup_name"     => $trip['pickup_location'], // Location name for popup
                    "destination_name"=> $trip['destination'], // Location name for popup
                    "start_time"      => $trip['start_time'] ?? "-",
                    "assigned_at"     => $trip['assigned_at'] ?? "-",
                    "end_time"        => $trip['end_time'] ?? "-",
                    "status"          => ucfirst($tripStatus) // Capitalized status
                ];
            }
        }
    }

    return $tripMapData; // Return data with coordinates
}

/**
 * Convert a textual address into latitude and longitude using OpenStreetMap Nominatim API.
 */
function getCoordinatesFromAddress($address)
{
    $encodedAddress = urlencode($address);
    $url = "https://nominatim.openstreetmap.org/search?format=json&q=$encodedAddress";

    $context = stream_context_create(["http" => ["header" => "User-Agent: MyEventManagementApp/1.0"]]);
    $response = file_get_contents($url, false, $context);

    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
            return [$data[0]['lat'], $data[0]['lon']]; // Returns [latitude, longitude]
        }
    }

    return null; // Return null if no valid response
}

