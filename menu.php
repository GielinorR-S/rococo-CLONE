<?php
$pageTitle = "Menu";
include 'includes/header.php';
?>

<section class="menu-hero" aria-labelledby="menu-heading">
    <div class="menu-hero-inner">
        <h1 id="menu-heading">Our Menu</h1>
        <p class="tagline">Seasonal modern Italian crafted with care. Ingredients first – technique always.</p>
        <nav class="menu-jump" aria-label="Jump to category">
            <a href="#antipasti">Antipasti</a>
            <a href="#pasta">Pasta</a>
            <a href="#mains">Mains</a>
            <a href="#desserts">Desserts</a>
            <a href="#drinks">Drinks</a>
        </nav>
    </div>
</section>

<section class="menu-sections" aria-label="Menu categories">
    <!-- Antipasti -->
    <div class="menu-category" id="antipasti">
        <div class="category-header">
            <h2>Antipasti</h2>
            <p class="category-desc">Small plates to awaken the palate &ndash; perfect to share.</p>
        </div>
        <div class="item-grid">
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=600&q=70" alt="Bruschetta with tomatoes and basil"></figure>
                <div class="item-body">
                    <h3>Bruschetta Classica <span class="price">12</span></h3>
                    <p>Grilled bread, vine tomato, cold-pressed olive oil, basil.</p>
                </div>
            </article>
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1589301760014-d929f3979dbc?auto=format&fit=crop&w=600&q=70" alt="Antipasto platter with cured meats"></figure>
                <div class="item-body">
                    <h3>Antipasto della Casa <span class="price">18</span></h3>
                    <p>Chef's selection of cured meats, cheeses, marinated vegetables.</p>
                </div>
            </article>
        </div>
    </div>

    <!-- Pasta -->
    <div class="menu-category" id="pasta">
        <div class="category-header">
            <h2>Pasta</h2>
            <p class="category-desc">Hand-finished with regionally inspired sauces.</p>
        </div>
        <div class="item-grid">
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1521389508051-d7ffb5dc8d61?auto=format&fit=crop&w=600&q=70" alt="Spaghetti Carbonara"></figure>
                <div class="item-body">
                    <h3>Spaghetti Carbonara <span class="price">16</span></h3>
                    <p>Free-range egg yolk emulsion, pancetta, pecorino, cracked pepper.</p>
                </div>
            </article>
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1601314163564-3a244d60c4d0?auto=format&fit=crop&w=600&q=70" alt="Fettuccine Alfredo"></figure>
                <div class="item-body">
                    <h3>Fettuccine Alfredo <span class="price">17</span></h3>
                    <p>Silky parmesan cream, fresh cracked pepper, butter gloss.</p>
                </div>
            </article>
        </div>
    </div>

    <!-- Mains -->
    <div class="menu-category" id="mains">
        <div class="category-header">
            <h2>Main Courses</h2>
            <p class="category-desc">Hearty signatures &ndash; slow, caramelised, fire kissed.</p>
        </div>
        <div class="item-grid">
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=600&q=70" alt="Osso Buco with saffron risotto"></figure>
                <div class="item-body">
                    <h3>Osso Buco <span class="price">28</span></h3>
                    <p>Braised veal shank, saffron risotto, gremolata finish.</p>
                </div>
            </article>
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1603899123170-42941d39d7aa?auto=format&fit=crop&w=600&q=70" alt="Saltimbocca alla Romana"></figure>
                <div class="item-body">
                    <h3>Saltimbocca alla Romana <span class="price">26</span></h3>
                    <p>Veal, prosciutto, sage, white wine reduction, butter glaze.</p>
                </div>
            </article>
        </div>
    </div>

    <!-- Desserts -->
    <div class="menu-category" id="desserts">
        <div class="category-header">
            <h2>Desserts</h2>
            <p class="category-desc">Classics that close the experience properly.</p>
        </div>
        <div class="item-grid">
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1600891963935-c9e3d745b218?auto=format&fit=crop&w=600&q=70" alt="Tiramisu dessert"></figure>
                <div class="item-body">
                    <h3>Tiramisu <span class="price">10</span></h3>
                    <p>Espresso soaked savoiardi, mascarpone, dark cocoa dust.</p>
                </div>
            </article>
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1601979031925-424e53b6caaa?auto=format&fit=crop&w=600&q=70" alt="Panna cotta with berries"></figure>
                <div class="item-body">
                    <h3>Panna Cotta <span class="price">9</span></h3>
                    <p>Vanilla bean cream set delicately, seasonal berry compote.</p>
                </div>
            </article>
        </div>
    </div>

    <!-- Drinks -->
    <div class="menu-category" id="drinks">
        <div class="category-header">
            <h2>Drinks</h2>
            <p class="category-desc">A curated list to complement every plate.</p>
        </div>
        <div class="item-grid">
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1598514982846-246368fb98a6?auto=format&fit=crop&w=600&q=70" alt="Glass of red wine"></figure>
                <div class="item-body">
                    <h3>House Red <span class="price">11</span></h3>
                    <p>Medium-bodied, soft tannins, cherry & spice notes.</p>
                </div>
            </article>
            <article class="menu-item">
                <figure class="item-media"><img src="https://images.unsplash.com/photo-1613470208960-72f0669c3b51?auto=format&fit=crop&w=600&q=70" alt="Negroni cocktail"></figure>
                <div class="item-body">
                    <h3>Classic Negroni <span class="price">18</span></h3>
                    <p>Equal parts gin, bitter apéritif, sweet vermouth, orange twist.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>