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

