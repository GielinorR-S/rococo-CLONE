<?php
$pageTitle = "Employment";
include 'includes/header.php';
?>
<main class="emp-page" id="main-content" tabindex="-1">
  <section class="std-hero emp-hero" aria-labelledby="emp-hero-heading">
    <div class="std-hero-inner">
      <h1 id="emp-hero-heading">Employment</h1>
      <p class="tagline">Join a hospitality team that values craft, warmth, and growth.</p>
    </div>
  </section>
  <section class="emp-intro" aria-labelledby="emp-intro-heading">
    <div class="narrow-wrap">
      <h2 id="emp-intro-heading">Working With Us</h2>
      <p>We look for curiosity, consistency, and genuine care. Whether you thrive on the floor, in the kitchen, or behind the bar, we develop people who elevate guest experience through attention and integrity.</p>
      <ul class="bullet-list small">
        <li><strong>Craft:</strong> We refine fundamentals daily.</li>
        <li><strong>Team:</strong> No stars – collective hospitality wins.</li>
        <li><strong>Growth:</strong> Clear pathways & feedback culture.</li>
      </ul>
      <div class="role-grid">
        <article class="role-card"><h3>Front of House</h3><p>Service, reservations, bar, hosts. Training & pathways.</p></article>
        <article class="role-card"><h3>Kitchen</h3><p>Pasta, wood‑fire, cold larder, pastry. Respect for produce.</p></article>
        <article class="role-card"><h3>Leadership</h3><p>Floor leads, sous chefs, venue management & ops support.</p></article>
      </div>
    </div>
  </section>
  <section class="emp-apply" aria-labelledby="apply-heading">
    <div class="narrow-wrap">
      <h2 id="apply-heading">Apply / Introduce Yourself</h2>
      <p>Send a concise introduction, availability, and recent experience. Formal CV optional at early stage.</p>
      <form action="#" method="POST" class="apply-form" novalidate>
  <div class="form-row"><label class="visually-hidden" for="app-name">Name</label><input id="app-name" name="name" type="text" placeholder="Name" required></div>
  <div class="form-row"><label class="visually-hidden" for="app-email">Email</label><input id="app-email" name="email" type="email" placeholder="Email" required></div>
  <div class="form-row"><label class="visually-hidden" for="app-role">Role Interest</label><input id="app-role" name="role" type="text" placeholder="Role Interest"></div>
  <div class="form-row full"><label class="visually-hidden" for="app-msg">Message</label><textarea id="app-msg" name="message" placeholder="Message" required></textarea></div>
        <div class="form-actions full"><button type="submit" class="btn alt-btn">Submit</button></div>
      </form>
      <p class="micro-note">This form is a placeholder. Implement processing & validation logic before production.</p>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>
