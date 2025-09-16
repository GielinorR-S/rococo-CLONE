
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
                <li><a href="/index.php" class="<?php echo ($pageTitle == 'Rococo | Home') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="/menu.php" class="<?php echo ($pageTitle == 'Rococo | Menu') ? 'active' : ''; ?>">Menu</a></li>
                <li><a href="/functions.php" class="<?php echo ($pageTitle == 'Rococo | Functions') ? 'active' : ''; ?>">Functions</a></li>
                <li><a href="/our-story.php" class="<?php echo ($pageTitle == 'Rococo | Our Story') ? 'active' : ''; ?>">Our Story</a></li>
                <li><a href="/contact.php" class="<?php echo ($pageTitle == 'Rococo | Contact') ? 'active' : ''; ?>">Contact</a></li>
            </ul>
            <div class="nav-btn">
                <a href="/index.php#booking" class="btn btn-primary">Book a Table</a>
            </div>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>
