
<?php
$pageTitle = "Rococo | Menu";
include __DIR__ . '/includes/header.php';

$menu = [
	'Antipasti' => [
		['name' => 'Bruschetta', 'desc' => 'Grilled bread topped with fresh tomatoes, garlic, basil, and olive oil.', 'price' => '$12', 'img' => 'assets/images/dummy.png'],
		['name' => 'Arancini', 'desc' => 'Crispy risotto balls with mozzarella and herbs.', 'price' => '$14', 'img' => 'assets/images/dummy.png'],
	],
	'Pasta' => [
		['name' => 'Spaghetti Carbonara', 'desc' => 'Classic Roman pasta with pancetta, egg, pecorino cheese, and black pepper.', 'price' => '$22', 'img' => 'assets/images/dummy.png'],
		['name' => 'Lasagna', 'desc' => 'Layers of pasta, beef ragu, béchamel, and parmesan.', 'price' => '$24', 'img' => 'assets/images/dummy.png'],
	],
	'Pizza' => [
		['name' => 'Margherita Pizza', 'desc' => 'Wood-fired pizza with tomato, mozzarella, and fresh basil.', 'price' => '$20', 'img' => 'assets/images/dummy.png'],
		['name' => 'Diavola', 'desc' => 'Spicy salami, tomato, mozzarella, and chili.', 'price' => '$22', 'img' => 'assets/images/dummy.png'],
	],
	'Desserts' => [
		['name' => 'Tiramisu', 'desc' => 'Traditional Italian dessert with coffee-soaked ladyfingers and mascarpone cream.', 'price' => '$10', 'img' => 'assets/images/dummy.png'],
		['name' => 'Panna Cotta', 'desc' => 'Vanilla bean panna cotta with berry coulis.', 'price' => '$11', 'img' => 'assets/images/dummy.png'],
	],
	'Wine & Bar' => [
		['name' => 'Chianti', 'desc' => 'Classic Tuscan red wine.', 'price' => '$9/glass', 'img' => 'assets/images/dummy.png'],
		['name' => 'Negroni', 'desc' => 'Gin, Campari, and sweet vermouth.', 'price' => '$15', 'img' => 'assets/images/dummy.png'],
	],
];

$activeCategory = isset($_GET['category']) ? $_GET['category'] : 'Antipasti';
?>
<main>
	<section class="menu-section">
		<div class="container">
			<h1 class="section-heading">Our Menu</h1>
			<div class="menu-categories">
				<?php foreach ($menu as $category => $items): ?>
					<a href="?category=<?php echo urlencode($category); ?>" class="btn btn-outline<?php echo ($activeCategory == $category) ? ' active' : ''; ?>"><?php echo htmlspecialchars($category); ?></a>
				<?php endforeach; ?>
			</div>
			<div class="menu-items">
				<?php foreach ($menu[$activeCategory] as $item): ?>
					<div class="menu-item">
						<img src="<?php echo $item['img']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
						<h3><?php echo htmlspecialchars($item['name']); ?></h3>
						<p><?php echo htmlspecialchars($item['desc']); ?></p>
						<span class="menu-price"><?php echo htmlspecialchars($item['price']); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
