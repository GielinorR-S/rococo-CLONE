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
</div>
<!-- Hero Image Slider End -->
<!-- Overlapping Booking Bar (moved up to overlap bottom of hero) -->
<div class="hero-overlap-booking">
    <div class="fullwidth-booking-bar overlap" aria-label="Booking Bar">
        <h2 class="booking-bar-heading">Make a booking</h2>
        <form class="mid-booking-form" action="booking.php" method="GET">
            <?php $validVenues = ['st-kilda','hawthorn','point-cook','mordialloc']; ?>
            <div class="mb-field">
                <label for="mb-venue" class="visually-hidden">Restaurant</label>
                <select id="mb-venue" name="venue" required>
                    <option value="" disabled selected>Select Restaurant</option>
                    <?php foreach($validVenues as $v): ?>
                        <option value="<?php echo $v; ?>"><?php echo ucwords(str_replace('-', ' ', $v)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-field">
                <label for="mb-guests" class="visually-hidden">Guests</label>
                <select id="mb-guests" name="guests" required>
                    <?php for($g=1;$g<=20;$g++): ?>
                        <option value="<?php echo $g; ?>" <?php echo $g===2? 'selected':''; ?>><?php echo $g . ($g===1? ' Person':' People'); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-field">
                <label for="mb-date" class="visually-hidden">Date</label>
                <input type="date" id="mb-date" name="date" required>
            </div>
            <div class="mb-field">
                <label for="mb-time" class="visually-hidden">Time</label>
                <select id="mb-time" name="time" required>
                    <option value="" disabled selected>Select Time</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="12:30">12:30 PM</option>
                    <option value="13:00">1:00 PM</option>
                    <option value="13:30">1:30 PM</option>
                    <option value="14:00">2:00 PM</option>
                    <option value="14:30">2:30 PM</option>
                    <option value="15:00">3:00 PM</option>
                    <option value="15:30">3:30 PM</option>
                    <option value="16:00">4:00 PM</option>
                    <option value="16:30">4:30 PM</option>
                    <option value="17:00">5:00 PM</option>
                    <option value="17:30">5:30 PM</option>
                    <option value="18:00">6:00 PM</option>
                    <option value="18:30">6:30 PM</option>
                    <option value="19:00">7:00 PM</option>
                    <option value="19:30">7:30 PM</option>
                    <option value="20:00">8:00 PM</option>
                    <option value="20:30">8:30 PM</option>
                    <option value="21:00">9:00 PM</option>
                    <option value="21:30">9:30 PM</option>
                </select>
            </div>
            <div class="mb-field submit">
                <button type="submit" class="mb-button" aria-label="Find a Table">Find a Table</button>
            </div>
        </form>
        <p class="booking-bar-note below">To make a reservation for more than 10 people, please <a href="group-bookings.php" class="no-highlight-link">click here to book via our group booking page</a>.</p>
    </div>
</div>
<!-- End Overlapping Booking Bar -->
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

    // Redirect large parties (11+) to group bookings from mid-page booking form
    const midForm = document.querySelector('.mid-booking-form');
    if(midForm){
        midForm.addEventListener('submit', function(e){
            const guestsSel = midForm.querySelector('#mb-guests');
            const guestsVal = parseInt(guestsSel && guestsSel.value ? guestsSel.value : '0', 10);
            if(guestsVal > 10){
                e.preventDefault();
                const dateInput = midForm.querySelector('#mb-date');
                const dateParam = dateInput && dateInput.value ? '&date=' + encodeURIComponent(dateInput.value) : '';
                window.location.href = 'group-bookings.php?guests=' + guestsVal + dateParam;
            }
        });
    }
});
</script>

<!-- Venues Section (booking bar moved above overlapping hero) -->
<section class="venues-preview no-gaps" id="venues">
    <div class="container venues-container-after-bar">
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
<section class="services-split no-gaps" id="services">
    <div class="container services-grid">
        <article class="service-block take-away">
            <div class="service-media" aria-hidden="true">
                <img src="assets/images/delivery-icon.png" srcset="assets/images/delivery-icon@2x.png 2x" alt="Delivery icon" class="service-icon" loading="lazy" width="300" height="120">
            </div>
            <div class="service-inner">
                <h2>Delivery &amp; Takeaway</h2>
                <p>Enjoy our signature dishes at home. Freshly prepared, carefully packed, and delivered with care.</p>
                <a href="delivery-takeaway.php" class="btn alt-btn" aria-label="Order Delivery or Takeaway">Order Online</a>
            </div>
        </article>
        <article class="service-block gift-voucher">
            <div class="service-media" aria-hidden="true">
                <img src="assets/images/gift-voucher-icon.png" srcset="assets/images/gift-voucher-icon@2x.png 2x" alt="Gift voucher icon" class="service-icon" loading="lazy" width="300" height="120">
            </div>
            <div class="service-inner">
                <h2>Gift Vouchers</h2>
                <p>Share the experience. Digital and physical vouchers perfect for any celebration.</p>
                <a href="gift-vouchers.php" class="btn alt-btn" aria-label="Buy Gift Voucher">Buy a Voucher</a>
            </div>
        </article>
    </div>
</section>

<!-- Staggered Quote / Image Columns (flush variant) -->
<section class="story-stripe no-gaps">
    <div class="container stripe-grid alternating">
        <!-- Row 1: Photo | Chef Card -->
        <div class="stripe-row">
            <div class="stripe-item photo" style="background-image:url('https://images.unsplash.com/photo-1520201163981-8cc95007dd2a?auto=format&fit=crop&w=1000&q=70');" aria-label="Dining Room"></div>
            <div class="stripe-item quote">
                <blockquote>
                    <p>“Food is a celebration – we just set the stage for your memories.”</p>
                    <cite>&mdash; Head Chef</cite>
                </blockquote>
            </div>
        </div>
        <!-- Row 2: Founder Card | Photo -->
        <div class="stripe-row">
            <div class="stripe-item quote alt">
                <blockquote>
                    <p>“Italian dining is about connection – the table is our heart.”</p>
                    <cite>&mdash; Founder</cite>
                </blockquote>
            </div>
            <div class="stripe-item photo" style="background-image:url('https://images.unsplash.com/photo-1516100882582-96c3a05fe590?auto=format&fit=crop&w=1200&q=70');" aria-label="Bowl of Pasta"></div>
        </div>
        <!-- Row 3: Photo | Venue Manager Card -->
        <div class="stripe-row">
            <div class="stripe-item photo" style="background-image:url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=70');" aria-label="Bar Area"></div>
            <div class="stripe-item quote">
                <blockquote>
                    <p>“From morning espresso to late-night Negroni – always welcome.”</p>
                    <cite>&mdash; Venue Manager</cite>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>