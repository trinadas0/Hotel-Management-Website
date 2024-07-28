<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">18Hotels</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php" id="loginBtn">Log In</a>
            <a href="account_settings.html">Account Settings</a>
            <a href="contact.php">Contact Us</a>
        </nav>
    </header>

    <main>
        <section class="contact-form">
            <h2>Contact Us</h2>
            <form id="my-form" action="https://formspree.io/f/movaeqoj" method="POST">
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Message:</label>
                <textarea name="message" rows="4" required></textarea>
                <button id="my-form-button">Submit</button>
                <p id="my-form-status"></p>
            </form>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
