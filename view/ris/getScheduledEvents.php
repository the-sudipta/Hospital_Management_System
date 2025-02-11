<?php
require_once __DIR__ . '/../../model/test_scheduleRepo.php';

// Fetch all schedules from the database
$all_schedules = findAllTestSchedules();

// Initialize an empty array to store formatted schedules
$scheduledEvents = [];

// Loop through the fetched schedules
foreach ($all_schedules as $schedule) {
    $date = $schedule['date'];  // Extract the date
    $testName = $schedule['exam_type']; // Extract the test name
    $time = "10:00 AM"; // Set default time to 10:00 AM

    // Format the event as "Test Name - Time"
    $event = "{$testName} - {$time}";

    // Add to the array, grouping events by date
    $scheduledEvents[$date][] = $event;
}

// ✅ Output JSON response
header('Content-Type: application/json');
echo json_encode($scheduledEvents);
exit;
?>
