<?php
require 'db.php';

$id = $_POST['id'];

$sql = "DELETE FROM payment_methods WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Payment method deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
