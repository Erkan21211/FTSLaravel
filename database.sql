-- Database creation
CREATE DATABASE IF NOT EXISTS festival_travel_system;
USE festival_travel_system;

-- Table for Customers
CREATE TABLE customers (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           first_name VARCHAR(255) NOT NULL,
                           last_name VARCHAR(255) NOT NULL,
                           email VARCHAR(255) UNIQUE NOT NULL,
                           phone_number VARCHAR(20),
                           points INT DEFAULT 0,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for Festivals
CREATE TABLE festivals (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(255) NOT NULL,
                           location VARCHAR(255) NOT NULL,
                           start_date DATE NOT NULL,
                           end_date DATE NOT NULL,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for Buses
CREATE TABLE buses (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       bus_number VARCHAR(50) NOT NULL,
                       capacity INT NOT NULL,
                       status ENUM('available', 'full', 'inactive') DEFAULT 'available',
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for Bookings
CREATE TABLE bookings (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          customer_id INT NOT NULL,
                          festival_id INT NOT NULL,
                          bus_id INT,
                          booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          points_earned INT DEFAULT 0,
                          FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
                          FOREIGN KEY (festival_id) REFERENCES festivals(id) ON DELETE CASCADE,
                          FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE SET NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for Festival Bus Planning
CREATE TABLE bus_planning (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              festival_id INT NOT NULL,
                              bus_id INT NOT NULL,
                              seats_filled INT DEFAULT 0,
                              FOREIGN KEY (festival_id) REFERENCES festivals(id) ON DELETE CASCADE,
                              FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
                              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                              updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
