<?php
$pageTitle = "Gift Vouchers";
include 'includes/header.php';
?>
<main class="gv-page" id="main-content" tabindex="-1">
  <section class="std-hero gv-hero" aria-labelledby="gv-hero-heading">
    <div class="std-hero-inner">
      <h1 id="gv-hero-heading">Gift Vouchers</h1>
      <p class="tagline">Share the experience of warm Italian hospitality – flexible value, easy to redeem.</p>
    </div>
  </section>
  <section class="gv-content" aria-labelledby="gv-options-heading">
    <div class="narrow-wrap">
      <h2 id="gv-options-heading">Options</h2>
      <div class="voucher-grid">
        <article class="voucher-card"><h3>Digital Voucher</h3><p>Email delivery within minutes. Ideal last‑minute gift.</p><a href="#" class="mini-link">Purchase →</a></article>
        <article class="voucher-card"><h3>Print Friendly</h3><p>PDF confirmation to present physically. Simple & personal.</p><a href="#" class="mini-link">Download Template →</a></article>
        <article class="voucher-card"><h3>Group / Corporate</h3><p>Bulk orders for teams or clients. Custom messaging supported.</p><a href="contact.php" class="mini-link">Enquire →</a></article>
      </div>
      <div class="gv-faqs" aria-label="Voucher terms">
        <details>
          <summary>Where can vouchers be used?</summary>
          <p>Across all venues for dine‑in food & beverages unless a future special states otherwise.</p>
        </details>
        <details>
          <summary>Partial redemptions</summary>
          <p>Remaining balance is retained until expiry. No cash refunds for unused value.</p>
        </details>
        <details>
            <summary>Expiry policy</summary>
            <p>Placeholder – insert your chosen validity period before launch.</p>
        </details>
      </div>
      <div class="cta-row"><a class="btn alt-btn" href="#">Buy Voucher</a><a class="btn hollow-btn" href="booking.php">Book a Table</a></div>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
