<?php

// Frontend routes
$routes = [
    'INDEX' => '/index.php',
    'login' => '/view/Login.php',
    'loader' => '/view/Loader.php',
    'database_error' => '/view/error/database_error.php',
    'not_found_error' => '/view/error/404_not_found_error.php',
    'forbidden_error' => '/view/error/403_forbidden_error.php',
    'internal_server_error' => '/view/error/500_internal_server_error.php',

//    Dashboards

    'admin_dashboard' => '/view/admin/Admin_Dashboard.php',
    'his_dashboard' => '/view/his/HIS_Dashboard.php',
    'pacs_dashboard' => '/view/pacs/PACS_Dashboard.php',
    'ris_dashboard' => '/view/ris/RIS_Dashboard.php',


//    PACS Links

    'pacs_view_images' => '/view/pacs/PACS_View_Images.php',
    'pacs_upload_images' => '/view/pacs/PACS_Upload_Images.php',
    'pacs_my_profile' => '/~',

//    HIS Links

    'his_all_appointments' => '/view/his/HIS_All_Appointments.php',
    'his_all_bills' => '/view/his/HIS_All_Bills.php',
    'his_all_patients' => '/view/his/HIS_All_Patients.php',
    'his_create_appointment' => '/view/his/HIS_Create_Appointment.php',
    'his_create_bill' => '/view/his/HIS_Create_Bill.php',
    'his_create_patient' => '/view/his/HIS_Create_Patient.php',
    'his_single_appointment' => '/view/his/HIS_Single_Appointment.php',
    'his_single_bill' => '/view/his/HIS_Single_Bill.php',
    'his_single_patient' => '/view/his/HIS_Single_Patient.php',

//    RIS Links

    'ris_all_reports' => '/view/ris/RIS_All_Reports.php',
    'ris_all_schedules' => '/view/ris/RIS_All_Schedules.php',
    'ris_create_report' => '/view/ris/RIS_Create_Report.php',
    'ris_create_schedule' => '/view/ris/RIS_Create_Schedule.php',
    'ris_single_report' => '/view/ris/RIS_Single_Report.php',
    'ris_single_schedule' => '/view/ris/RIS_Single_Schedule.php',

//    Admin Links

    'admin_all_users' => '/view/admin/Admin_All_Users.php',
    'admin_create_user' => '/view/admin/Admin_Create_User.php',
    'admin_single_user' => '/view/admin/Admin_Single_User.php',
    // Admin Patient Functionalities
    'admin_all_patients' => '/~',
    'admin_create_patient' => '/~',
    'admin_single_patient' => '/~',
    // Admin Appointment Functionalities
    'admin_all_appointments' => '/~',
    'admin_create_appointment' => '/~',
    'admin_single_appointment' => '/~',
    // Admin Schedule Functionalities
    'admin_all_schedules' => '/~',
    'admin_create_schedule' => '/~',
    'admin_single_schedule' => '/~',
    // Admin Report Functionalities
    'admin_all_reports' => '/~',
    'admin_create_report' => '/~',
    'admin_single_report' => '/~',
    // Admin Bill Functionalities
    'admin_all_bills' => '/~',
    'admin_create_bill' => '/~',
    'admin_single_bill' => '/~',
    // Admin Image Functionalities
    'admin_all_images' => '/~',
    'admin_upload_image' => '/~',
    'admin_show_single_image' => '/~',
    // Admin Log Functionalities
    'admin_all_logs' => '/view/admin/Admin_All_logs.php',
    'admin_create_log' => '/~',
    'admin_single_log' => '/~',









//    Image_Location Route
    'image_location' => '/controller/pacs/uploads/',



];

// Backend routes
$backend_routes = [
    'login_controller' => '/controller/LoginController.php',
    'logout_controller' => '/controller/LogoutController.php',

//    PACS Links

    'pacs_upload_images_controller' => '/controller/pacs/PACS_Upload_ImagesController.php',

//    HIS Links

    'create_patient_controller' => '/controller/his/CreatePatientController.php',
    'update_patient_controller' => '/controller/his/UpdatePatientController.php',
    'delete_patient_controller' => '/controller/his/DeletePatientController.php',

    'create_appointment_controller' => '/controller/his/CreateAppointmentController.php',
    'update_appointment_controller' => '/~',
    'delete_appointment_controller' => '/controller/his/DeleteAppointmentController.php',

    'create_bill_controller' => '/controller/his/CreateBillController.php',
    'update_bill_controller' => '/~',
    'delete_bill_controller' => '/controller/his/DeleteBillController.php',


//    RIS Links


    'create_report_controller' => '/controller/ris/CreateReportController.php',
    'update_report_controller' => '/controller/ris/UpdateReportController.php',
    'delete_report_controller' => '/controller/ris/DeleteReportController.php',

    'create_schedule_controller' => '/controller/ris/CreateScheduleController.php',
    'update_schedule_controller' => '/controller/ris/UpdateScheduleController.php',
    'delete_schedule_controller' => '/controller/ris/DeleteScheduleController.php',


//    Admin Links

    'create_user_controller' => '/controller/admin/Admin_Create_UserController.php',
    'delete_user_controller' => '/controller/admin/Admin_DeleteUserController.php',
    're_active_user_controller' => '/controller/admin/Admin_Re_Active_UserController.php',


];


// Image Paths
$image_routes = [
    'user_icon_background_less' => '/view/static/image/user_bg_less.png',
    'paper_plane' => '/view/static/image/paper_plane.png',
    'paper_plane_2' => '/view/static/image/paper_plane2.png',

];


