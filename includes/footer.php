
    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h4>Contact Information</h4>
                <ul>
                    <li>123 Via Roma, Milan, Italy</li>
                    <li>Phone: +39 02 1234 5678</li>
                    <li>Email: info@rococo.com</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Opening Hours</h4>
                <ul>
                    <li>Mon-Fri: 12:00 - 23:00</li>
                    <li>Sat-Sun: 11:00 - 00:00</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><span class="icon-facebook"></span></a>
                    <a href="#" aria-label="Instagram"><span class="icon-instagram"></span></a>
                    <a href="#" aria-label="Twitter"><span class="icon-twitter"></span></a>
                </div>
                <?php
                $newsletter_success = false;
                $newsletter_error = '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
                    $newsletter_email = $_POST['email'] ?? '';
                    if ($newsletter_email && filter_var($newsletter_email, FILTER_VALIDATE_EMAIL)) {
                        // Here you would normally save to a database or send an email
                        $newsletter_success = true;
                    } else {
                        $newsletter_error = 'Please enter a valid email address.';
                    }
                }
                ?>
                <?php if ($newsletter_success): ?>
                    <div class="success-message">Thank you for subscribing!</div>
                <?php else: ?>
                    <?php if ($newsletter_error): ?>
                        <div class="error-message"><?php echo htmlspecialchars($newsletter_error); ?></div>
                    <?php endif; ?>
                    <form class="newsletter-form" action="" method="POST">
                        <input type="email" name="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Rococo. All rights reserved.</p>
        </div>
    </footer>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
