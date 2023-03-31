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
  `username` VARCHAR(255),
  `email` VARCHAR(255),
  `password` VARCHAR(255),
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`role_id`) REFERENCES `roles`(`id`)
);

CREATE TABLE minutes_of_meetings(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_by` INT NOT NULL,
  `updated_by` INT NULL,
  `meeting_date` DATE NOT NULL,
  `meeting_time` TIME NOT NULL,
  `meeting_room` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `body` LONGTEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,

  FOREIGN KEY(`created_by`) REFERENCES `users`(`id`),
  FOREIGN KEY(`updated_by`) REFERENCES `users`(`id`)
);