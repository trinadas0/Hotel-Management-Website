<?php
session_start();

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

// Retrieve query parameters
$arrival = $_GET['arrival'];
$departure = $_GET['departure'];
$beds = $_GET['beds'];
$amenities = isset($_GET['amenities']) ? $_GET['amenities'] : [];

// Build the base query
$query = "SELECT DISTINCT * FROM rooms WHERE beds = ? AND available_from <= ? AND available_to >= ?";

// Append conditions for selected amenities
if (!empty($amenities)) {
    $amenities_conditions = array_map(function($amenity) {
        return "FIND_IN_SET(?, amenities)";
    }, $amenities);
    $query .= " AND " . implode(" AND ", $amenities_conditions);
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
$params = array_merge([$beds, $arrival, $departure], $amenities);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Output the results
foreach ($results as $room) {
    echo "<div class='room' data-room-id='{$room['id']}'>
            <h3>Room {$room['room_number']}</h3>
            <p>Beds: {$room['beds']}</p>
            <p>Amenities: {$room['amenities']}</p>
            <p>Price: \${$room['price']} per night</p>";
    if (isset($_SESSION['user_id'])) {
        echo "<button class='book-btn' data-room-id='{$room['id']}'>Book</button>";
    } else {
        echo "<p>Please <a href='login.php'>log in</a> to book this room.</p>";
    }
    echo "</div>";
}

$stmt->close();
$conn->close();
?>
