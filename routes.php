<?php

// Frontend routes
$routes = [
    'INDEX' => '/Hospital_Management_System/index.php',
    'login' => '/Hospital_Management_System/view/Login.php',
    'loader' => '/Hospital_Management_System/view/Loader.php',
    'database_error' => '/Hospital_Management_System/view/error/database_error.php',
    'not_found_error' => '/Hospital_Management_System/view/error/404_not_found_error.php',

//    Dashboards

    'admin_dashboard' => '/Hospital_Management_System/view/admin/Admin_Dashboard.php',
    'his_dashboard' => '/Hospital_Management_System/view/his/HIS_Dashboard.php',
    'pacs_dashboard' => '/Hospital_Management_System/view/pacs/PACS_Dashboard.php',
    'ris_dashboard' => '/Hospital_Management_System/view/ris/RIS_Dashboard.php',


//    PACS Links

    'pacs_view_images' => '/Hospital_Management_System/view/pacs/PACS_View_Images.php',
    'pacs_upload_images' => '/Hospital_Management_System/view/pacs/PACS_Upload_Images.php',
    'pacs_my_profile' => '/Hospital_Management_System/~',


//    Image_Location Route
    'image_location' => '/Hospital_Management_System/controller/pacs/uploads/',



];

// Backend routes
$backend_routes = [
    'login_controller' => '/Hospital_Management_System/controller/LoginController.php',
    'logout_controller' => '/Hospital_Management_System/controller/LogoutController.php',

//    PACS Links

    'pacs_upload_images_controller' => '/Hospital_Management_System/controller/pacs/PACS_Upload_ImagesController.php',

];


// Image Paths
$image_routes = [
    'user_icon_background_less' => '/Hospital_Management_System/view/static/image/user_bg_less.png',

];


