-- Insert into `user`
INSERT INTO `user` (`email`, `password`, `role`, `created_at`, `status`) VALUES
('admin1@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'admin', '2025-02-06', 'active'),
('doctor1@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'doctor', '2025-02-06', 'active'),
('nurse1@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'nurse', '2025-02-06', 'active'),
('reception@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'receptionist', '2025-02-06', 'active');

-- Insert into `his_patient`
INSERT INTO `his_patient` (`name`, `dob`, `gender`, `contact`, `address`) VALUES
('John Doe', '1985-07-12', 'Male', '1234567890', '123 Main St'),
('Jane Smith', '1992-03-25', 'Female', '9876543210', '456 Oak St'),
('Michael Brown', '1978-11-15', 'Male', '4567891230', '789 Pine St'),
('Emily Johnson', '2000-05-05', 'Female', '3216549870', '321 Elm St');

-- Insert into `his_appointment`
INSERT INTO `his_appointment` (`his_patient_id`, `user_id`, `appointment_date`, `status`) VALUES
(1, 2, '2025-02-07', 'Scheduled'),
(2, 2, '2025-02-08', 'Completed'),
(3, 3, '2025-02-09', 'Scheduled'),
(4, 3, '2025-02-10', 'Cancelled');

-- Insert into `his_billing`
INSERT INTO `his_billing` (`his_patient_id`, `amount`, `status`, `date`) VALUES
(1, '200', 'Paid', '2025-02-06'),
(2, '350', 'Unpaid', '2025-02-06'),
(3, '150', 'Paid', '2025-02-06'),
(4, '500', 'Pending', '2025-02-06');

-- Insert into `his_message`
INSERT INTO `his_message` (`sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 2, 'Patient John needs an update.', '2025-02-06 10:00:00'),
(2, 1, 'Scheduled an appointment for John.', '2025-02-06 10:05:00'),
(3, 4, 'Billing issue for Jane.', '2025-02-06 11:00:00'),
(4, 3, 'Patient Emily checked in.', '2025-02-06 11:30:00');

-- Insert into `pacs_image`
INSERT INTO `pacs_image` (`his_patient_id`, `user_id`, `image_path`, `image_type`, `upload_date`) VALUES
(1, 2, '/images/patient1_xray.jpg', 'X-ray', '2025-02-06'),
(2, 3, '/images/patient2_ct.jpg', 'CT Scan', '2025-02-06'),
(3, 2, '/images/patient3_mri.jpg', 'MRI', '2025-02-06'),
(4, 3, '/images/patient4_ultrasound.jpg', 'Ultrasound', '2025-02-06');

-- Insert into `pacs_report`
INSERT INTO `pacs_report` (`pacs_image_id`, `report_text`, `created_at`) VALUES
(1, 'Normal X-ray results.', '2025-02-06'),
(2, 'CT scan shows minor abnormalities.', '2025-02-06'),
(3, 'MRI indicates no major issues.', '2025-02-06'),
(4, 'Ultrasound suggests further testing.', '2025-02-06');

-- Insert into `ris_schedule`
INSERT INTO `ris_schedule` (`his_patient_id`, `user_id`, `exam_type`, `scheduled_date`) VALUES
(1, 2, 'X-ray Chest', '2025-02-07'),
(2, 3, 'MRI Brain', '2025-02-08'),
(3, 2, 'CT Abdomen', '2025-02-09'),
(4, 3, 'Ultrasound Pelvis', '2025-02-10');

-- Insert into `ris_report`
INSERT INTO `ris_report` (`ris_schedule_id`, `report_text`, `status`, `created_at`) VALUES
(1, 'X-ray report is clear.', 'Completed', '2025-02-07'),
(2, 'MRI shows no major concerns.', 'Completed', '2025-02-08'),
(3, 'CT scan needs further evaluation.', 'Pending', '2025-02-09'),
(4, 'Ultrasound suggests minor issues.', 'Completed', '2025-02-10');

-- Insert into `access_log`
INSERT INTO `access_log` (`user_id`, `action`, `timestamp`) VALUES
(1, 'Login', '2025-02-06 09:00:00'),
(2, 'Viewed patient records', '2025-02-06 09:30:00'),
(3, 'Updated appointment', '2025-02-06 10:00:00'),
(4, 'Processed billing', '2025-02-06 11:00:00');
-- Insert into `user`
INSERT INTO `user` (`email`, `password`, `role`, `created_at`, `status`) VALUES
('admin1@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'admin', '2025-02-06', 'active'),
('doctor1@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'doctor', '2025-02-06', 'active'),
('nurse1@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'nurse', '2025-02-06', 'active'),
('reception@example.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'receptionist', '2025-02-06', 'active');

-- Insert into `his_patient`
INSERT INTO `his_patient` (`name`, `dob`, `gender`, `contact`, `address`) VALUES
('John Doe', '1985-07-12', 'Male', '1234567890', '123 Main St'),
('Jane Smith', '1992-03-25', 'Female', '9876543210', '456 Oak St'),
('Michael Brown', '1978-11-15', 'Male', '4567891230', '789 Pine St'),
('Emily Johnson', '2000-05-05', 'Female', '3216549870', '321 Elm St');

-- Insert into `his_appointment`
INSERT INTO `his_appointment` (`his_patient_id`, `user_id`, `appointment_date`, `status`) VALUES
(1, 2, '2025-02-07', 'Scheduled'),
(2, 2, '2025-02-08', 'Completed'),
(3, 3, '2025-02-09', 'Scheduled'),
(4, 3, '2025-02-10', 'Cancelled');

-- Insert into `his_billing`
INSERT INTO `his_billing` (`his_patient_id`, `amount`, `status`, `date`) VALUES
(1, '200', 'Paid', '2025-02-06'),
(2, '350', 'Unpaid', '2025-02-06'),
(3, '150', 'Paid', '2025-02-06'),
(4, '500', 'Pending', '2025-02-06');

-- Insert into `his_message`
INSERT INTO `his_message` (`sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 2, 'Patient John needs an update.', '2025-02-06 10:00:00'),
(2, 1, 'Scheduled an appointment for John.', '2025-02-06 10:05:00'),
(3, 4, 'Billing issue for Jane.', '2025-02-06 11:00:00'),
(4, 3, 'Patient Emily checked in.', '2025-02-06 11:30:00');

-- Insert into `pacs_image`
INSERT INTO `pacs_image` (`his_patient_id`, `user_id`, `image_path`, `image_type`, `upload_date`) VALUES
(1, 2, '/images/patient1_xray.jpg', 'X-ray', '2025-02-06'),
(2, 3, '/images/patient2_ct.jpg', 'CT Scan', '2025-02-06'),
(3, 2, '/images/patient3_mri.jpg', 'MRI', '2025-02-06'),
(4, 3, '/images/patient4_ultrasound.jpg', 'Ultrasound', '2025-02-06');

-- Insert into `pacs_report`
INSERT INTO `pacs_report` (`pacs_image_id`, `report_text`, `created_at`) VALUES
(1, 'Normal X-ray results.', '2025-02-06'),
(2, 'CT scan shows minor abnormalities.', '2025-02-06'),
(3, 'MRI indicates no major issues.', '2025-02-06'),
(4, 'Ultrasound suggests further testing.', '2025-02-06');

-- Insert into `ris_schedule`
INSERT INTO `ris_schedule` (`his_patient_id`, `user_id`, `exam_type`, `scheduled_date`) VALUES
(1, 2, 'X-ray Chest', '2025-02-07'),
(2, 3, 'MRI Brain', '2025-02-08'),
(3, 2, 'CT Abdomen', '2025-02-09'),
(4, 3, 'Ultrasound Pelvis', '2025-02-10');

-- Insert into `ris_report`
INSERT INTO `ris_report` (`ris_schedule_id`, `report_text`, `status`, `created_at`) VALUES
(1, 'X-ray report is clear.', 'Completed', '2025-02-07'),
(2, 'MRI shows no major concerns.', 'Completed', '2025-02-08'),
(3, 'CT scan needs further evaluation.', 'Pending', '2025-02-09'),
(4, 'Ultrasound suggests minor issues.', 'Completed', '2025-02-10');

-- Insert into `access_log`
INSERT INTO `access_log` (`user_id`, `action`, `timestamp`) VALUES
(1, 'Login', '2025-02-06 09:00:00'),
(2, 'Viewed patient records', '2025-02-06 09:30:00'),
(3, 'Updated appointment', '2025-02-06 10:00:00'),
(4, 'Processed billing', '2025-02-06 11:00:00');
