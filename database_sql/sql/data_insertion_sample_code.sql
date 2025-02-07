-- Insert into patient
INSERT INTO patient (name, dob, gender, contact, address) VALUES
('John Doe', '1990-05-14', 'Male', '1234567890', '123 Street, NY'),
('Jane Smith', '1985-09-22', 'Female', '9876543210', '456 Avenue, CA'),
('Michael Brown', '1978-11-30', 'Male', '5556667777', '789 Road, TX'),
('Emily Davis', '1995-04-18', 'Female', '3334445555', '321 Blvd, FL'),
('David Wilson', '1982-07-25', 'Male', '7778889999', '654 Lane, WA');

-- Insert into user
INSERT INTO user (email, password, role, created_at, status) VALUES
('test1@hospital.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'Admin', '2025-02-07', 'Active'),
('test2@hospital.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'Doctor', '2025-02-07', 'Active'),
('test3@hospital.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'Nurse', '2025-02-07', 'Active'),
('test4@hospital.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'Receptionist', '2025-02-07', 'Active'),
('test5@hospital.com', '$2y$10$3PLHVPM.1sbukC7Y.tV/lOLBZ.DWvLiwzTLIZ81vAaaRSYO0/WB6O', 'Patient', '2025-02-07', 'Active');

-- Insert into appointment
INSERT INTO appointment (appointment_date, status, patient_id, booked_by_id) VALUES
('2025-02-10', 'Confirmed', 1, 2),
('2025-02-11', 'Pending', 2, 2),
('2025-02-12', 'Completed', 3, 3),
('2025-02-13', 'Cancelled', 4, 3),
('2025-02-14', 'Confirmed', 5, 4);

-- Insert into billing
INSERT INTO billing (amount, status, date, patient_id) VALUES
('200.50', 'Paid', '2025-02-07', 1),
('150.00', 'Unpaid', '2025-02-07', 2),
('300.75', 'Paid', '2025-02-07', 3),
('120.00', 'Pending', '2025-02-07', 4),
('500.00', 'Paid', '2025-02-07', 5);

-- Insert into message
INSERT INTO message (message, timestamp, sender_id, receiver_id) VALUES
('Hello, how are you?', '2025-02-07 10:00:00', 1, 2),
('Your appointment is confirmed.', '2025-02-07 11:00:00', 2, 1),
('Please submit your reports.', '2025-02-07 12:00:00', 3, 4),
('Reminder: Your bill is due.', '2025-02-07 13:00:00', 4, 5),
('Thank you for your service.', '2025-02-07 14:00:00', 5, 3);

-- Insert into test_image
INSERT INTO test_image (image, image_type, upload_date, patient_id, report_id, uploader_id) VALUES
('scan1.jpg', 'MRI', '2025-02-07', 1, 1, 2),
('scan2.jpg', 'X-Ray', '2025-02-07', 2, 2, 3),
('scan3.jpg', 'CT Scan', '2025-02-07', 3, 3, 4),
('scan4.jpg', 'Ultrasound', '2025-02-07', 4, 4, 5),
('scan5.jpg', 'Blood Test', '2025-02-07', 5, 5, 2);

-- Insert into report
INSERT INTO report (report_text, status, created_at) VALUES
('MRI scan results show no abnormalities.', 'Reviewed', '2025-02-07', 4, 1),
('X-Ray reveals minor fracture.', 'Pending', '2025-02-07', 4, 1),
('CT Scan indicates swelling.', 'Reviewed', '2025-02-07', 4, 2),
('Ultrasound confirms pregnancy.', 'Reviewed', '2025-02-07' 4, 1),
('Blood test shows normal sugar levels.', 'Reviewed', '2025-02-07', 4, 1);

-- Insert into test_schedule
INSERT INTO test_schedule (exam_type, date, patient_id, booked_by_id) VALUES
('MRI', '2025-02-08', 1, 2),
('X-Ray', '2025-02-09', 2, 3),
('CT Scan', '2025-02-10', 3, 4),
('Ultrasound', '2025-02-11', 4, 5),
('Blood Test', '2025-02-12', 5, 2);

-- Insert into log
INSERT INTO log (action, timestamp, user_id) VALUES
('User logged in', '2025-02-07 10:00:00', 1),
('Appointment booked', '2025-02-07 11:00:00', 2),
('Bill paid', '2025-02-07 12:00:00', 3),
('Message sent', '2025-02-07 13:00:00', 4),
('Report uploaded', '2025-02-07 14:00:00', 5);
