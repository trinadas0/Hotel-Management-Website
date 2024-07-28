<?php
$servername = "localhost";
$username = "arfah";
$password = "arfah1234";
$dbname = "hotel_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['cvv'];

$sql = "INSERT INTO payment_methods (card_number, card_name, expiry_date, cvv) VALUES ('$cardNumber', '$cardName', '$expiryDate', '$cvv')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

