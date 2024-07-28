
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Page</title>
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

    <section class="banner">
        <img src="18HotelHomeImage.jpg" alt="Hotel Banner">
    </section>

    <main>
        <section class="search-form">
            <h2>Welcome to 18Hotels Room Finder</h2>
            <form id="searchForm" action="search.php" method="GET">
                <div class="form-group">
                    <label for="arrival">Arrival</label>
                    <input type="date" id="arrival" name="arrival" required>
                </div>

                <div class="form-group">
                    <label for="departure">Departure</label>
                    <input type="date" id="departure" name="departure" required>
                </div>

                <div class="form-group">
                    <label for="beds"># of Beds:</label>
                    <input type="radio" id="oneBed" name="beds" value="1" checked> 1
                    <input type="radio" id="twoBeds" name="beds" value="2"> 2
                </div>

                <div class="form-group">
                    <label for="amenities">Amenities:</label>
                    <input type="checkbox" id="petFriendly" name="amenities[]" value="Pet Friendly"> Pet Friendly
                    <input type="checkbox" id="nonSmoking" name="amenities[]" value="Non-Smoking"> Non-Smoking
                    <input type="checkbox" id="pool" name="amenities[]" value="Pool"> Pool
                    <input type="checkbox" id="wifi" name="amenities[]" value="Wi-Fi"> Wi-Fi
                </div>
                <button type="submit">Search</button>
            </form>
        </section>

        <section class="rooms" id="rooms">
            <!-- This section will be filled with room data via JavaScript -->
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>
