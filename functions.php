<?php
$pageTitle = "Functions";
include 'includes/header.php';
?>

<section class="functions-hero" aria-labelledby="functions-heading">
    <div class="functions-hero-inner">
        <h1 id="functions-heading">Private Functions &amp; Events</h1>
        <p class="sub">Tailored celebrations, corporate gatherings and milestone moments across our venues.</p>
    </div>
</section>

<!-- Highlight Stats / Features -->
<section class="functions-highlights" aria-label="Function capabilities">
    <div class="highlights-inner">
        <div class="highlight">
            <h3>120</h3>
            <p>Seated Capacity</p>
        </div>
        <div class="highlight">
            <h3>200</h3>
            <p>Standing Reception</p>
        </div>
        <div class="highlight">
            <h3>4</h3>
            <p>Distinct Venues</p>
        </div>
        <div class="highlight">
            <h3>AV</h3>
            <p>Audio Visual Support</p>
        </div>
    </div>
</section>

<!-- About / Options Split -->
<section class="functions-about" aria-label="Venue overview">
    <div class="about-grid">
        <div class="about-text">
            <h2>Designed Around Your Event</h2>
            <p>From intimate dinners to full venue activations, we curate seamless experiences: bespoke menus, timing choreography and warm professional service. Seasonal produce, thoughtful Italian foundations and guest‑first flow underpin everything we deliver.</p>
            <ul class="bullet-list">
                <li>Custom multi-course or canapé style menus</li>
                <li>Wine pairing & beverage packages</li>
                <li>Dedicated event coordinator</li>
                <li>Flexible floor configurations</li>
            </ul>
        </div>
        <div class="about-gallery">
            <div class="gallery-tile" style="background-image:url('https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=800&q=70');" aria-label="Elegant table setting"></div>
            <div class="gallery-tile" style="background-image:url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=70');" aria-label="Shared Italian dishes"></div>
            <div class="gallery-tile tall" style="background-image:url('https://images.unsplash.com/photo-1490818387583-1baba5e638af?auto=format&fit=crop&w=800&q=70');" aria-label="Celebration atmosphere"></div>
            <div class="gallery-tile" style="background-image:url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=800&q=70');" aria-label="Canapés on tray"></div>
        </div>
    </div>
</section>

<!-- Enquiry Panel -->
<section class="functions-enquiry" aria-labelledby="enquiry-heading">
    <div class="enquiry-inner">
        <div class="enquiry-intro">
            <h2 id="enquiry-heading">Enquire About Functions</h2>
            <p>Provide a few details and our events team will respond with availability, package options and tailored recommendations.</p>
        </div>
        <form class="enquiry-form" action="functions-process.php" method="POST" novalidate>
            <div class="form-row">
                <label class="vh" for="fn-name">Name</label>
                <input id="fn-name" type="text" name="name" placeholder="Your Name" required>
            </div>
            <div class="form-row">
                <label class="vh" for="fn-email">Email</label>
                <input id="fn-email" type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-row">
                <label class="vh" for="fn-phone">Phone</label>
                <input id="fn-phone" type="tel" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-row">
                <label class="vh" for="fn-date">Event Date</label>
                <input id="fn-date" type="date" name="event_date" placeholder="Event Date">
            </div>
            <div class="form-row">
                <label class="vh" for="fn-guests">Guests</label>
                <input id="fn-guests" type="number" name="guests" min="1" placeholder="Guests">
            </div>
            <div class="form-row full">
                <label class="vh" for="fn-message">Message</label>
                <textarea id="fn-message" name="message" rows="5" placeholder="Tell us about your event (style, occasion, timing)" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn alt-btn">Submit Enquiry</button>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>