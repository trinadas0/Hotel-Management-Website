<?php
$servername = "localhost";
$username = "arfah";
$password = "arfah1234";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, card_number, card_name, expiry_date FROM payment_methods";
$result = $conn->query($sql);

$payments = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
}

echo json_encode($payments);

$conn->close();

