CREATE TABLE postcategories(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL
);

CREATE TABLE dkm_members(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `member_name` VARCHAR(255) NOT NULL,
  `member_position` VARCHAR(255) NOT NULL,
  `member_job` VARCHAR(255) NOT NULL,
  `member_image` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL
);

CREATE TABLE dkm_structure(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `child_id` INT NOT NULL,
  `parent_id` INT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`child_id`) REFERENCES `dkm_members`(`id`),
  FOREIGN KEY(`parent_id`) REFERENCES `dkm_members`(`id`)
);

CREATE TABLE `roles`(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(255),
  `remarks` VARCHAR(255),
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL
);

CREATE TABLE `users`(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT NOT NULL,
  `member_id` INT NOT NULL,
  `username` VARCHAR(255),
  `email` VARCHAR(255),
  `password` VARCHAR(255),
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`member_id`) REFERENCES `dkm_members`(`id`),
  FOREIGN KEY(`role_id`) REFERENCES `roles`(`id`)
);

CREATE TABLE minutes_of_meetings(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `meeting_date` DATE NOT NULL,
  `meeting_time` TIME NOT NULL,
  `meeting_room` VARCHAR(255) NOT NULL,
  `meeting_participants` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `body` LONGTEXT NOT NULL,
  `status` ENUM('open', 'closed'),
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);

CREATE TABLE events(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ref_meeting` INT NOT NULL,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `event_name` VARCHAR(255) NOT NULL,
  `event_date` DATE NOT NULL,
  `event_time` TIME NOT NULL,
  `event_location` VARCHAR(255) NOT NULL,
  `remarks` VARCHAR(255) NULL,
  `status` ENUM('open', 'closed'),
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  
  FOREIGN KEY(`ref_meeting`) REFERENCES `minutes_of_meetings`(`id`)
);

CREATE TABLE event_committees(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `person_name` VARCHAR(255) NOT NULL,
  `position` VARCHAR(255) NOT NULL,
  `main_duties_and_functions` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`event_id`) REFERENCES `events`(`id`),
  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);

CREATE TABLE event_budgeting(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `budget_name` VARCHAR(255) NOT NULL,
  `budget_price` INT NOT NULL,
  `remarks` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`event_id`) REFERENCES `events`(`id`),
  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);

CREATE TABLE zakat_fitrah(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `person_name` VARCHAR(255) NOT NULL,
  `person_address` VARCHAR(255) NOT NULL,
  `person_status` ENUM('Muzakki', 'Fakir', 'Miskin', 'Amil', 'Mualaf', 'Riqab', 'Gharimin', 'Fisabilillah', 'Ibnu Sabil'),
  `zakat_type` ENUM('Uang', 'Beras'),
  `qty_in` DECIMAL(10,3) NULL,
  `qty_out` DECIMAL(10,3) NULL,
  `remarks` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);

CREATE TABLE zakat_maal(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `person_name` VARCHAR(255) NOT NULL,
  `person_address` VARCHAR(255) NOT NULL,
  `person_status` ENUM('Muzakki', 'Fakir', 'Miskin', 'Amil', 'Mualaf', 'Riqab', 'Gharimin', 'Fisabilillah', 'Ibnu Sabil'),
  `qty_in` DECIMAL(10,2) NULL,
  `qty_out` DECIMAL(10,2) NULL,
  `remarks` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);

CREATE TABLE infaq(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `person_name` VARCHAR(255) NOT NULL,
  `person_address` VARCHAR(255) NOT NULL,
  `qty_in` DECIMAL(10,2) NULL,
  `qty_out` DECIMAL(10,2) NULL,
  `remarks` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);

CREATE TABLE event_cash(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ref_event` INT NOT NULL,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `remarks` VARCHAR(255),
  `qty_in` DECIMAL(10,2) NULL,
  `qty_out` DECIMAL(10,2) NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`ref_event`) REFERENCES `events`(`id`),
  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);