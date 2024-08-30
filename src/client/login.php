<?php
$servername = "localhost";
$username = "root";  // Update with our database username
$password = "";      // Update with our database password
$dbname = "hotelbookingmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <div class="login-form">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
    
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
    
                <button type="submit">Login</button>
            </form>
            
            <p>Don't have an account? <a href="signup.php">Create one</a></p>
        </div>
    </main>
</body>
</html>
