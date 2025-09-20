<?php
$pageTitle = "Home";
include 'includes/header.php';
?>
<!-- Hero Image Slider Start -->
<div class="hero-slider">
    <button class="slider-btn left" onclick="moveSlide(-1)">&#10094;</button>
        <div class="slider-images">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" class="slider-img" alt="Pizza">
            <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=1200&q=80" class="slider-img" alt="Pasta">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" class="slider-img" alt="Random Food">
        </div>
    <button class="slider-btn right" onclick="moveSlide(1)">&#10095;</button>
    <!-- Quick Booking Bar Start -->
    <div class="quick-booking-wrapper" id="booking">
        <form class="quick-booking" action="booking.php" method="GET" aria-label="Quick Booking">
            <div class="qb-field">
                <label for="qb-venue" class="visually-hidden">Restaurant</label>
                <select id="qb-venue" name="venue" required>
                    <option value="" disabled selected>Select Restaurant</option>
                    <option value="st-kilda">St Kilda</option>
                    <option value="hawthorn">Hawthorn</option>
                    <option value="point-cook">Point Cook</option>
                    <option value="mordialloc">Mordialloc</option>
                </select>
            </div>
            <div class="qb-field">
                <label for="qb-guests" class="visually-hidden">Guests</label>
                <select id="qb-guests" name="guests" required>
                    <option value="2" selected>2 People</option>
                    <option value="1">1 Person</option>
                    <option value="3">3 People</option>
                    <option value="4">4 People</option>
                    <option value="5">5 People</option>
                    <option value="6">6 People</option>
                </select>
            </div>
            <div class="qb-field">
                <label for="qb-date" class="visually-hidden">Date</label>
                <input type="date" id="qb-date" name="date" required>
            </div>
            <div class="qb-field">
                <label for="qb-time" class="visually-hidden">Time</label>
                <input type="time" id="qb-time" name="time" required>
            </div>
            <div class="qb-field qb-submit">
                <button type="submit" class="qb-button" aria-label="Find a Table">Find a Table</button>
            </div>
        </form>
    </div>
    <!-- Quick Booking Bar End -->
</div>
<!-- Hero Image Slider End -->
<style>
.hero-slider {
    position: relative;
    width: 100vw;
    max-width: 100%;
    overflow: hidden;
    margin: 0 auto 0 auto;
    height: 900px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #222;
}
.slider-images {
    display: flex;
    transition: transform 0.5s ease;
    width: 100vw;
    height: 100%;
}
.slider-img {
    min-width: 100vw;
    height: 900px;
    object-fit: cover;
    display: block;
}
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: #fff;
    border: none;
    font-size: 2.5rem;
    padding: 0 20px;
    cursor: pointer;
    z-index: 2;
    border-radius: 5px;
    transition: background 0.2s;
}
.slider-btn.left { left: 10px; }
.slider-btn.right { right: 10px; }
.slider-btn:hover { background: rgba(0,0,0,0.8); }
</style>
<script>
let currentSlide = 0;
let images, sliderImages;

function showSlide(index) {
    if (index < 0) currentSlide = images.length - 1;
    else if (index >= images.length) currentSlide = 0;
    else currentSlide = index;
    sliderImages.style.transform = `translateX(-${currentSlide * 100}vw)`;
}

function moveSlide(direction) {
    showSlide(currentSlide + direction);
}

document.addEventListener('DOMContentLoaded', function() {
    images = document.querySelectorAll('.slider-img');
    sliderImages = document.querySelector('.slider-images');
    showSlide(0);
});
</script>

<!-- Venues Section -->
<section class="venues-preview" id="venues">
    <div class="container">
        <h2 class="section-title">Our Venues</h2>
        <div class="venues-grid">
            <article class="venue-card">
                <div class="venue-image" style="background-image:url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=70');"></div>
                <div class="venue-body">
                    <h3>St Kilda</h3>
                    <p>Beachside energy, vibrant dining and lively atmosphere all day long.</p>
                    <a href="venues.php#st-kilda" class="venue-link">Explore &rsaquo;</a>
                </div>
            </article>
            <article class="venue-card">
                <div class="venue-image" style="background-image:url('https://images.unsplash.com/photo-1508057198894-247b23fe5ade?auto=format&fit=crop&w=800&q=70');"></div>
                <div class="venue-body">
                    <h3>Hawthorn</h3>
                    <p>Classic warmth meets contemporary Italian hospitality in the east.</p>
                    <a href="venues.php#hawthorn" class="venue-link">Explore &rsaquo;</a>
                </div>
            </article>
            <article class="venue-card">
                <div class="venue-image" style="background-image:url('https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=800&q=70');"></div>
                <div class="venue-body">
                    <h3>Point Cook</h3>
                    <p>A relaxed west-side destination for family, friends and long lunches.</p>
                    <a href="venues.php#point-cook" class="venue-link">Explore &rsaquo;</a>
                </div>
            </article>
            <article class="venue-card">
                <div class="venue-image" style="background-image:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=70');"></div>
                <div class="venue-body">
                    <h3>Mordialloc</h3>
                    <p>Coastal charm and modern Italian favourites moments from the water.</p>
                    <a href="venues.php#mordialloc" class="venue-link">Explore &rsaquo;</a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Delivery & Gift Section (refined layout) -->
<section class="services-split" id="services">
    <div class="container services-grid">
        <article class="service-block take-away">
            <div class="service-media" aria-hidden="true"></div>
            <div class="service-inner">
                <h2>Delivery &amp; Takeaway</h2>
                <p>Enjoy our signature dishes at home. Freshly prepared, carefully packed, and delivered with care.</p>
                <a href="#" class="btn alt-btn" aria-label="Order Online">Order Online</a>
            </div>
        </article>
        <article class="service-block gift-voucher">
            <div class="service-media" aria-hidden="true"></div>
            <div class="service-inner">
                <h2>Gift Vouchers</h2>
                <p>Share the experience. Digital and physical vouchers perfect for any celebration.</p>
                <a href="#" class="btn alt-btn" aria-label="Buy Gift Voucher">Buy a Voucher</a>
            </div>
        </article>
    </div>
</section>

<!-- Staggered Quote / Image Columns -->
<section class="story-stripe">
    <div class="container stripe-grid">
        <!-- Row 1: left card, right photo -->
        <div class="stripe-item quote">
            <blockquote>
                <p>“Food is a celebration – we just set the stage for your memories.”</p>
                <cite>&mdash; Head Chef</cite>
            </blockquote>
        </div>
        <div class="stripe-item photo" style="background-image:url('https://images.unsplash.com/photo-1520201163981-8cc95007dd2a?auto=format&fit=crop&w=1000&q=70');" aria-label="Dining Room"></div>
        <!-- Row 2: left photo, right card -->
    <div class="stripe-item photo" style="background-image:url('https://images.unsplash.com/photo-1516100882582-96c3a05fe590?auto=format&fit=crop&w=1200&q=70');" aria-label="Bowl of Pasta"></div>
        <div class="stripe-item quote alt">
            <blockquote>
                <p>“From morning espresso to late-night Negroni – always welcome.”</p>
                <cite>&mdash; Venue Manager</cite>
            </blockquote>
        </div>
        <!-- Row 3: left card, right photo -->
        <div class="stripe-item quote">
            <blockquote>
                <p>“Italian dining is about connection – the table is our heart.”</p>
                <cite>&mdash; Founder</cite>
            </blockquote>
        </div>
        <div class="stripe-item photo" style="background-image:url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=70');" aria-label="Bar Area"></div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>