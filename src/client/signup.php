<?php
$servername = "localhost";
$username = "root";  // Update with your database username
$password = "";      // Update with your database password
$dbname = "hotelbookingmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">18Hotels</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php" id="loginBtn">Log In</a>
            <a href="account_settings.php">Account Settings</a>
            <a href="contact.php">Contact Us</a>
        </nav>
    </header>
    <main>
        <div class="signup-form">
            <h2>Sign Up</h2>
            <form action="signup.php" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
    
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
    
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
    
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </main>
</body>
</html>
