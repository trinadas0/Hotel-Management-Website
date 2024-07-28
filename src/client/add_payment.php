<?php
require 'db.php';

$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['cvv']; // Add this to your database table if needed

$sql = "INSERT INTO payment_methods (card_number, card_name, expiry_date, cvv) VALUES ('$cardNumber', '$cardName', '$expiryDate', '$cvv')";

if ($conn->query($sql) === TRUE) {
    echo "New payment method added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
