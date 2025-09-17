<?php
$pageTitle = "Contact";
include 'includes/header.php';
?>

<section class="contact-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you</p>
    </div>
</section>

<section class="contact-content">
    <div class="container">
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <div class="contact-item">
                <h3>Address</h3>
                <p>123 Italian Street, Food City</p>
            </div>
            <div class="contact-item">
                <h3>Phone</h3>
                <p>(123) 456-7890</p>
            </div>
            <div class="contact-item">
                <h3>Email</h3>
                <p>info@rocco.com</p>
            </div>
        </div>

        <div class="contact-form">
            <h2>Send us a Message</h2>
            <form action="contact-process.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Your Phone">
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>