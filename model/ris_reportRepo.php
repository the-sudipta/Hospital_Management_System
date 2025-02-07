<?php

require_once __DIR__ . '/../model/db_connect.php';

global $routes;
require '../routes.php';

$database_error_page = $routes["database_error"];


function findAllRis_reports()
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `ris_report`';

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> findAllRis_reports()";
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
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> findAllRis_reports()";
            $_SESSION['database_error'] = "No rows found in the 'ris_report' table.";
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


function findRis_reportByID($id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `ris_report` WHERE `id` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> findRis_reportByID($id)";
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
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> findRis_reportByID($id)";
            $_SESSION['database_error'] = "No data found with ID: " . $id;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Close the statement
        $stmt->close();

        return $user;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> ris_reportRepo -> findRis_reportByID($id)";
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

function findAllRis_reportsByRis_ScheduleID($ris_schedule_id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `ris_report` WHERE `ris_schedule_id` = '.$ris_schedule_id;

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> findAllRis_reportsByRis_ScheduleID()";
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
//            throw new Exception("No rows found in the 'appointment' table for that his_patient_id.");
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> findAllRis_reportByPatientID()";
            $_SESSION['database_error'] = "No rows found in the 'ris_report' table for that ris_schedule_id.";
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        return $rows;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> ris_reportRepo -> findAllRis_reportByPatientID()";
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


function updateRis_reportText($report_text, $id)
{
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "UPDATE `ris_report` SET 
                    report_text =?
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> updateRis_report()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind parameters
        $stmt->bind_param('si', $report_text, $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> ris_reportRepo -> updateRis_report()";
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


function deleteRis_report($id) {
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "DELETE FROM `ris_report`
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> ris_reportRepo -> deleteRis_report()";
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
        $_SESSION['error_location'] = "Database -> ris_reportRepo -> deleteRis_report()";
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


function createRis_report($ris_schedule_id, $report_text, $status, $created_at) {
    $conn = db_conn();

    // Construct the SQL query
    $insertQuery = "INSERT INTO `ris_report` (ris_schedule_id, report_text, status, created_at) VALUES (?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);

        // Bind parameters
        $stmt->bind_param('isss', $ris_schedule_id, $report_text, $status, $created_at);

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
        $_SESSION['error_location'] = "Database ->  ris_reportRepo -> createRis_report()";
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
