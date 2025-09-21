<?php
ob_start(); // Start output buffering
session_start(); // Start a session for user messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rocco | <?php echo isset($pageTitle) ? $pageTitle : 'Modern Italian Restaurant'; ?></title>
    <meta name="description" content="Modern Italian Restaurant & Bar. Experience the finest Italian cuisine in an elegant setting.">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<?php $isHome = basename($_SERVER['PHP_SELF']) === 'index.php'; ?>
<body class="<?php echo $isHome ? 'home' : ''; ?>">
    <?php /* $isHome available for conditional styling */ ?>
    <!-- Removed conditional transparent class so header is solid from top (previously added 'header-transparent' on home) -->
    <header class="site-header">
        <div class="container">
            <nav class="navbar">
                <div class="header-flex">
                    <div class="header-inner">
                        <div class="hamburger" id="hamburger-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="logo">
                            <a href="index.php">R&nbsp;O&nbsp;C&nbsp;C&nbsp;O</a>
                        </div>
                    </div>
                </div>
                <div class="popup-menu-overlay" id="popup-menu-overlay"></div>
                <div class="popup-menu" id="popup-menu">
                    <button class="close-btn" id="close-menu" style="display:none;">&times;</button>
                    <ul>
                        <li><a href="index.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">Home</a></li>
                        <li><a href="booking.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'booking.php') echo 'active'; ?>">Book Now</a></li>
                        <li class="has-sub <?php if (basename($_SERVER['PHP_SELF']) == 'delivery-takeaway.php') echo 'current-parent'; ?>">
                            <a href="delivery-takeaway.php" class="nav-parent <?php if (basename($_SERVER['PHP_SELF']) == 'delivery-takeaway.php') echo 'active'; ?>" aria-expanded="false">Delivery &amp; Takeaway</a>
                            <div class="sub-menu-wrapper" aria-hidden="true">
                                <ul class="sub-menu" aria-label="Delivery venues">
                                    <li><a href="shop.php?location=stkilda">St Kilda</a></li>
                                    <li><a href="shop.php?location=hawthorn">Hawthorn</a></li>
                                    <li><a href="shop.php?location=pointcook">Point Cook</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="has-sub <?php if (basename($_SERVER['PHP_SELF']) == 'locations-menus.php') echo 'current-parent'; ?>">
                            <a href="locations-menus.php" class="nav-parent <?php if (basename($_SERVER['PHP_SELF']) == 'locations-menus.php') echo 'active'; ?>" aria-expanded="false">Locations &amp; Menus</a>
                            <div class="sub-menu-wrapper" aria-hidden="true">
                                <ul class="sub-menu" aria-label="Locations list">
                                    <li><a href="locations-menus.php#loc-stk">St Kilda</a></li>
                                    <li><a href="locations-menus.php#loc-haw">Hawthorn</a></li>
                                    <li><a href="locations-menus.php#loc-pc">Point Cook</a></li>
                                    <li><a href="locations-menus.php#loc-mod">Mordialloc</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="group-bookings.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'group-bookings.php') echo 'active'; ?>">Group Bookings (10+)</a></li>
                        <li><a href="gift-vouchers.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'gift-vouchers.php') echo 'active'; ?>">Gift Vouchers</a></li>
                        <li><a href="employment.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'employment.php') echo 'active'; ?>">Employment</a></li>
                        <li><a href="contact.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'active'; ?>">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
    <!-- Removed duplicate stray closing main tags -->
<script>
// Pop-up menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger-menu');
    const popupMenu = document.getElementById('popup-menu');
    const popupMenuOverlay = document.getElementById('popup-menu-overlay');
    const closeMenuBtn = document.getElementById('close-menu');

    // Hide menu and overlay by default
    popupMenu.classList.remove('show');
    popupMenuOverlay.classList.remove('show');
    closeMenuBtn.style.display = 'none';

    hamburger.addEventListener('click', function() {
        popupMenu.classList.add('show');
        popupMenuOverlay.classList.add('show');
        closeMenuBtn.style.display = 'block';
    });

    closeMenuBtn.addEventListener('click', function() {
        popupMenu.classList.remove('show');
        popupMenuOverlay.classList.remove('show');
        closeMenuBtn.style.display = 'none';
    });

    popupMenuOverlay.addEventListener('click', function() {
        popupMenu.classList.remove('show');
        popupMenuOverlay.classList.remove('show');
        closeMenuBtn.style.display = 'none';
    });
});
// Transparent scroll effect removed (header now solid from load). To restore:
// 1) Add class "header-transparent" to <header> on home.
// 2) Re-enable scroll listener below.
/*
window.addEventListener('scroll', function() {
    const header = document.querySelector('.site-header');
    if(!header) return;
    if (window.scrollY > 60) header.classList.add('scrolled');
    else header.classList.remove('scrolled');
});
*/
</script>
<script>
// Submenu toggle logic (first click expands, second click navigates)
document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById('popup-menu');
    if(!menu) return;
    const parentLinks = menu.querySelectorAll('.has-sub > a.nav-parent');

    function closeAll(except){
        menu.querySelectorAll('.has-sub.open').forEach(li => {
            if(li === except) return;
            li.classList.remove('open');
            const wrap = li.querySelector('.sub-menu-wrapper');
            const trigger = li.querySelector('a.nav-parent');
            if(wrap){ wrap.style.maxHeight = null; wrap.setAttribute('aria-hidden','true'); }
            if(trigger){ trigger.setAttribute('aria-expanded','false'); }
        });
    }

    parentLinks.forEach(link => {
        link.addEventListener('click', function(e){
            const li = link.parentElement;
            const open = li.classList.contains('open');
            if(!open){
                e.preventDefault();
                closeAll(li);
                li.classList.add('open');
                const wrap = li.querySelector('.sub-menu-wrapper');
                if(wrap){
                    wrap.style.maxHeight = wrap.scrollHeight + 'px';
                    wrap.setAttribute('aria-hidden','false');
                }
                link.setAttribute('aria-expanded','true');
            } else {
                // Toggle closed instead of navigating
                e.preventDefault();
                li.classList.remove('open');
                const wrap = li.querySelector('.sub-menu-wrapper');
                if(wrap){
                    wrap.style.maxHeight = null;
                    wrap.setAttribute('aria-hidden','true');
                }
                link.setAttribute('aria-expanded','false');
            }
        });
    });

    document.addEventListener('keydown', function(ev){ if(ev.key === 'Escape') closeAll(); });
});
</script>
        </div>
    </header>
    <main>