<?php
$servername = "localhost";
$username = "root";  // Default username for local development
$password = "";      // No password required for local development
$dbname = "hotelbookingmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create payment_methods table
$sql = "CREATE TABLE IF NOT EXISTS payment_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    card_number VARCHAR(20) NOT NULL,
    card_name VARCHAR(50) NOT NULL,
    expiry_date DATE NOT NULL,
    cvv VARCHAR(4) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table payment_methods: " . $conn->error);
}

// Create rooms table
$sql = "CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number INT NOT NULL,
    beds INT NOT NULL,
    amenities VARCHAR(255),
    price DECIMAL(10, 2) NOT NULL,
    available_from DATE,
    available_to DATE,
    UNIQUE(room_number, beds, amenities, price, available_from, available_to)
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table rooms: " . $conn->error);
}

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS=0");

// Clear existing data to prevent duplicates
$sql = "TRUNCATE TABLE rooms";
if ($conn->query($sql) !== TRUE) {
    die("Error clearing rooms table: " . $conn->error);
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS=1");

// Insert initial data into rooms table
$sql = "INSERT INTO rooms (room_number, beds, amenities, price, available_from, available_to) VALUES
(101, 1, 'Wi-Fi,Non-Smoking', 100.00, '2024-07-01', '2024-07-31'),
(102, 2, 'Wi-Fi,Pool', 150.00, '2024-07-01', '2024-07-31'),
(103, 1, 'Pet Friendly,Wi-Fi', 120.00, '2024-07-01', '2024-07-31'),
(104, 2, 'Wi-Fi,Non-Smoking,Pool', 200.00, '2024-07-01', '2024-07-31'),
(105, 1, 'Wi-Fi', 90.00, '2024-07-01', '2024-07-31')";
if ($conn->query($sql) !== TRUE) {
    die("Error inserting initial data into rooms table: " . $conn->error);
}

// Create bookings table
$sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    arrival DATE NOT NULL,
    departure DATE NOT NULL,
    FOREIGN KEY (room_id) REFERENCES rooms(id)
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table bookings: " . $conn->error);
}

// Do not close the connection here
?>
