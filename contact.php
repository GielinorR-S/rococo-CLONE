<?php
$pageTitle = "Contact";
include 'includes/header.php';
?>

<main class="contact-page" id="main-content" tabindex="-1">
    <!-- Hero -->
    <section class="contact-hero" aria-labelledby="contact-hero-heading">
        <div class="contact-hero-inner">
            <h1 id="contact-hero-heading">Contact</h1>
            <p class="tagline">We'd love to hear from you—reach out for bookings, events, partnerships or a simple hello.</p>
        </div>
    </section>

    <!-- Quick Info Tiles -->
    <section class="contact-tiles" aria-label="Core contact information">
        <div class="tiles-inner">
            <article class="info-tile" aria-labelledby="tile-address">
                <h2 id="tile-address">Address</h2>
                <p>123 Italian Street<br>Food City</p>
            </article>
            <article class="info-tile" aria-labelledby="tile-phone">
                <h2 id="tile-phone">Phone</h2>
                <p><a href="tel:+11234567890">(123) 456-7890</a></p>
            </article>
            <article class="info-tile" aria-labelledby="tile-email">
                <h2 id="tile-email">Email</h2>
                <p><a href="mailto:info@rocco.com">info@rocco.com</a></p>
            </article>
            <article class="info-tile" aria-labelledby="tile-social">
                <h2 id="tile-social">Social</h2>
                <p><span class="social-links"><a href="#" aria-label="Instagram">Instagram</a> · <a href="#" aria-label="Facebook">Facebook</a> · <a href="#" aria-label="TikTok">TikTok</a></span></p>
            </article>
        </div>
    </section>

    <!-- Locations (if multiple) -->
    <section class="contact-locations" aria-labelledby="locations-heading">
        <div class="locations-inner">
            <h2 id="locations-heading">Our Locations</h2>
            <div class="locations-grid">
                <article class="loc-card" aria-labelledby="loc1-name">
                    <div class="loc-image" style="background-image:url('https://images.unsplash.com/photo-1601312378427-8223b1c8f3e1?auto=format&fit=crop&w=800&q=60');" aria-hidden="true"></div>
                    <div class="loc-body">
                        <h3 id="loc1-name">Central</h3>
                        <p>123 Italian Street<br>Food City</p>
                        <p class="loc-contact"><a href="tel:+11234567890">(123) 456-7890</a></p>
                    </div>
                </article>
                <article class="loc-card" aria-labelledby="loc2-name">
                    <div class="loc-image" style="background-image:url('https://images.unsplash.com/photo-1528715471579-d1bcf0ba5e83?auto=format&fit=crop&w=700&q=60');" aria-hidden="true"></div>
                        <div class="loc-body">
                        <h3 id="loc2-name">Riverside</h3>
                        <p>48 Market Walk<br>Waterfront</p>
                        <p class="loc-contact"><a href="tel:+11234567890">(123) 456-7891</a></p>
                    </div>
                </article>
                <article class="loc-card" aria-labelledby="loc3-name">
                    <div class="loc-image" style="background-image:url('https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=60');" aria-hidden="true"></div>
                    <div class="loc-body">
                        <h3 id="loc3-name">Hillside</h3>
                        <p>9 Stone Terrace<br>Upper Town</p>
                        <p class="loc-contact"><a href="tel:+11234567890">(123) 456-7892</a></p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Hours & Notes -->
    <section class="contact-hours" aria-labelledby="hours-heading">
        <div class="hours-inner">
            <div class="hours-text">
                <h2 id="hours-heading">Hours</h2>
                <ul class="hours-list" aria-label="Opening hours">
                    <li><span>Mon – Thu</span><span>11:30 – 22:00</span></li>
                    <li><span>Fri</span><span>11:30 – 23:00</span></li>
                    <li><span>Sat</span><span>10:00 – 23:00</span></li>
                    <li><span>Sun</span><span>10:00 – 21:30</span></li>
                </ul>
                <p class="hours-note">Kitchen closes 45 minutes prior to listed closing time. Public holiday hours may vary.</p>
            </div>
            <div class="hours-image" style="background-image:url('https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?auto=format&fit=crop&w=900&q=60');" aria-label="Shared meal overhead"></div>
        </div>
    </section>

    <!-- Message Form -->
    <section class="contact-form-section" aria-labelledby="form-heading">
        <div class="form-inner">
            <div class="form-intro">
                <h2 id="form-heading">Send a Message</h2>
                <p>Questions, private dining enquiries, media, or supplier introductions—drop us a line and the right person will respond.</p>
            </div>
            <form action="contact-process.php" method="POST" class="contact-form-grid" novalidate>
                <div class="form-row">
                    <label for="cf-name" class="vh">Name</label>
                    <input id="cf-name" name="name" type="text" placeholder="Name" required>
                </div>
                <div class="form-row">
                    <label for="cf-email" class="vh">Email</label>
                    <input id="cf-email" name="email" type="email" placeholder="Email" required>
                </div>
                <div class="form-row">
                    <label for="cf-phone" class="vh">Phone</label>
                    <input id="cf-phone" name="phone" type="tel" placeholder="Phone">
                </div>
                <div class="form-row">
                    <label for="cf-subject" class="vh">Subject</label>
                    <input id="cf-subject" name="subject" type="text" placeholder="Subject">
                </div>
                <div class="form-row full">
                    <label for="cf-message" class="vh">Message</label>
                    <textarea id="cf-message" name="message" placeholder="Message" required></textarea>
                </div>
                <div class="form-actions full">
                    <button type="submit" class="btn alt-btn">Send Message</button>
                </div>
            </form>
        </div>
    </section>

    <!-- CTA Panel -->
    <section class="contact-cta" aria-labelledby="cta-heading">
        <div class="contact-cta-inner">
            <div class="cta-text">
                <h2 id="cta-heading">Prefer to Book Directly?</h2>
                <p>Jump straight into our booking flow to find an open table. For larger groups, use the message form above.</p>
            </div>
            <div class="cta-actions">
                <a href="booking.php" class="btn alt-btn">Book a Table</a>
                <a href="functions.php" class="btn hollow-btn">Events & Functions</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
