<?php
$pageTitle = "Delivery & Takeaway";
include 'includes/header.php';
?>
<main class="dt-page" id="main-content" tabindex="-1">
  <section class="std-hero dt-hero" aria-labelledby="dt-hero-heading">
    <div class="std-hero-inner">
      <h1 id="dt-hero-heading">Delivery & Takeaway</h1>
      <p class="tagline">Enjoy our modern Italian plates at home – curated, packed, and ready to share.</p>
    </div>
  </section>
  <section class="dt-platforms" aria-labelledby="platforms-heading">
    <div class="narrow-wrap">
      <h2 id="platforms-heading">Order Platforms</h2>
      <div class="platform-grid">
        <article class="platform-card"><h3>Pickup Direct</h3><p>Call us to place an order for fast pickup. Freshly fired pizzas & house pasta.</p><a class="mini-link" href="contact.php">Contact Locations →</a></article>
        <article class="platform-card"><h3>Local Delivery</h3><p>We partner with local couriers. Delivery zones & fees may vary by suburb.</p><p class="note">(Placeholder – integrate provider later)</p></article>
        <article class="platform-card"><h3>Catering Trays</h3><p>Family‑style pasta, salads & antipasti trays for 6–12 guests. 24h notice preferred.</p><a class="mini-link" href="group-bookings.php">Group Bookings →</a></article>
      </div>
    </div>
  </section>
  <section class="dt-info" aria-labelledby="dt-info-heading">
    <div class="narrow-wrap">
      <h2 id="dt-info-heading">Good To Know</h2>
      <ul class="bullet-list">
        <li>Some in‑house specials may not be available for delivery.</li>
        <li>Reheat guidance included for select dishes.</li>
        <li>We minimise plastic & favour recyclable packaging.</li>
      </ul>
      <div class="dt-badges" aria-label="Highlights">
        <span class="dt-badge">Recyclable</span>
        <span class="dt-badge">Dietaries Friendly</span>
        <span class="dt-badge">Made To Order</span>
      </div>
      <div class="dt-faq" aria-labelledby="dt-faq-heading">
  <h3 id="dt-faq-heading" class="visually-hidden">Delivery & takeaway FAQs</h3>
        <details>
          <summary>Typical delivery time?</summary>
          <p>Our target window is 35–55 minutes depending on distance & service pace. We’ll advise if it’s longer.</p>
        </details>
        <details>
          <summary>Dietary adjustments</summary>
          <p>Many dishes can be adapted (veg, GF-friendly). Note requests when ordering; we’ll confirm if feasible.</p>
        </details>
        <details>
          <summary>Reheating guidance</summary>
          <p>Included for select trays & pastas. Keep pizzas vented; refresh at 180°C for a few minutes if needed.</p>
        </details>
      </div>
      <div class="cta-row"><a class="btn alt-btn" href="menu.php">View Menu</a><a class="btn hollow-btn" href="booking.php">Book Dine-In</a></div>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
