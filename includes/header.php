
<?php
if (!isset($pageTitle)) {
    $pageTitle = "Rococo";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/index.php">Rococo</a>
            </div>
            <ul class="nav-links">
                <li><a href="/index.php">Home</a></li>
                <li><a href="/booking.php">Book Now</a></li>
                <li><a href="/delivery-takeaway.php">Delivery & Takeaway</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Locations & Menus</a>
                    <div class="dropdown-content">
                        <a href="/rococo-st-kilda.php">St Kilda</a>
                        <a href="/rococo-hawthorn.php">Hawthorn</a>
                        <a href="/rococo-point-cook.php">Point Cook</a>
                        <a href="/rococo-mordialloc.php">Mordialloc</a>
                    </div>
                </li>
                <li><a href="/group-bookings.php">Group Bookings (10+)</a></li>
                <li><a href="/gift-vouchers.php">Gift Vouchers</a></li>
                <li><a href="/employment.php">Employment</a></li>
                <li><a href="/contact.php">Contact Us</a></li>
            </ul>
            <div class="nav-btn">
                <a href="/booking.php" class="btn btn-primary">Book a Table</a>
            </div>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>
