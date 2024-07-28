<?php
$servername = "localhost";
$username = "arfah";
$password = "arfah1234";
$dbname = "hotel_booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$expiryDate = $_POST['expiryDate'];

$sql = "UPDATE payment_methods SET card_number='$cardNumber', card_name='$cardName', expiry_date='$expiryDate' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
