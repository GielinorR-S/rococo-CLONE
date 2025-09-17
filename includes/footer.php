        </main>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Rocco</h4>
                    <p>Modern Italian Restaurant & Bar offering a unique dining experience with authentic cuisine and elegant atmosphere.</p>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <p>123 Italian Street, City</p>
                    <p>Phone: (123) 456-7890</p>
                    <p>Email: info@rocco.com</p>
                </div>
                <div class="footer-section">
                    <h4>Opening Hours</h4>
                    <p>Monday - Friday: 5pm - 10pm</p>
                    <p>Saturday - Sunday: 12pm - 11pm</p>
                </div>
                <div class="footer-section">
                    <h4>Newsletter</h4>
                    <p>Subscribe for updates and special offers</p>
                    <form class="newsletter-form" action="newsletter.php" method="POST">
                        <input type="email" name="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Rocco Restaurant. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>