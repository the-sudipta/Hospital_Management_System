<?php

// Frontend routes
$routes = [
    'INDEX' => '/Hospital_Management_System/index.php',
    'login' => '/Hospital_Management_System/view/Login.php',
    'loader' => '/Hospital_Management_System/view/Loader.php',
    'database_error' => '/Hospital_Management_System/view/error/database_error.php',
    'not_found_error' => '/Hospital_Management_System/view/error/404_not_found_error.php',
    'forbidden_error' => '/Hospital_Management_System/view/error/403_forbidden_error.php',
    'internal_server_error' => '/Hospital_Management_System/view/error/500_internal_server_error.php',

//    Dashboards

    'admin_dashboard' => '/Hospital_Management_System/view/admin/Admin_Dashboard.php',
    'his_dashboard' => '/Hospital_Management_System/view/his/HIS_Dashboard.php',
    'pacs_dashboard' => '/Hospital_Management_System/view/pacs/PACS_Dashboard.php',
    'ris_dashboard' => '/Hospital_Management_System/view/ris/RIS_Dashboard.php',


//    PACS Links

    'pacs_view_images' => '/Hospital_Management_System/view/pacs/PACS_View_Images.php',
    'pacs_upload_images' => '/Hospital_Management_System/view/pacs/PACS_Upload_Images.php',
    'pacs_my_profile' => '/Hospital_Management_System/~',

//    HIS Links

    'his_all_appointments' => '/Hospital_Management_System/view/his/HIS_All_Appointments.php',
    'his_all_bills' => '/Hospital_Management_System/view/his/HIS_All_Bills.php',
    'his_all_patients' => '/Hospital_Management_System/view/his/HIS_All_Patients.php',
    'his_create_appointment' => '/Hospital_Management_System/view/his/HIS_Create_Appointment.php',
    'his_create_bill' => '/Hospital_Management_System/view/his/HIS_Create_Bill.php',
    'his_create_patient' => '/Hospital_Management_System/view/his/HIS_Create_Patient.php',
    'his_single_appointment' => '/Hospital_Management_System/view/his/HIS_Single_Appointment.php',
    'his_single_bill' => '/Hospital_Management_System/view/his/HIS_Single_Bill.php',
    'his_single_patient' => '/Hospital_Management_System/view/his/HIS_Single_Patient.php',






//    Image_Location Route
    'image_location' => '/Hospital_Management_System/controller/pacs/uploads/',



];

// Backend routes
$backend_routes = [
    'login_controller' => '/Hospital_Management_System/controller/LoginController.php',
    'logout_controller' => '/Hospital_Management_System/controller/LogoutController.php',

//    PACS Links

    'pacs_upload_images_controller' => '/Hospital_Management_System/controller/pacs/PACS_Upload_ImagesController.php',

//    HIS Links

    'create_patient_controller' => '/Hospital_Management_System/controller/his/CreatePatientController.php',
    'update_patient_controller' => '/Hospital_Management_System/controller/his/UpdatePatientController.php',
    'delete_patient_controller' => '/Hospital_Management_System/controller/his/DeletePatientController.php',

    'create_appointment_controller' => '/Hospital_Management_System/controller/his/CreateAppointmentController.php',
    'update_appointment_controller' => '/Hospital_Management_System/~',
    'delete_appointment_controller' => '/Hospital_Management_System/controller/his/DeleteAppointmentController.php',

];


// Image Paths
$image_routes = [
    'user_icon_background_less' => '/Hospital_Management_System/view/static/image/user_bg_less.png',
    'paper_plane' => '/Hospital_Management_System/view/static/image/paper_plane.png',
    'paper_plane_2' => '/Hospital_Management_System/view/static/image/paper_plane2.png',

];


