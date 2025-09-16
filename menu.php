<?php
$pageTitle = "Rococo | Menu";
include __DIR__ . '/includes/header.php';
?>
<main>
	<section class="menu-section">
		<div class="container">
			<h1 class="section-heading">Our Menu</h1>
			<div class="menu-categories">
				<button class="btn btn-outline">Antipasti</button>
				<button class="btn btn-outline">Pasta</button>
				<button class="btn btn-outline">Pizza</button>
				<button class="btn btn-outline">Desserts</button>
				<button class="btn btn-outline">Wine &amp; Bar</button>
			</div>
			<div class="menu-items">
				<div class="menu-item">
					<img src="assets/images/dummy.png" alt="Bruschetta">
					<h3>Bruschetta</h3>
					<p>Grilled bread topped with fresh tomatoes, garlic, basil, and olive oil.</p>
					<span class="menu-price">$12</span>
				</div>
				<div class="menu-item">
					<img src="assets/images/dummy.png" alt="Spaghetti Carbonara">
					<h3>Spaghetti Carbonara</h3>
					<p>Classic Roman pasta with pancetta, egg, pecorino cheese, and black pepper.</p>
					<span class="menu-price">$22</span>
				</div>
				<div class="menu-item">
					<img src="assets/images/dummy.png" alt="Margherita Pizza">
					<h3>Margherita Pizza</h3>
					<p>Wood-fired pizza with tomato, mozzarella, and fresh basil.</p>
					<span class="menu-price">$20</span>
				</div>
				<div class="menu-item">
					<img src="assets/images/dummy.png" alt="Tiramisu">
					<h3>Tiramisu</h3>
					<p>Traditional Italian dessert with coffee-soaked ladyfingers and mascarpone cream.</p>
					<span class="menu-price">$10</span>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>
