<?php
// Start session
session_start();

// Database connection settings
$host = 'localhost';
$db = 'your_database_name';
$user = 'your_database_user';
$pass = 'your_database_password';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Destroy the session and redirect to a goodbye or login page
        session_destroy();
        header("Location: goodbye.php"); // or login.php
        exit();
    } else {
        $error_message = "Error deleting account: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .warning {
            color: #d9534f;
            font-size: 18px;
            margin-bottom: 20px;
        }
        button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #c9302c;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #0275d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Account</h1>
        <p class="warning">Are you sure you want to delete your account? This action cannot be undone.</p>
        
        <?php if (isset($error_message)): ?>
            <p class="warning"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form method="post">
            <button type="submit" name="delete">Delete Account</button>
        </form>
        
        <a href="index.php" class="back-link">Back to Home</a>
    </div>
</body>
</html>
