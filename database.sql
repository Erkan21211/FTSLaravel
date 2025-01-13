-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema festival_travel_system
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema festival_travel_system
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `festival_travel_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `festival_travel_system` ;

-- -----------------------------------------------------
-- Table `festival_travel_system`.`buses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`buses` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`buses` (
                                                                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                `name` VARCHAR(255) NOT NULL,
    `capacity` INT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    AUTO_INCREMENT = 28
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`festivals`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`festivals` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`festivals` (
                                                                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                    `name` VARCHAR(255) NOT NULL,
    `location` VARCHAR(255) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    AUTO_INCREMENT = 41
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`bus_planning`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`bus_planning` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`bus_planning` (
                                                                       `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                       `festival_id` BIGINT UNSIGNED NOT NULL,
                                                                       `bus_id` BIGINT UNSIGNED NOT NULL,
                                                                       `departure_time` DATETIME NULL DEFAULT NULL,
                                                                       `departure_location` VARCHAR(255) NOT NULL,
    `available_seats` INT NOT NULL,
    `cost_per_seat` DECIMAL(8,2) NOT NULL,
    `seats_filled` INT NOT NULL DEFAULT '0',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `bus_planning_festival_id_foreign` (`festival_id` ASC) VISIBLE,
    INDEX `bus_planning_bus_id_foreign` (`bus_id` ASC) VISIBLE,
    CONSTRAINT `bus_planning_bus_id_foreign`
    FOREIGN KEY (`bus_id`)
    REFERENCES `festival_travel_system`.`buses` (`id`)
    ON DELETE CASCADE,
    CONSTRAINT `bus_planning_festival_id_foreign`
    FOREIGN KEY (`festival_id`)
    REFERENCES `festival_travel_system`.`festivals` (`id`)
    ON DELETE CASCADE)
    ENGINE = InnoDB
    AUTO_INCREMENT = 40
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`customers` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`customers` (
                                                                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT '0',
    `phone_number` VARCHAR(20) NULL DEFAULT NULL,
    `points` INT NOT NULL DEFAULT '0',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `customers_email_unique` (`email` ASC) VISIBLE)
    ENGINE = InnoDB
    AUTO_INCREMENT = 33
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`bookings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`bookings` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`bookings` (
                                                                   `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                   `customer_id` BIGINT UNSIGNED NOT NULL,
                                                                   `festival_id` BIGINT UNSIGNED NOT NULL,
                                                                   `bus_planning_id` BIGINT UNSIGNED NULL DEFAULT NULL,
                                                                   `booking_date` DATETIME NOT NULL,
                                                                   `cost` DECIMAL(8,2) NOT NULL,
    `status` VARCHAR(255) NOT NULL DEFAULT 'actief',
    `points_earned` INT NOT NULL DEFAULT '0',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `bookings_customer_id_foreign` (`customer_id` ASC) VISIBLE,
    INDEX `bookings_festival_id_foreign` (`festival_id` ASC) VISIBLE,
    INDEX `bookings_bus_planning_id_foreign` (`bus_planning_id` ASC) VISIBLE,
    CONSTRAINT `bookings_bus_planning_id_foreign`
    FOREIGN KEY (`bus_planning_id`)
    REFERENCES `festival_travel_system`.`bus_planning` (`id`)
    ON DELETE CASCADE,
    CONSTRAINT `bookings_customer_id_foreign`
    FOREIGN KEY (`customer_id`)
    REFERENCES `festival_travel_system`.`customers` (`id`)
    ON DELETE CASCADE,
    CONSTRAINT `bookings_festival_id_foreign`
    FOREIGN KEY (`festival_id`)
    REFERENCES `festival_travel_system`.`festivals` (`id`)
    ON DELETE CASCADE)
    ENGINE = InnoDB
    AUTO_INCREMENT = 18
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`cache`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`cache` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`cache` (
                                                                `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`cache_locks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`cache_locks` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`cache_locks` (
                                                                      `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`discounts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`discounts` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`discounts` (
                                                                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                    `name` VARCHAR(255) NOT NULL,
    `required_points` INT NOT NULL,
    `value` DECIMAL(8,2) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`failed_jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`failed_jobs` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`failed_jobs` (
                                                                      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                      `uuid` VARCHAR(255) NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid` ASC) VISIBLE)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`job_batches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`job_batches` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`job_batches` (
                                                                      `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL DEFAULT NULL,
    `cancelled_at` INT NULL DEFAULT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL DEFAULT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`jobs` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`jobs` (
                                                               `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                               `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `jobs_queue_index` (`queue` ASC) VISIBLE)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`migrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`migrations` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`migrations` (
                                                                     `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                     `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB
    AUTO_INCREMENT = 12
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`password_reset_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`password_reset_tokens` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`password_reset_tokens` (
                                                                                `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`email`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`sessions` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`sessions` (
                                                                   `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `user_agent` TEXT NULL DEFAULT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sessions_user_id_index` (`user_id` ASC) VISIBLE,
    INDEX `sessions_last_activity_index` (`last_activity` ASC) VISIBLE)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `festival_travel_system`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `festival_travel_system`.`users` ;

CREATE TABLE IF NOT EXISTS `festival_travel_system`.`users` (
                                                                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `users_email_unique` (`email` ASC) VISIBLE)
    ENGINE = InnoDB
    AUTO_INCREMENT = 6
    DEFAULT CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
