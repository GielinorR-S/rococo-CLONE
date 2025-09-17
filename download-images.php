<?php
// Image downloader script for Rocco website
$images = [
    'hero-bg.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-interior-1.jpg',
    'menu-hero.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-hero-1.jpg',
    'contact-hero.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-interior-2.jpg',
    'functions-hero.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-interior-3.jpg',
    'story-hero.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-hero-2.jpg',
    'pasta-1.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-pasta-1.jpg',
    'antipasti-1.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-antipasti-1.jpg',
    'dessert-1.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-dessert-1.jpg',
    'main-1.jpg' => 'https://www.rococo.net.au/wp-content/uploads/2023/05/rococo-main-1.jpg',
];

// Create images directory if it doesn't exist
if (!file_exists('assets/images')) {
    mkdir('assets/images', 0777, true);
}

foreach ($images as $filename => $url) {
    $path = 'assets/images/' . $filename;
    
    if (!file_exists($path)) {
        $imageData = @file_get_contents($url);
        if ($imageData) {
            file_put_contents($path, $imageData);
            echo "Downloaded: $filename<br>";
        } else {
            echo "Failed to download: $filename<br>";
        }
    } else {
        echo "Already exists: $filename<br>";
    }
}

echo "Image download process complete!";
?>