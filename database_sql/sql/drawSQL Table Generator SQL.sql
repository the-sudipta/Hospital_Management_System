CREATE TABLE `appointment`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `appointment_date` VARCHAR(50) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `patient_id` INT(50) NOT NULL,
    `booked_by_id` INT(50) NOT NULL
);
CREATE TABLE `billing`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `amount` VARCHAR(50) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `date` VARCHAR(50) NOT NULL,
    `patient_id` INT(50) NOT NULL
);
CREATE TABLE `log`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `action` VARCHAR(50) NOT NULL,
    `timestamp` VARCHAR(50) NOT NULL,
    `user_id` INT(50) NOT NULL
);
CREATE TABLE `message`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `message` VARCHAR(300) NOT NULL,
    `timestamp` VARCHAR(50) NOT NULL,
    `sender_id` INT(50) NOT NULL,
    `receiver_id` INT(50) NOT NULL
);
CREATE TABLE `patient`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `dob` VARCHAR(50) NOT NULL,
    `gender` VARCHAR(50) NOT NULL,
    `contact` VARCHAR(50) NOT NULL,
    `address` VARCHAR(150) NOT NULL
);
CREATE TABLE `report`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `report_text` VARCHAR(300) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `created_at` VARCHAR(50) NOT NULL,
    `patient_id` INT(50) NOT NULL,
    `uploader_id` INT(50) NOT NULL
);
CREATE TABLE `test_image`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `image` VARCHAR(300) NOT NULL,
    `image_type` VARCHAR(50) NOT NULL,
    `upload_date` VARCHAR(50) NOT NULL,
    `patient_id` INT(50) NOT NULL,
    `report_id` INT(50) NOT NULL,
    `uploader_id` INT(50) NOT NULL
);
CREATE TABLE `test_schedule`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `exam_type` VARCHAR(50) NOT NULL,
    `date` VARCHAR(50) NOT NULL,
    `patient_id` INT(50) NOT NULL,
    `booked_by_id` INT(50) NOT NULL
);
CREATE TABLE `user`(
    `id` INT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(300) NOT NULL,
    `role` VARCHAR(50) NOT NULL,
    `created_at` VARCHAR(50) NOT NULL,
    `status` VARCHAR(50) NOT NULL
);
ALTER TABLE
    `test_image` ADD CONSTRAINT `test_image_patient_id_foreign` FOREIGN KEY(`patient_id`) REFERENCES `patient`(`id`);
ALTER TABLE
    `test_schedule` ADD CONSTRAINT `test_schedule_patient_id_foreign` FOREIGN KEY(`patient_id`) REFERENCES `patient`(`id`);
ALTER TABLE
    `message` ADD CONSTRAINT `message_receiver_id_foreign` FOREIGN KEY(`receiver_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `appointment` ADD CONSTRAINT `appointment_booked_by_id_foreign` FOREIGN KEY(`booked_by_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `log` ADD CONSTRAINT `log_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `test_image` ADD CONSTRAINT `test_image_report_id_foreign` FOREIGN KEY(`report_id`) REFERENCES `report`(`id`);
ALTER TABLE
    `test_image` ADD CONSTRAINT `test_image_uploader_id_foreign` FOREIGN KEY(`uploader_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `billing` ADD CONSTRAINT `billing_patient_id_foreign` FOREIGN KEY(`patient_id`) REFERENCES `patient`(`id`);
ALTER TABLE
    `appointment` ADD CONSTRAINT `appointment_patient_id_foreign` FOREIGN KEY(`patient_id`) REFERENCES `patient`(`id`);
ALTER TABLE
    `test_schedule` ADD CONSTRAINT `test_schedule_booked_by_id_foreign` FOREIGN KEY(`booked_by_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `report` ADD CONSTRAINT `report_patient_id_foreign` FOREIGN KEY(`patient_id`) REFERENCES `patient`(`id`);
ALTER TABLE
    `report` ADD CONSTRAINT `report_uploader_id_foreign` FOREIGN KEY(`uploader_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `message` ADD CONSTRAINT `message_sender_id_foreign` FOREIGN KEY(`sender_id`) REFERENCES `user`(`id`);