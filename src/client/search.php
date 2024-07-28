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

$arrival = $_GET['arrival'] ?? '';
$departure = $_GET['departure'] ?? '';
$beds = $_GET['beds'] ?? '';
$amenities = isset($_GET['amenities']) ? $_GET['amenities'] : [];

if (empty($arrival) || empty($departure) || empty($beds)) {
    die("Please provide arrival, departure dates, and number of beds.");
}

// Creating the SQL query
$sql = "SELECT * FROM rooms WHERE beds = $beds AND available_from <= '$arrival' AND available_to >= '$departure'";

// Handle amenities filter
if (!empty($amenities)) {
    $amenities_filter = implode(" AND ", array_map(function($amenity) {
        return "FIND_IN_SET('$amenity', amenities)";
    }, $amenities));
    $sql .= " AND $amenities_filter";
}

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='room' data-room-id='" . $row["id"] . "'>";
        echo "<h3>Room " . $row["room_number"]. "</h3>";
        echo "<p>Beds: " . $row["beds"]. "</p>";
        echo "<p>Amenities: " . $row["amenities"]. "</p>";
        echo "<p>Price: $" . $row["price"]. " per night</p>";
        echo "<button class='book-btn' data-room-id='" . $row["id"] . "'>Book</button>";
        echo "</div>";
    }
} else {
    echo "<div class='room'>0 results</div>";
}

$conn->close();
?>
