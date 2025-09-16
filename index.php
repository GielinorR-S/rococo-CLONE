
<?php
$pageTitle = "Rococo | Home";
include __DIR__ . '/includes/header.php';
?>
<main>
    <!-- Hero Section -->
    <section class="hero section">
        <div class="hero-content">
            <h1>Simple Italian Food Done Well</h1>
            <p class="hero-subheading">Where rustic Italy and modern Melbourne meet</p>
            <div class="hero-btns">
                <a href="#booking" class="btn btn-primary">Book a Table</a>
                <a href="/menu.php" class="btn btn-outline">View Menu</a>
            </div>
        </div>
    </section>
    <!-- Newsletter Signup Section -->
    <section class="newsletter section">
        <div class="container">
            <h2 class="section-heading">Join Our Newsletter</h2>
            <div class="section-divider"></div>
            <form action="#" method="POST" class="newsletter-form">
                <input type="email" name="newsletter_email" placeholder="Enter your email address" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
            <p class="newsletter-desc">Stay up to date with the latest news, events, and special offers from Rococo.</p>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="welcome section">
        <div class="welcome-image">
            <img src="assets/images/welcome.jpg" alt="Welcome to Rococo">
        </div>
        <div class="welcome-content">
            <h2>Welcome to Rococo</h2>
            <p>Our aim is to provide Melburnians with simple, honest, delicious Italian food. Classic taste, fresh produce, and a sociable shared approach to dining for which Italy is known and loved.</p>
        </div>
    </section>

    <!-- Menu Preview Section -->
    <section class="menu-preview section">
        <div class="section-divider"></div>
        <div class="container">
            <h2 class="section-heading">Our Menu</h2>
            <div class="menu-grid">
                <div class="menu-item">
                    <img src="assets/images/antipasti.jpg" alt="Antipasti">
                    <h3>Antipasti</h3>
                    <a href="menu.php" class="btn btn-outline">View More</a>
                </div>
                <div class="menu-item">
                    <img src="assets/images/pasta.jpg" alt="Pasta">
                    <h3>Pasta</h3>
                    <a href="menu.php" class="btn btn-outline">View More</a>
                </div>
                <div class="menu-item">
                    <img src="assets/images/dessert.jpg" alt="Desserts">
                    <h3>Desserts</h3>
                    <a href="menu.php" class="btn btn-outline">View More</a>
                </div>
                <div class="menu-item">
                    <img src="assets/images/wine.jpg" alt="Wine & Bar">
                    <h3>Wine &amp; Bar</h3>
                    <a href="menu.php" class="btn btn-outline">View More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Functions/Events Section -->
    <section class="functions section">
        <div class="section-divider"></div>
        <div class="functions-content">
            <h2>Private Functions &amp; Events</h2>
            <p>Celebrate your special moments with us. Rococo offers elegant spaces and tailored menus for private events, parties, and corporate gatherings.</p>
            <a href="functions.php" class="btn btn-primary">Enquire Now</a>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section id="booking" class="booking section">
        <div class="section-divider"></div>
        <div class="container">
            <h2 class="section-heading">Book a Table</h2>
            <form action="booking.php" method="POST" class="booking-form">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" id="time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="guests">Number of Guests</label>
                    <input type="number" id="guests" name="guests" min="1" required>
                </div>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="special_requests">Special Requests</label>
                    <textarea id="special_requests" name="special_requests" rows="3"></textarea>
                </div>
                <div class="form-btn">
                    <button type="submit" class="btn btn-primary">Book Now</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Venues/Locations Section -->
    <section class="venues section">
        <div class="section-divider"></div>
        <div class="container">
            <h2 class="section-heading">Our Venues</h2>
            <div class="venue-grid">
                <div class="venue-item">
                    <img src="assets/images/logo_black.png" alt="St Kilda Venue">
                    <h3>St Kilda</h3>
                    <p>Experience the vibrant atmosphere of our St Kilda location, perfect for casual dining and celebrations.</p>
                    <a href="#" class="btn btn-outline">View Details</a>
                </div>
                <div class="venue-item">
                    <img src="assets/images/delivery-icon.png" alt="Hawthorn Venue">
                    <h3>Hawthorn</h3>
                    <p>Enjoy classic Italian cuisine in our elegant Hawthorn venue, ideal for family gatherings and private events.</p>
                    <a href="#" class="btn btn-outline">View Details</a>
                </div>
                <div class="venue-item">
                    <img src="assets/images/gift-voucher-icon.png" alt="Mordialloc Venue">
                    <h3>Mordialloc</h3>
                    <p>Relax by the bay at our Mordialloc restaurant, offering fresh flavors and a welcoming ambiance.</p>
                    <a href="#" class="btn btn-outline">View Details</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
