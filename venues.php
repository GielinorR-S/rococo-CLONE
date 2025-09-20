<?php
$pageTitle = "Venues";
include __DIR__ . '/includes/header.php';
?>
<main class="venues-main">
    <!-- Page Intro / Hero Heading just below nav -->
    <section class="venues-hero" aria-labelledby="venues-heading">
        <div class="inner">
            <h1 id="venues-heading">Our Venues</h1>
            <p class="intro">Four unique locations – one spirit of modern Italian hospitality.</p>
        </div>
    </section>

    <!-- Venues Blocks -->
    <section class="venues-blocks">
        <div class="venue-block" id="st-kilda">
            <div class="venue-media">
                <img src="assets/images/st-kilda-venue.jpg" alt="St Kilda restaurant interior" loading="lazy">
            </div>
            <div class="venue-content">
                <h2>St Kilda</h2>
                <p>Beachside vibrancy meets relaxed Italian dining. Morning espresso, long lunches and lively evenings a stone's throw from the shore.</p>
                <p class="address">10 Fitzroy St, St Kilda VIC 3182</p>
                <div class="actions">
                    <a href="booking.php?venue=st-kilda" class="btn alt-btn">Book St Kilda</a>
                </div>
            </div>
        </div>
        <div class="venue-block reverse" id="hawthorn">
            <div class="venue-media">
                <img src="assets/images/hawthorn-venue.jpg" alt="Hawthorn restaurant interior" loading="lazy">
            </div>
            <div class="venue-content">
                <h2>Hawthorn</h2>
                <p>Elegant yet welcoming – a hub for family gatherings, private celebrations and mid‑week catch ups in Melbourne's east.</p>
                <p class="address">797 Glenferrie Rd, Hawthorn VIC 3122</p>
                <div class="actions">
                    <a href="booking.php?venue=hawthorn" class="btn alt-btn">Book Hawthorn</a>
                </div>
            </div>
        </div>
        <div class="venue-block" id="point-cook">
            <div class="venue-media">
                <img src="assets/images/point-cook-venue.jpg" alt="Point Cook restaurant interior" loading="lazy" onerror="this.style.display='none'">
            </div>
            <div class="venue-content">
                <h2>Point Cook</h2>
                <p>Laid‑back west side energy with a focus on generous plates, seasonal produce and family‑style sharing.</p>
                <p class="address">(Update address)</p>
                <div class="actions">
                    <a href="booking.php?venue=point-cook" class="btn alt-btn">Book Point Cook</a>
                </div>
            </div>
        </div>
        <div class="venue-block reverse" id="mordialloc">
            <div class="venue-media">
                <img src="assets/images/mordialloc-venue.jpg" alt="Mordialloc restaurant interior" loading="lazy">
            </div>
            <div class="venue-content">
                <h2>Mordialloc</h2>
                <p>Coastal charm and contemporary Italian favourites – perfect for sunset dining and weekend lingering.</p>
                <p class="address">1 Main St, Mordialloc VIC 3195</p>
                <div class="actions">
                    <a href="booking.php?venue=mordialloc" class="btn alt-btn">Book Mordialloc</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
