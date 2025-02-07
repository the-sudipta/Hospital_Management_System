<?php

require_once __DIR__ . '/../model/db_connect.php';

global $routes;
require '../routes.php';

$database_error_page = $routes["database_error"];


function findAllPatients()
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `his_patient`';

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> his_patientRepo -> findAllPatients()";
            $_SESSION['database_error'] = "Query failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        $rows = array();

        // Fetch rows one by one
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Check for an empty result set
        if (empty($rows)) {
//            throw new Exception("No rows found in the 'user' table.");
            $_SESSION['error_location'] = "Database -> userRepo -> findAllPatients()";
            $_SESSION['database_error'] = "No rows found in the 'his_patient' table.";
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        return $rows;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}


function findPatientByID($id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `his_patient` WHERE `id` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> findPatientByID()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind the parameter
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user as an associative array
        $user = $result->fetch_assoc();

        // Check for an empty result set
        if (!$user) {
//            throw new Exception("No user found with ID: " . $id);
            $_SESSION['error_location'] = "Database -> his_patientRepo -> findPatientByID()";
            $_SESSION['database_error'] = "No patient info found with ID: " . $id;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Close the statement
        $stmt->close();

        return $user;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> userRepo -> findPatientByID()";
        $_SESSION['database_error'] = $e->getMessage();
        global $routes;
        $database_error_page = $routes["database_error"];
        header("Location: {$database_error_page}");
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}



function updatePatient($name, $dob, $gender, $contact, $address, $id)
{
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "UPDATE `his_patient` SET 
                    name = ?,
                    dob = ?,
                    gender = ?,
                    contact =?,
                    address =?
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> his_PatientRepo -> updatePatient()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind parameters
        $stmt->bind_param('sssssi', $name, $dob, $gender, $contact, $address, $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> userRepo -> updateUser()";
        $_SESSION['database_error'] = $e->getMessage();
        global $routes;
        $database_error_page = $routes["database_error"];
        header("Location: {$database_error_page}");
        return false;
    } finally {
        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();
    }
}


function deletePatient($id) {
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "DELETE FROM `his_patient`
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> his_patientRepo -> deletePatient()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind parameter
        $stmt->bind_param('i', $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> his_patientRepo -> deletePatient()";
        $_SESSION['database_error'] = $e->getMessage();
        global $routes;
        $database_error_page = $routes["database_error"];
        header("Location: {$database_error_page}");
        return false;
    } finally {
        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();
    }
}


function createPatient($name, $dob, $gender, $contact, $address) {
    $conn = db_conn();

    // Construct the SQL query
    $insertQuery = "INSERT INTO `his_patient` (name, dob, gender, contact, address) VALUES (?, ?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);

        // Bind parameters
        $stmt->bind_param('sssss', $name, $dob, $gender, $contact, $address);

        // Execute the query
        $stmt->execute();

        // Return the ID of the newly inserted user
        $newUserId = $stmt->insert_id;

        // Close the statement
        $stmt->close();

        return $newUserId;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> his_patientRepo -> createPatient()";
        $_SESSION['database_error'] = $e->getMessage();
        global $routes;
        $database_error_page = $routes["database_error"];
        header("Location: {$database_error_page}");
        return -1;
    } finally {
        // Close the database connection
        $conn->close();
    }
}
