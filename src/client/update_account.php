<?php
// update_account.php

// Assuming you have a connection to your database
include('db_connection.php');

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

// Validate and sanitize input, then update the database
if (!empty($username) && !empty($email) && !empty($password)) {
    $query = "UPDATE users SET username = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $username, $email, $password, $user_id);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}

