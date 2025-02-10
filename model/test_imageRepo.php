<?php

require_once __DIR__ . '/../model/db_connect.php';

require __DIR__ . '/../routes.php';
global $routes;

$database_error_page = $routes["database_error"];


function findAllTestImages()
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `test_image`';

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImages()";
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
//            throw new Exception("No rows found in the 'test_image' table.");
//            $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImages()";
//            $_SESSION['database_error'] = "No rows found in the 'test_image' table.";
//            global $routes;
//            $database_error_page = $routes["database_error"];
//            header("Location: {$database_error_page}");
            return null;
        }

        return $rows;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImages()";
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


function findTestImageByID($id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `test_image` WHERE `id` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findTestImageByID($id)";
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
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findTestImageByID($id)";
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
        $_SESSION['error_location'] = "Database -> test_imageRepo -> findTestImageByID($id)";
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

function findAllTestImagesByPatientID($patient_id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `test_image` WHERE `patient_id` = '.$patient_id;

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImagesByPatientID()";
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
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImagesByPatientID()";
            $_SESSION['database_error'] = "No rows found in the 'test_image' table for that his_patient_id.";
            global $routes;
            $database_error_page = $routes["database_error"];
//            header("Location: {$database_error_page}");
            return [];
        }

        return $rows;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImagesByPatientID()";
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

function findAllTestImagesByReportID($report_id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `test_image` WHERE `report_id` = '.$report_id;

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImagesByReportID()";
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
//            throw new Exception("No rows found in the 'test_image' table for that id.");
            $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImagesByReportID()";
            $_SESSION['database_error'] = "No rows found in the 'test_image' table for that report_id that is connected with the images.";
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        return $rows;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> test_imageRepo -> findAllTestImagesByReportID()";
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


function updateTestImage($image, $image_type, $upload_date, $id)
{
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "UPDATE `test_image` SET 
                    image =?,
                    image_type =?,
                    upload_date =?
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> test_imageRepo -> updateTestImage()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind parameters
        $stmt->bind_param('sssi', $image, $image_type, $upload_date, $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> test_imageRepo -> updateTestImage()";
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


function deleteTestImage($id) {
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "DELETE FROM `test_image`
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> test_imageRepo -> deleteTestImage()";
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
        $_SESSION['error_location'] = "Database -> test_imageRepo -> deleteTestImage()";
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


function createTestImage($image, $image_type, $upload_date, $patient_id, $report_id, $uploader_id) {
    $conn = db_conn();

    // Construct the SQL query
    $insertQuery = "INSERT INTO `test_image` (image, image_type, upload_date, patient_id, report_id, uploader_id) VALUES (?, ?, ?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);

        // Bind parameters
        $stmt->bind_param('sssiii', $image, $image_type, $upload_date, $patient_id, $report_id, $uploader_id);

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
        $_SESSION['error_location'] = "Database ->  test_imageRepo -> createTestImage()";
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
