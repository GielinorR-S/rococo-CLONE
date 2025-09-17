<?php
$pageTitle = "Home";
include 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <h1>Modern Italian Cuisine</h1>
        <p>Experience the authentic taste of Italy in an elegant atmosphere</p>
        <a href="#booking" class="btn">Book a Table</a>
    </div>
</section>

<section class="about">
    <div class="container">
        <h2>Welcome to Rocco</h2>
        <p>Our restaurant offers a unique blend of traditional Italian recipes and modern culinary techniques. 
           Using the freshest ingredients imported directly from Italy, we create dishes that transport you 
           straight to the heart of Naples.</p>
    </div>
</section>

<section class="booking" id="booking">
    <div class="container">
        <h2>Make a Reservation</h2>
        <form action="booking.php" method="POST">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="guests">Number of Guests:</label>
                <input type="number" id="guests" name="guests" min="1" max="20" required>
            </div>
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="special_requests">Special Requests:</label>
                <textarea id="special_requests" name="special_requests"></textarea>
            </div>
            <button type="submit" class="btn">Book Now</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>