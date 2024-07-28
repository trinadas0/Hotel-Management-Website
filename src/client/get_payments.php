<?php
require 'db.php';

$sql = "SELECT id, card_number, card_name, expiry_date FROM payment_methods";
$result = $conn->query($sql);

$payments = array();
while ($row = $result->fetch_assoc()) {
    $payments[] = $row;
}

echo json_encode($payments);

$conn->close();
?>
