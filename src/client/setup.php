<?php
$servername = "localhost";
$username = "root";  // Update with your database username
$password = "";      // Update with your database password
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

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table users: " . $conn->error);
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

// Create bookings table
$sql = "CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    arrival DATE NOT NULL,
    departure DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table bookings: " . $conn->error);
}

//create payments table
$sql = "CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    card_number VARCHAR(20) NOT NULL,
    expiry_date VARCHAR(5) NOT NULL,
    cvv VARCHAR(4) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table bookings: " . $conn->error);
}

// Close the connection
$conn->close();

echo "Database setup completed successfully.";
?>
