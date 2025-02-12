<?php

require_once __DIR__ . '/../../model/CalculationRepo.php';

// Process AJAX request
if (isset($_GET['role'])) {
    echo generateUserEmail($_GET['role']);
}
?>
