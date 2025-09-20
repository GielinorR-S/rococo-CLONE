                </main>
                <footer class="site-footer" aria-labelledby="footer-heading">
                    <div class="footer-top">
                        <h2 id="footer-heading" class="vh">Footer</h2>
                        <div class="footer-grid">
                            <div class="footer-col brand-col">
                                <div class="brand-mark">ROCCO</div>
                                <p class="brand-copy">Modern Italian dining rooted in craft, warmth and seasonal integrity. Shared plates, wood fire, and a genuine hospitality culture.</p>
                                <ul class="social-list" aria-label="Social links">
                                    <li><a href="#" aria-label="Instagram">Instagram</a></li>
                                    <li><a href="#" aria-label="Facebook">Facebook</a></li>
                                    <li><a href="#" aria-label="TikTok">TikTok</a></li>
                                </ul>
                            </div>
                                            <nav class="footer-col nav-col" aria-label="Footer navigation">
                                                <h3 class="fc-heading">Explore</h3>
                                                <ul class="link-list">
                                                    <li><a href="index.php">Home</a></li>
                                                    <li><a href="booking.php">Book Now</a></li>
                                                    <li><a href="delivery-takeaway.php">Delivery &amp; Takeaway</a></li>
                                                    <li><a href="locations-menus.php">Locations &amp; Menus</a></li>
                                                    <li><a href="group-bookings.php">Group Bookings</a></li>
                                                    <li><a href="gift-vouchers.php">Gift Vouchers</a></li>
                                                    <li><a href="employment.php">Employment</a></li>
                                                    <li><a href="contact.php">Contact</a></li>
                                                </ul>
                                            </nav>
                            <div class="footer-col hours-col" aria-labelledby="hours-heading-footer">
                                <h3 id="hours-heading-footer" class="fc-heading">Hours</h3>
                                <ul class="hours-list-mini">
                                    <li><span>Mon – Thu</span><span>11:30 – 22:00</span></li>
                                    <li><span>Fri</span><span>11:30 – 23:00</span></li>
                                    <li><span>Sat</span><span>10:00 – 23:00</span></li>
                                    <li><span>Sun</span><span>10:00 – 21:30</span></li>
                                </ul>
                                <p class="hours-note-mini">Kitchen closes 45 min before close.</p>
                            </div>
                            <div class="footer-col contact-col" aria-labelledby="contact-heading-footer">
                                <h3 id="contact-heading-footer" class="fc-heading">Contact</h3>
                                <address class="contact-block">
                                    <p>123 Italian Street<br>Food City</p>
                                    <p><a href="tel:+11234567890">(123) 456-7890</a><br><a href="mailto:info@rocco.com">info@rocco.com</a></p>
                                </address>
                                <form class="newsletter-mini" action="newsletter.php" method="POST" aria-label="Newsletter subscription">
                                    <div class="nm-field">
                                        <label for="foot-email" class="vh">Email</label>
                                        <input type="email" id="foot-email" name="email" placeholder="Email" required>
                                        <button type="submit" class="nm-btn" aria-label="Subscribe">→</button>
                                    </div>
                                    <p class="nm-note">Monthly; no spam.</p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="footer-bottom-bar">
                        <p class="copyright">&copy; <?php echo date('Y'); ?> Rocco Restaurant. All rights reserved.</p>
                        <ul class="legal-links" aria-label="Legal links">
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Accessibility</a></li>
                        </ul>
                    </div>
                </footer>
                <script src="assets/js/script.js"></script>
            </body>
            </html>
            <?php ob_end_flush(); ?>