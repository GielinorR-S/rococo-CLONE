<?php
$pageTitle = "Our Story";
include 'includes/header.php';
?>

<main class="story-page" id="main-content" tabindex="-1">
    <!-- Hero -->
    <section class="story-hero" aria-labelledby="story-hero-heading">
        <div class="story-hero-inner">
            <h1 id="story-hero-heading">Our Story</h1>
            <p class="tagline">Crafting memorable dining experiences rooted in authentic Italian hospitality.</p>
        </div>
    </section>

    <!-- Origin / Intro Split -->
    <section class="story-origin" aria-labelledby="origin-heading">
        <div class="origin-grid">
            <div class="origin-text">
                <h2 id="origin-heading">Where It Began</h2>
                <p>Born from a simple idea shared around a long wooden table: that food tastes better when it's unhurried, heartfelt, and shared. What started as a modest trattoria vision has evolved into a collection of warm dining rooms that celebrate the season, the grower, and the shared plate.</p>
                <p>Our team blends regional Italian traditions with a modern rhythm—hand-shaped pastas, slow-raised doughs, wood fire, cold-pressed oils, sun-grown tomatoes, and produce from growers we know by name.</p>
                <p class="lead-quote">“Great food is a conversation between time, place, and people.”</p>
                <ul class="origin-points" aria-label="Founding principles">
                    <li>Ingredient integrity first</li>
                    <li>Season-led menu evolution</li>
                    <li>Hospitality over hype</li>
                    <li>Craft, not complication</li>
                </ul>
            </div>
            <div class="origin-gallery">
                <div class="og-tile tall" style="background-image:url('https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&w=900&q=60');" aria-label="Hand shaping fresh pasta"></div>
                <div class="og-tile" style="background-image:url('https://images.unsplash.com/photo-1606491956689-2ea866880c84?auto=format&fit=crop&w=800&q=60');" aria-label="Wood fired oven glow"></div>
                <div class="og-tile" style="background-image:url('https://images.unsplash.com/photo-1528715471579-d1bcf0ba5e83?auto=format&fit=crop&w=800&q=60');" aria-label="Shared table with antipasti"></div>
                <div class="og-tile wide" style="background-image:url('https://images.unsplash.com/photo-1601312378427-8223b1c8f3e1?auto=format&fit=crop&w=1200&q=60');" aria-label="Fresh ingredients on rustic surface"></div>
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="story-timeline" aria-labelledby="timeline-heading">
        <div class="timeline-inner">
            <h2 id="timeline-heading">Chapters</h2>
            <ol class="timeline-list">
                <li>
                    <div class="tl-year">2010</div>
                    <div class="tl-body"><h3>First Service</h3><p>Our doors open with a tight 22 seat room, a single oven, and a menu handwritten each morning.</p></div>
                </li>
                <li>
                    <div class="tl-year">2013</div>
                    <div class="tl-body"><h3>Wood Fire Arrives</h3><p>Installation of the kiln-fired oven that shaped our dough program and weekend energy.</p></div>
                </li>
                <li>
                    <div class="tl-year">2017</div>
                    <div class="tl-body"><h3>Sourcing Network</h3><p>Formal partnerships with local farms & mills let seasonal specials expand.</p></div>
                </li>
                <li>
                    <div class="tl-year">2021</div>
                    <div class="tl-body"><h3>Expanded Cellar</h3><p>A curated Old World / new wave list leaning into volcanic and coastal terroirs.</p></div>
                </li>
                <li>
                    <div class="tl-year">Today</div>
                    <div class="tl-body"><h3>Still Evolving</h3><p>Menus refine weekly; the core remains: generosity, depth, and integrity on every plate.</p></div>
                </li>
            </ol>
        </div>
    </section>

    <!-- Values Cards -->
    <section class="story-values" aria-labelledby="values-heading">
        <div class="values-inner">
            <h2 id="values-heading">What Guides Us</h2>
            <div class="values-grid">
                <article class="value-card">
                    <h3>Seasonality</h3>
                    <p>We let the calendar dictate flavour, not nostalgia. Menus move with light, temperature, and tide.</p>
                </article>
                <article class="value-card">
                    <h3>Simplicity</h3>
                    <p>Four impeccable ingredients beat twelve unfocused ones. We edit relentlessly.</p>
                </article>
                <article class="value-card">
                    <h3>Craft</h3>
                    <p>Dough rested fully, sauces reduced patiently, espresso dialled precisely—quiet precision over flash.</p>
                </article>
                <article class="value-card">
                    <h3>Hospitality</h3>
                    <p>Warmth that feels like a friend’s home: anticipatory, unforced, attentive without hovering.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- Gallery / Atmosphere -->
    <section class="story-gallery" aria-labelledby="gallery-heading">
        <div class="gallery-inner">
            <h2 id="gallery-heading">Texture & Atmosphere</h2>
            <div class="gallery-mosaic" role="list" aria-label="Restaurant atmosphere images">
                <div class="gm-item large" role="listitem" style="background-image:url('https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=1200&q=60');" aria-label="Candle lit dinner table"></div>
                <div class="gm-item" role="listitem" style="background-image:url('https://images.unsplash.com/photo-1592861956120-e524fc739696?auto=format&fit=crop&w=800&q=60');" aria-label="Fresh basil and tomatoes"></div>
                <div class="gm-item vertical" role="listitem" style="background-image:url('https://images.unsplash.com/photo-1604328698692-f76ea9498e76?auto=format&fit=crop&w=900&q=60');" aria-label="Pouring a glass of red wine"></div>
                <div class="gm-item" role="listitem" style="background-image:url('https://images.unsplash.com/photo-1505253716362-afaea1d3d1af?auto=format&fit=crop&w=900&q=60');" aria-label="Chef finishing a plated dish"></div>
                <div class="gm-item wide" role="listitem" style="background-image:url('https://images.unsplash.com/photo-1534938665420-4193effeaccf?auto=format&fit=crop&w=1400&q=60');" aria-label="Rustic table setting"></div>
            </div>
        </div>
    </section>

    <!-- CTA Panel -->
    <section class="story-cta" aria-labelledby="cta-heading">
        <div class="cta-inner">
            <div class="cta-text">
                <h2 id="cta-heading">Join the Next Chapter</h2>
                <p>Whether for a lingering lunch, a late shared dinner, or your next celebration—our tables are set.</p>
            </div>
            <div class="cta-actions">
                <a href="booking.php" class="btn alt-btn">Book a Table</a>
                <a href="functions.php" class="btn hollow-btn">Plan an Event</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
