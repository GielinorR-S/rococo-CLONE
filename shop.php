<?php
$pageTitle = 'Order Online';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/products.php';
require_once __DIR__ . '/includes/shop_ui.php';

// Determine location (slug)
$location = normalize_location_slug($_GET['location'] ?? 'stkilda');
if(!$location){
    // fallback default
    $location = 'stkilda';
}

// Actions: add/update/remove cart via POST (progressive enhancement; JS later)
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if($action === 'add') {
        $pid = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['qty'] ?? 1);
    if($pid > 0) {
      $product = get_product($pid);
      cart_add($pid, $qty);
      if($product) {
        $_SESSION['cart_notice'] = $qty . ' × ' . $product['name'] . ' added to cart.';
      } else {
        $_SESSION['cart_notice'] = 'Item added to cart.';
      }
    }
        header('Location: shop.php?location=' . urlencode($location) . '#cart');
        exit;
    } elseif($action === 'update') {
        foreach(($_POST['qty'] ?? []) as $pid => $q){
            cart_update((int)$pid, (int)$q);
        }
    $_SESSION['cart_notice'] = 'Cart updated.';
        header('Location: shop.php?location=' . urlencode($location) . '#cart');
        exit;
    } elseif($action === 'remove') {
        $pid = (int)($_POST['product_id'] ?? 0);
    if($pid) {
      $product = get_product($pid);
      cart_remove($pid);
      if($product) {
        $_SESSION['cart_notice'] = $product['name'] . ' removed from cart.';
      } else {
        $_SESSION['cart_notice'] = 'Item removed from cart.';
      }
    }
        header('Location: shop.php?location=' . urlencode($location) . '#cart');
        exit;
    } elseif($action === 'clear_cart') {
        // Clear all items
        cart_init();
        $_SESSION['cart'] = [];
        $_SESSION['cart_notice'] = 'Cart cleared.';
        header('Location: shop.php?location=' . urlencode($location) . '#cart');
        exit;
    }
}

$categories = get_categories_for_location($location);
$selectedCat = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
if($selectedCat && !in_array($selectedCat, array_column($categories,'id'))) {
    $selectedCat = null; // invalid cat for location
}
$products = get_products($location, $selectedCat);
$locLabel = get_location_label($location);

$cartItems = cart_items();
$totals = cart_totals();
?>
<section class="shop-hero std-hero">
  <div class="std-hero-inner">
    <h1><?php echo htmlspecialchars($locLabel); ?> Online Ordering</h1>
    <p class="tagline">Order your favourites from <?php echo htmlspecialchars($locLabel); ?>. Choose a category, add items to your cart, and proceed to checkout. (Stripe integration coming soon).</p>
    <nav class="shop-location-switch" aria-label="Change location">
      <?php foreach(get_shop_locations() as $slug => $label): ?>
        <a class="loc-pill <?php if($slug === $location) echo 'active'; ?>" href="shop.php?location=<?php echo urlencode($slug); ?>"><?php echo htmlspecialchars($label); ?></a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>

<section class="shop-main" id="shop">
  <div class="shop-inner">
     <?php render_shop_sidebar($location, $categories, $selectedCat); ?>
     <div class="shop-content">
    <?php if($selectedCat){
      foreach($categories as $c){ if($c['id']===$selectedCat){ echo '<h2 class="current-cat-heading">'.htmlspecialchars($c['name']).'</h2>'; break; } }
    } ?>
        <?php if(empty($products)): ?>
            <p class="empty-state">No products found for this selection.</p>
        <?php else: ?>
        <div class="product-grid">
          <?php foreach($products as $p): ?>
            <article class="product-card">
              <div class="product-media">
                <?php
                  $img = $p['image_url'];
                  if(empty($img)) { $img = product_fallback_image($p['name']); }
                ?>
                <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($p['name']); ?> image" loading="lazy"/>
              </div>
              <div class="product-body">
                <h3 class="product-title">
                  <span class="name"><?php echo htmlspecialchars($p['name']); ?></span>
                  <span class="price"><?php echo money($p['price']); ?></span>
                </h3>
                <?php if(!empty($p['description'])): ?><p class="desc"><?php echo htmlspecialchars($p['description']); ?></p><?php endif; ?>
                <form method="post" class="add-form" data-product-id="<?php echo $p['id']; ?>">
                  <input type="hidden" name="action" value="add" />
                  <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>" />
                  <div class="qty-wrapper" data-qty-wrapper>
                    <button type="button" class="qty-btn minus" aria-label="Decrease quantity" data-step="-1">−</button>
                    <label class="visually-hidden" for="qty-<?php echo $p['id']; ?>">Quantity</label>
                    <input id="qty-<?php echo $p['id']; ?>" type="number" min="1" value="1" name="qty" class="qty-input" />
                    <button type="button" class="qty-btn plus" aria-label="Increase quantity" data-step="1">+</button>
                  </div>
                  <button class="btn add-btn" type="submit">Add</button>
                </form>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
     </div>
    <aside class="cart-panel" id="cart" aria-label="Cart" tabindex="-1">
        <h2 class="cart-heading">Your Cart</h2>
      <?php if(isset($_SESSION['cart_notice'])): $msg = $_SESSION['cart_notice']; unset($_SESSION['cart_notice']); ?>
        <div class="cart-alert" role="status" aria-live="polite"><?php echo htmlspecialchars($msg); ?></div>
      <?php endif; ?>
        <?php if(empty($cartItems)): ?>
           <p class="cart-empty">Cart is empty.</p>
        <?php else: ?>
          <form method="post" class="cart-form">
            <input type="hidden" name="action" value="update" />
            <ul class="cart-lines">
              <?php foreach($cartItems as $line): ?>
                <li class="cart-line" data-product-id="<?php echo $line['id']; ?>">
                  <div class="cl-main">
                    <span class="cl-name"><?php echo htmlspecialchars($line['name']); ?></span>
                    <span class="cl-price"><?php echo money($line['price']); ?></span>
                  </div>
                  <div class="cl-actions">
                    <div class="qty-wrapper" data-qty-wrapper>
                      <button type="button" class="qty-btn minus" aria-label="Decrease quantity" data-step="-1">−</button>
                      <label class="visually-hidden" for="clqty-<?php echo $line['id']; ?>">Qty for <?php echo htmlspecialchars($line['name']); ?></label>
                      <input id="clqty-<?php echo $line['id']; ?>" name="qty[<?php echo $line['id']; ?>]" type="number" min="0" value="<?php echo (int)$line['quantity']; ?>" />
                      <button type="button" class="qty-btn plus" aria-label="Increase quantity" data-step="1">+</button>
                    </div>
                    <button form="remove-line-<?php echo $line['id']; ?>" class="remove-btn" type="submit" aria-label="Remove <?php echo htmlspecialchars($line['name']); ?>">×</button>
                  </div>
                  <div class="cl-total"><?php echo money($line['line_total']); ?></div>
                </li>
              <?php endforeach; ?>
            </ul>
            <div class="cart-summary">
              <div class="row"><span>Subtotal</span><strong><?php echo money($totals['subtotal']); ?></strong></div>
              <div class="row"><span>Tax</span><strong><?php echo money($totals['tax']); ?></strong></div>
              <div class="row total"><span>Total</span><strong><?php echo money($totals['total']); ?></strong></div>
            </div>
            <div class="cart-actions">
              <button type="submit" class="btn small">Update</button>
              <a href="checkout.php" class="btn alt-btn small">Checkout</a>
              <button form="clear-cart-form" type="submit" class="btn danger-btn small">Clear Cart</button>
            </div>
          </form>
          <?php foreach($cartItems as $line): ?>
            <form id="remove-line-<?php echo $line['id']; ?>" method="post" class="inline-form visually-hidden" aria-hidden="true">
              <input type="hidden" name="action" value="remove" />
              <input type="hidden" name="product_id" value="<?php echo $line['id']; ?>" />
            </form>
          <?php endforeach; ?>
          <form id="clear-cart-form" method="post" class="inline-form visually-hidden" aria-hidden="true" onsubmit="return confirm('Clear all items from cart?');">
              <input type="hidden" name="action" value="clear_cart" />
          </form>
        <?php endif; ?>
     </aside>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>