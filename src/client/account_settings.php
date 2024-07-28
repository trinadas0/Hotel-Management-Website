<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

$user_id = $_SESSION['user_id'];

// Retrieve user's bookings
$sql = "SELECT rooms.room_number, rooms.beds, rooms.amenities, rooms.price, bookings.arrival, bookings.departure 
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.id 
        WHERE bookings.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">18Hotels</div>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="account_settings.php">Account Settings</a>
                <a href="logout.php">Log Out</a>
            <?php else: ?>
                <a href="login.php" id="loginBtn">Log In</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
            <a href="contact.php">Contact Us</a>
        </nav>
    </header>

    <main>
        <section class="account-settings">
            <h2>Account Settings</h2>
            <a href="change_password.html">Change Password</a>
            <a href="payments.html">My Payments</a>
            <a href="delete_account.php">Delete Account</a>

            <h3>My Bookings</h3>
            <?php if (count($bookings) > 0): ?>
                <table>
                    <tr>
                        <th>Room Number</th>
                        <th>Beds</th>
                        <th>Amenities</th>
                        <th>Price</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                    </tr>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['room_number']); ?></td>
                            <td><?php echo htmlspecialchars($booking['beds']); ?></td>
                            <td><?php echo htmlspecialchars($booking['amenities']); ?></td>
                            <td><?php echo htmlspecialchars($booking['price']); ?></td>
                            <td><?php echo htmlspecialchars($booking['arrival']); ?></td>
                            <td><?php echo htmlspecialchars($booking['departure']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>You have no bookings.</p>
            <?php endif; ?>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
