<?php
$pageTitle = "Locations & Menus";
include 'includes/header.php';
?>
<main class="lm-page" id="main-content" tabindex="-1">
  <section class="std-hero lm-hero" aria-labelledby="lm-hero-heading">
    <div class="std-hero-inner">
      <h1 id="lm-hero-heading">Locations & Menus</h1>
      <p class="tagline">Four distinct dining rooms. One shared philosophy of seasonal Italian hospitality.</p>
    </div>
  </section>
  <section class="lm-locations" aria-labelledby="loc-heading">
    <div class="wide-wrap">
      <h2 id="loc-heading" class="vh">Locations</h2>
      <div class="loc-grid">
        <article class="loc-card" aria-labelledby="loc-stk"><div class="loc-media" style="background-image:url('assets/images/st-kilda-venue.jpg');" aria-hidden="true"></div><div class="loc-body"><h3 id="loc-stk">St Kilda</h3><p>Bustling coastal energy & classic social plates.</p><div class="loc-actions"><a href="booking.php?venue=St+Kilda" class="mini-link">Book →</a><a href="menu.php#pasta" class="mini-link">Sample Menu →</a></div></div></article>
        <article class="loc-card" aria-labelledby="loc-haw"><div class="loc-media" style="background-image:url('assets/images/hawthorn-venue.jpg');" aria-hidden="true"></div><div class="loc-body"><h3 id="loc-haw">Hawthorn</h3><p>Light, refined, neighbourhood dining & aperitivo.</p><div class="loc-actions"><a href="booking.php?venue=Hawthorn" class="mini-link">Book →</a><a href="menu.php#antipasti" class="mini-link">Sample Menu →</a></div></div></article>
        <article class="loc-card" aria-labelledby="loc-pc"><div class="loc-media" style="background-image:url('assets/images/point-cook-venue.jpg');" aria-hidden="true"></div><div class="loc-body"><h3 id="loc-pc">Point Cook</h3><p>Modern west-side hub with relaxed outdoor space.</p><div class="loc-actions"><a href="booking.php?venue=Point+Cook" class="mini-link">Book →</a><a href="menu.php#pasta" class="mini-link">Sample Menu →</a></div></div></article>
        <article class="loc-card" aria-labelledby="loc-mod"><div class="loc-media" style="background-image:url('assets/images/mordialloc-venue.jpg');" aria-hidden="true"></div><div class="loc-body"><h3 id="loc-mod">Mordialloc</h3><p>Beachside sunsets, spritz culture & shared boards.</p><div class="loc-actions"><a href="booking.php?venue=Mordialloc" class="mini-link">Book →</a><a href="menu.php#desserts" class="mini-link">Sample Menu →</a></div></div></article>
      </div>
      <p class="note">Seasonal menus shift – dishes & pricing may change before PDFs are published.</p>
    </div>
  </section>
  <section class="lm-downloads" aria-labelledby="dl-heading">
    <div class="narrow-wrap">
      <h2 id="dl-heading">PDF / Static Menus</h2>
      <p class="lead-note">Provide downloadable menus here later (A La Carte, Dessert, Vegan, Beverages). For now, explore live sections on our Menu page.</p>
      <ul class="bullet-list small">
        <li><strong>Hours (placeholder):</strong> All venues open 7 days lunch & dinner.</li>
        <li>Public holiday surcharge may apply.</li>
      </ul>
      <div class="cta-row"><a href="menu.php" class="btn alt-btn">Full Menu Experience</a><a href="group-bookings.php" class="btn hollow-btn">Group Packages</a></div>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
