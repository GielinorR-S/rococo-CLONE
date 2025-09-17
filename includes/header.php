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
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php">Rocco</a>
                </div>
                <ul class="nav-links">
                    <li><a href="index.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>">Home</a></li>
                    <li><a href="menu.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'menu.php') echo 'active'; ?>">Menu</a></li>
                    <li><a href="functions.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'functions.php') echo 'active'; ?>">Functions</a></li>
                    <li><a href="our-story.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'our-story.php') echo 'active'; ?>">Our Story</a></li>
                    <li><a href="contact.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'contact.php') echo 'active'; ?>">Contact</a></li>
                </ul>
                <div class="nav-cta">
                    <a href="index.php#booking" class="btn btn-primary">Book a Table</a>
                </div>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>
    <main>