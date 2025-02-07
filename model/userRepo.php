<?php

require_once __DIR__ . '/../model/db_connect.php';

require __DIR__ . '/../routes.php';
global $routes;

$database_error_page = $routes["database_error"];


function findAllUsers()
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `user`';

    try {
        $result = $conn->query($selectQuery);

        // Check if the query was successful
        if (!$result) {
//            throw new Exception("Query failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> findAllUsers()";
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
            $_SESSION['error_location'] = "Database -> userRepo -> findAllUsers()";
            $_SESSION['database_error'] = "No rows found in the 'user' table.";
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


function findUserByEmailAndPassword($email, $password) {
    $conn = db_conn();

    // Use prepared statement to prevent SQL injection
    $selectQuery = 'SELECT * FROM `user` WHERE `email` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Bind parameters
        $stmt->bind_param("s", $email);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user as an associative array
        $user = $result->fetch_assoc();

        // Close the result set
        $result->close();

        // Close the statement
        $stmt->close();

        // Check if the user exists and if the password matches
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct
            return $user;
        } else {
            // Password is incorrect or user doesn't exist
            return null;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}


function findUserByUserID($id)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `user` WHERE `id` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> findUserByUserID()";
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
            $_SESSION['error_location'] = "Database -> userRepo -> findUserByID()";
            $_SESSION['database_error'] = "No user found with ID: " . $id;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Close the statement
        $stmt->close();

        return $user;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> userRepo -> findUserByID()";
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

function findUserByEmail($email)
{
    $conn = db_conn();
    $selectQuery = 'SELECT * FROM `user` WHERE `email` = ?';

    try {
        $stmt = $conn->prepare($selectQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> findUserByEmail()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind the parameter
        $stmt->bind_param("s", $email);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user as an associative array
        $user = $result->fetch_assoc();

        // Check for an empty result set
        if (!$user) {
            return null;
        }

        // Close the statement
        $stmt->close();

        return $user;
    } catch (Exception $e) {
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> userRepo -> findUserByEmail()";
        $_SESSION['database_error'] = $e->getMessage();
        global $routes;
        $database_error_page = $routes["database_error"];
        return null;
    } finally {
        // Close the database connection
        $conn->close();
    }
}


function updateUser($email, $password, $role, $status, $id)
{
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "UPDATE `user` SET 
                    email = ?,
                    password = ?,
                    role = ?,
                    status =?
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> updateUser()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind parameters
        $stmt->bind_param('ssssi', $email, $password, $role, $status, $id);

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

function updateUserStatus($status, $id)
{
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "UPDATE `user` SET 
                    status =?
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> updateUserStatus()";
            $_SESSION['database_error'] = "Prepare statement failed: " . $conn->error;
            global $routes;
            $database_error_page = $routes["database_error"];
            header("Location: {$database_error_page}");
        }

        // Bind parameters
        $stmt->bind_param('si', $status, $id);

        // Execute the query
        $stmt->execute();

        // Return true if the update is successful
        return true;
    } catch (Exception $e) {
        // Handle the exception, you might want to log it or return false
//        echo "Error: " . $e->getMessage();
        $_SESSION['error_location'] = "Database -> userRepo -> updateUserStatus()";
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


function deleteUser($id) {
    $conn = db_conn();

    // Construct the SQL query
    $updateQuery = "DELETE FROM `user`
                    WHERE id = ?";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($updateQuery);

        // Check if the prepare statement was successful
        if (!$stmt) {
//            throw new Exception("Prepare statement failed: " . $conn->error);
            $_SESSION['error_location'] = "Database -> userRepo -> deleteUser()";
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
        $_SESSION['error_location'] = "Database -> userRepo -> deleteUser()";
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


function createUser($email, $password, $role, $created_at, $status) {
    $conn = db_conn();

    // Hash the password using a secure hashing algorithm (e.g., password_hash)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Construct the SQL query
    $insertQuery = "INSERT INTO `user` (email, password, role, created_at, status) VALUES (?, ?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($insertQuery);

        // Bind parameters
        $stmt->bind_param('sssss', $email, $hashedPassword, $role, $created_at, $status);

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
        $_SESSION['error_location'] = "Database -> userRepo -> createUser()";
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
