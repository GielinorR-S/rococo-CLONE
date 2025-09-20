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
                        <li><a href="menu.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'menu.php') echo 'active'; ?>">Menu</a></li>
                        <li><a href="functions.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'functions.php') echo 'active'; ?>">Functions</a></li>
                        <li><a href="our-story.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'our-story.php') echo 'active'; ?>">Our Story</a></li>
                        <li><a href="contact.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'active'; ?>">Contact</a></li>
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
        </div>
    </header>
    <main>