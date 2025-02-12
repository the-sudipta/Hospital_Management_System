<?php


require_once __DIR__ . '/../model/db_connect.php';
require_once __DIR__ . '/../model/appointmentRepo.php';
require_once __DIR__ . '/../model/billingRepo.php';
require_once __DIR__ . '/../model/logRepo.php';
require_once __DIR__ . '/../model/messageRepo.php';
require_once __DIR__ . '/../model/patientRepo.php';
require_once __DIR__ . '/../model/reportRepo.php';
require_once __DIR__ . '/../model/test_imageRepo.php';
require_once __DIR__ . '/../model/test_scheduleRepo.php';
require_once __DIR__ . '/../model/userRepo.php';


@session_start();

function getTotalImagesCount()
{
    $all_images = findAllTestImages(); // Fetch all test images
    return is_array($all_images) ? count($all_images) : 0;
}

function getTodayImageCount()
{
    $today_images_count = 0;
    $all_images = findAllTestImages(); // Fetch all test images
    $today_date = date('Y-m-d'); // Get today's date in YYYY-MM-DD format

    foreach ($all_images as $image) {
        if (isset($image['upload_date']) && date('Y-m-d', strtotime($image['upload_date'])) === $today_date) {
            $today_images_count++;
        }
    }

    return $today_images_count;
}

function getPendingReportsCount()
{
    $all_reports = findAllReports(); // Fetch all reports
    $pendingReports = array_filter($all_reports, function ($report) {
        return isset($report['status']) && strtolower($report['status']) === 'pending';
    });

    return count($pendingReports);
}

function getReviewedReportsCount()
{
    $all_reports = findAllReports(); // Fetch all reports
    $reviewedReports = array_filter($all_reports, function ($report) {
        return isset($report['status']) && strtolower($report['status']) === 'reviewed';
    });

    return count($reviewedReports);
}


function getUpcomingTestSchedule($patient_id)
{
    $next_test_schedule_info = null;
    $all_schedules_of_the_patient = findAllTestSchedulesByPatientID($patient_id);

    if (!empty($all_schedules_of_the_patient)) {
        $current_date = date('Y-m-d'); // Get today's date

        foreach ($all_schedules_of_the_patient as $schedule) {
            $test_date = $schedule['date']; // Assuming 'test_date' is the field storing the date

            // Check if the test date is in the future
            if ($test_date >= $current_date) {
                // If it's the first future test date or earlier than the current stored one, update it
                if ($next_test_schedule_info === null || $test_date < $next_test_schedule_info) {
                    $next_test_schedule_info = $schedule;
                }
            }
        }
    }

    return $next_test_schedule_info ?: "No upcoming test scheduled";
}


function getUpcomingAppointment($patient_id)
{
    $next_appointment_date = null;
    $all_appointments_of_the_patient = findAllAppointmentsByPatientID($patient_id);

    if (!empty($all_appointments_of_the_patient)) {
        $current_date = date('Y-m-d'); // Get today's date

        foreach ($all_appointments_of_the_patient as $appointment) {
            $appointment_date = $appointment['appointment_date']; // Assuming 'test_date' is the field storing the date

            // Check if the test date is in the future
            if ($appointment_date >= $current_date && strtolower($appointment['status']) ==='pending') {
                // If it's the first future test date or earlier than the current stored one, update it
                if ($next_appointment_date === null || $appointment_date < $next_appointment_date) {
                    $next_appointment_date = $appointment_date;
                }
            }
        }
    }

    return $next_appointment_date ?: "No upcoming Appointment scheduled";
}


function totalReports()
{
    $all_reports = findAllReports();
    $today = date('Y-m-d');
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $startOfMonth = date('Y-m-01');

    $total_today = 0;
    $total_this_week = 0;
    $total_this_month = 0;
    $pending_counter = 0;

    foreach ($all_reports as $report) {
        $reportDate = $report['created_at']; // Assuming the date is stored as 'YYYY-MM-DD'

        if ($reportDate === $today) {
            $total_today++;
        }
        if ($reportDate >= $startOfWeek) {
            $total_this_week++;
        }
        if ($reportDate >= $startOfMonth) {
            $total_this_month++;
        }

        if(strtolower($report['status']) === 'pending') {
            $pending_counter++;
        }

    }

    return [
        'total_report_count_today' => $total_today,
        'total_report_count_this_week' => $total_this_week,
        'total_report_count_this_month' => $total_this_month,
        'total_pending' => $pending_counter,
    ];
}

function getScheduleCount()
{
    $today = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format

    $total_today = 0;
    $total_future = 0;
    $total_past = 0;

    $all_schedule = findAllTestSchedules();

    foreach ($all_schedule as $schedule) {
        if ($schedule['date'] === $today) {
            $total_today++;
        } elseif ($schedule['date'] > $today) {
            $total_future++;
        } else {
            $total_past++;
        }
    }

    return [
        'total_report_count_today' => $total_today,
        'total_report_count_future' => $total_future,
        'total_report_count_past' => $total_past,
    ];
}


function generateUserEmail($role)
{
    $all_users = findAllUsers(); // Retrieve all users from the database
    $existing_emails = array_column($all_users, 'email'); // Extract all emails

    $pattern = "/^" . preg_quote($role, '/') . "(\d+)@hospital\.com$/"; // Regex to match role-based emails
    $max_serial = 0;

    foreach ($existing_emails as $email) {
        if (preg_match($pattern, $email, $matches)) {
            $serial_no = (int)$matches[1]; // Extract serial number
            if ($serial_no > $max_serial) {
                $max_serial = $serial_no;
            }
        }
    }

    // Generate next email
    $next_serial = $max_serial + 1;
    return "{$role}{$next_serial}@hospital.com";
}


function generateUserPassword()
{
    $length = rand(10, 15); // Random length between 10 and 15

    $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialChars = '!@#$%^&*()-_=+{}[]<>?/';

    // Ensure at least one character from each required set
    $password = $upperCase[rand(0, strlen($upperCase) - 1)] .
        $lowerCase[rand(0, strlen($lowerCase) - 1)] .
        $numbers[rand(0, strlen($numbers) - 1)] .
        $specialChars[rand(0, strlen($specialChars) - 1)];

    // Fill the remaining characters randomly
    $allChars = $upperCase . $lowerCase . $numbers . $specialChars;
    for ($i = 4; $i < $length; $i++) {
        $password .= $allChars[rand(0, strlen($allChars) - 1)];
    }

    // Shuffle to mix up the characters
    return str_shuffle($password);
}

function validatePassword($password) : string
{

    $error_message = '';
    if (empty($password)) {

        $error_message = 'Password cannot be empty';
    } elseif (strlen($password) < 8) {

        $error_message = 'Password must be at least 8 characters long';
    } elseif (!preg_match('/[A-Z]/', $password)) {

        $error_message = 'Password must contain at least one uppercase letter';
    } elseif (!preg_match('/[a-z]/', $password)) {

        $error_message = 'Password must contain at least one lowercase letter';
    } elseif (!preg_match('/[0-9]/', $password)) {

        $error_message = 'Password must contain at least one number';
    } elseif (!preg_match('/[!@#$%^&*()\-_=+{}\[\]<>?\/]/', $password)) {

        $error_message = 'Password Error: Password must contain at least one special character';
    }

    return $error_message;

}

function createNewLog($logText)
{
    $currentDateTime = date('Y-m-d H:i:s');
    $user_id = $_SESSION["user_id"];
    createLog($logText, $currentDateTime, $user_id);
}
