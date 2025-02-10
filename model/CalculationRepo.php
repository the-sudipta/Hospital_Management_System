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
