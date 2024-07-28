CREATE DATABASE IF NOT EXISTS hotelbookingmanagement;

USE hotelbookingmanagement;

CREATE TABLE IF NOT EXISTS payment_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    card_number VARCHAR(20) NOT NULL,
    card_name VARCHAR(50) NOT NULL,
    expiry_date DATE NOT NULL,
    cvv VARCHAR(4) NOT NULL
);

CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number INT NOT NULL,
    beds INT NOT NULL,
    amenities VARCHAR(255),
    price DECIMAL(10, 2) NOT NULL,
    available_from DATE,
    available_to DATE
);

INSERT INTO rooms (room_number, beds, amenities, price, available_from, available_to) VALUES
(101, 1, 'Wi-Fi,Non-Smoking', 100.00, '2024-07-01', '2024-07-31'),
(102, 2, 'Wi-Fi,Pool', 150.00, '2024-07-01', '2024-07-31'),
(103, 1, 'Pet Friendly,Wi-Fi', 120.00, '2024-07-01', '2024-07-31'),
(104, 2, 'Wi-Fi,Non-Smoking,Pool', 200.00, '2024-07-01', '2024-07-31'),
(105, 1, 'Wi-Fi', 90.00, '2024-07-01', '2024-07-31');

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    arrival DATE NOT NULL,
    departure DATE NOT NULL,
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);
