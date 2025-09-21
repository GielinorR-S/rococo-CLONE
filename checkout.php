<?php
$pageTitle = 'Checkout';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/products.php';
require_once __DIR__ . '/includes/orders.php';
$location = normalize_location_slug($_GET['location'] ?? 'stkilda') ?: 'stkilda';
$orderPlacedId = null;
if($_SERVER['REQUEST_METHOD']==='POST'){
  // Basic validation
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $notes = trim($_POST['notes'] ?? '');
  $items = cart_items();
  $totals = cart_totals();
  if($name && $email && $phone && !empty($items)) {
      $orderId = create_order([
        'name'=>$name,
        'email'=>$email,
        'phone'=>$phone,
        'notes'=>$notes
      ], $location, $items, $totals);
      if($orderId){
          // Clear cart
          $_SESSION['cart'] = [];
          header('Location: order-confirmation.php?id='.(int)$orderId);
          exit;
      }
  } else {
      $error = 'Please complete required fields and ensure cart not empty.';
  }
}
$items = cart_items();
$totals = cart_totals();
?>
<section class="checkout-hero std-hero">
  <div class="std-hero-inner">
    <h1>Checkout</h1>
    <p class="tagline">Review your order and provide details. Payment (Stripe) integration coming soon.</p>
  </div>
</section>
<section class="checkout-main">
  <div class="checkout-inner">
    <div class="co-left">
      <h2 class="section-sub">Your Order</h2>
      <?php if(empty($items)): ?>
        <p>Your cart is empty. <a href="shop.php">Return to shop</a></p>
      <?php else: ?>
        <ul class="co-lines">
        <?php foreach($items as $line): ?>
          <li>
            <span class="nm"><?php echo htmlspecialchars($line['name']); ?> × <?php echo (int)$line['quantity']; ?></span>
            <span class="amt"><?php echo money($line['line_total']); ?></span>
          </li>
        <?php endforeach; ?>
        </ul>
        <div class="co-totals">
          <div class="row"><span>Subtotal</span><strong><?php echo money($totals['subtotal']); ?></strong></div>
          <div class="row"><span>Tax</span><strong><?php echo money($totals['tax']); ?></strong></div>
          <div class="row grand"><span>Total</span><strong><?php echo money($totals['total']); ?></strong></div>
        </div>
      <?php endif; ?>
    </div>
    <div class="co-right">
      <h2 class="section-sub">Details</h2>
      <form class="checkout-form" method="post" action="checkout.php?location=<?php echo urlencode($location); ?>">
        <?php if(!empty($error)): ?><div class="cart-alert" role="alert" style="margin-bottom:1rem;"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <div class="form-row">
          <label for="co-name">Full Name</label>
          <input id="co-name" name="name" required type="text" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" />
        </div>
        <div class="form-row">
          <label for="co-email">Email</label>
          <input id="co-email" name="email" required type="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
        </div>
        <div class="form-row">
          <label for="co-phone">Phone</label>
          <input id="co-phone" name="phone" required type="text" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" />
        </div>
        <div class="form-row full">
          <label for="co-notes">Order Notes (optional)</label>
          <textarea id="co-notes" name="notes" rows="4"><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
        </div>
        <div class="form-row full">
          <p class="micro-note">Stripe secure payment form will appear here in final phase.</p>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn" <?php echo empty($items)?'disabled':''; ?>>Place Order (Demo)</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>