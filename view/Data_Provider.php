<?php

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

function getAllPatientsInfo()
{
    $allPatientsInfo = findAllPatients();
    return $allPatientsInfo ?: null; // Return null if no data is found
}

function getAllReportsInfo()
{
    $allReportsInfo = findAllReports();
    return $allReportsInfo ?: null; // Return null if no data is found
}

function getPatientNameByID($id)
{
    $patientInfo = findPatientById($id);

    if ($patientInfo && isset($patientInfo['name'])) {
        return $patientInfo['name'];
    }

    return null; // Return null if no data is found
}

function getImagesByImageType($imageType)
{
    $selected_images = [];
    $allImages = findAllTestImages(); // Fetch all test images

    if ($allImages) {
        foreach ($allImages as $image) {
            if (isset($image['image_type']) && $image['image_type'] === $imageType) {
                $selected_images[] = $image;
            }
        }
    }

    return !empty($selected_images) ? $selected_images : []; // Return null if no images are found
}


function getReportTextByReportID($reportID)
{
    $reportInfo = findReportById($reportID);
    if ($reportInfo && isset($reportInfo['report_text'])) {
        return $reportInfo['report_text'];
    }

    return null;
}
