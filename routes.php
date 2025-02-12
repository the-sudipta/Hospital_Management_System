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

//    RIS Links

    'ris_all_reports' => '/Hospital_Management_System/view/ris/RIS_All_Reports.php',
    'ris_all_schedules' => '/Hospital_Management_System/view/ris/RIS_All_Schedules.php',
    'ris_create_report' => '/Hospital_Management_System/view/ris/RIS_Create_Report.php',
    'ris_create_schedule' => '/Hospital_Management_System/view/ris/RIS_Create_Schedule.php',
    'ris_single_report' => '/Hospital_Management_System/view/ris/RIS_Single_Report.php',
    'ris_single_schedule' => '/Hospital_Management_System/view/ris/RIS_Single_Schedule.php',

//    Admin Links

    'admin_all_users' => '/Hospital_Management_System/view/admin/Admin_All_Users.php',
    'admin_create_user' => '/Hospital_Management_System/view/admin/Admin_Create_User.php',
    'admin_single_user' => '/Hospital_Management_System/view/admin/Admin_Single_User.php',
    // Admin Patient Functionalities
    'admin_all_patients' => '/Hospital_Management_System/~',
    'admin_create_patient' => '/Hospital_Management_System/~',
    'admin_single_patient' => '/Hospital_Management_System/~',
    // Admin Appointment Functionalities
    'admin_all_appointments' => '/Hospital_Management_System/~',
    'admin_create_appointment' => '/Hospital_Management_System/~',
    'admin_single_appointment' => '/Hospital_Management_System/~',
    // Admin Schedule Functionalities
    'admin_all_schedules' => '/Hospital_Management_System/~',
    'admin_create_schedule' => '/Hospital_Management_System/~',
    'admin_single_schedule' => '/Hospital_Management_System/~',
    // Admin Report Functionalities
    'admin_all_reports' => '/Hospital_Management_System/~',
    'admin_create_report' => '/Hospital_Management_System/~',
    'admin_single_report' => '/Hospital_Management_System/~',
    // Admin Bill Functionalities
    'admin_all_bills' => '/Hospital_Management_System/~',
    'admin_create_bill' => '/Hospital_Management_System/~',
    'admin_single_bill' => '/Hospital_Management_System/~',
    // Admin Image Functionalities
    'admin_all_images' => '/Hospital_Management_System/~',
    'admin_upload_image' => '/Hospital_Management_System/~',
    'admin_show_single_image' => '/Hospital_Management_System/~',
    // Admin Log Functionalities
    'admin_all_logs' => '/Hospital_Management_System/view/admin/Admin_All_logs.php',
    'admin_create_log' => '/Hospital_Management_System/~',
    'admin_single_log' => '/Hospital_Management_System/~',









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

    'create_bill_controller' => '/Hospital_Management_System/controller/his/CreateBillController.php',
    'update_bill_controller' => '/Hospital_Management_System/~',
    'delete_bill_controller' => '/Hospital_Management_System/controller/his/DeleteBillController.php',


//    RIS Links


    'create_report_controller' => '/Hospital_Management_System/controller/ris/CreateReportController.php',
    'update_report_controller' => '/Hospital_Management_System/controller/ris/UpdateReportController.php',
    'delete_report_controller' => '/Hospital_Management_System/controller/ris/DeleteReportController.php',

    'create_schedule_controller' => '/Hospital_Management_System/controller/ris/CreateScheduleController.php',
    'update_schedule_controller' => '/Hospital_Management_System/controller/ris/UpdateScheduleController.php',
    'delete_schedule_controller' => '/Hospital_Management_System/controller/ris/DeleteScheduleController.php',


//    Admin Links

    'create_user_controller' => '/Hospital_Management_System/controller/admin/Admin_Create_UserController.php',
    'delete_user_controller' => '/Hospital_Management_System/controller/admin/Admin_DeleteUserController.php',
    're_active_user_controller' => '/Hospital_Management_System/controller/admin/Admin_Re_Active_UserController.php',


];


// Image Paths
$image_routes = [
    'user_icon_background_less' => '/Hospital_Management_System/view/static/image/user_bg_less.png',
    'paper_plane' => '/Hospital_Management_System/view/static/image/paper_plane.png',
    'paper_plane_2' => '/Hospital_Management_System/view/static/image/paper_plane2.png',

];


