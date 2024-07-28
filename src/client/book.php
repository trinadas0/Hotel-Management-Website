<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelbookingmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room_id = $_POST['room_id'] ?? '';
$arrival = $_POST['arrival'] ?? '';
$departure = $_POST['departure'] ?? '';

if (empty($room_id) || empty($arrival) || empty($departure)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Insert booking record
$sql = "INSERT INTO bookings (room_id, arrival, departure) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iss", $room_id, $arrival, $departure);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
