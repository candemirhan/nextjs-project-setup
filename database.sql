-- Create database
CREATE DATABASE IF NOT EXISTS onlyfans_agency;
USE onlyfans_agency;

-- Users table for admin login
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Applications table for content creator applications
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    social_media TEXT,
    experience TEXT,
    message TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Revenue tracking table
CREATE TABLE revenue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_name VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    month DATE NOT NULL,
    platform_fee DECIMAL(10,2) NOT NULL,
    net_amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: admin123)
INSERT INTO users (username, password) VALUES ('admin', '$2y$10$8KzQ8wkl2Qj1JjE5X5v5O.YG3YfOxn4Oi8qF9ZJ5vJ5U5Z5Z5Z5Z5');
