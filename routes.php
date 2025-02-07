<?php

// Frontend routes
$routes = [
    'INDEX' => '/Hospital_Management_System/index.php',
    'login' => '/Hospital_Management_System/view/Login.php',
    'loader' => '/Hospital_Management_System/view/Loader.php',
    'database_error' => '/Hospital_Management_System/view/error/database_error.php',
    'not_found_error' => '/Hospital_Management_System/view/error/400_not_found_error.php',

//    Dashboards

    'admin_dashboard' => '/Hospital_Management_System/view/admin/Admin_Dashboard.php',
    'his_dashboard' => '/Hospital_Management_System/view/his/HIS_Dashboard.php',
    'pacs_dashboard' => '/Hospital_Management_System/view/pacs/PACS_Dashboard.php',
    'ris_dashboard' => '/Hospital_Management_System/view/ris/RIS_Dashboard.php',

//    Storage Locations

    'ct_scan_storage' => '/Hospital_Management_System/view/storage/ct',
    'mri_scan_storage' => '/Hospital_Management_System/view/storage/mri',
    'x_ray_scan_storage' => '/Hospital_Management_System/view/storage/x_ray',



];

// Backend routes
$backend_routes = [
    'login_controller' => '/Hospital_Management_System/controller/LoginController.php',
    'logout_controller' => '/Hospital_Management_System/controller/LogoutController.php',

];


// Image Paths
$image_routes = [
    'user_icon_background_less' => '/Hospital_Management_System/view/static/image/user_bg_less.png',

];

?>
