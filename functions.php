<?php
$pageTitle = "Functions";
include 'includes/header.php';
?>

<section class="functions-hero">
    <div class="container">
        <h1>Private Functions & Events</h1>
        <p>Host your special occasions in our elegant space</p>
    </div>
</section>

<section class="functions-content">
    <div class="container">
        <div class="functions-info">
            <h2>Perfect Venue for Your Event</h2>
            <p>Our restaurant offers a sophisticated atmosphere for your private events, weddings, corporate functions, and special celebrations. We provide customized menus and dedicated service to make your event memorable.</p>
            
            <div class="features">
                <div class="feature">
                    <h3>Capacity</h3>
                    <p>Up to 120 guests for seated events<br>200 guests for standing receptions</p>
                </div>
                <div class="feature">
                    <h3>Services</h3>
                    <p>Customized menus<br>Professional staff<br>Audio/Visual equipment</p>
                </div>
                <div class="feature">
                    <h3>Options</h3>
                    <p>Private dining room<br>Full restaurant hire<br>Seasonal outdoor terrace</p>
                </div>
            </div>
        </div>

        <div class="enquiry-form">
            <h2>Enquire About Functions</h2>
            <form action="functions-process.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Your Phone" required>
                </div>
                <div class="form-group">
                    <input type="date" name="event_date" placeholder="Event Date">
                </div>
                <div class="form-group">
                    <input type="number" name="guests" placeholder="Number of Guests" min="1">
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Tell us about your event" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Submit Enquiry</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>