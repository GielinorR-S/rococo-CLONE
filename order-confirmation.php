<?php
$pageTitle = 'Order Confirmation';
require_once __DIR__.'/includes/header.php';
require_once __DIR__.'/includes/orders.php';
require_once __DIR__.'/includes/products.php';
$orderId = (int)($_GET['id'] ?? 0);
$order = $orderId ? get_order($orderId) : null;
?>
<section class="std-hero">
  <div class="std-hero-inner">
    <h1>Order Confirmation</h1>
    <?php if($order): ?>
      <p class="tagline">Thank you, <?php echo htmlspecialchars($order['customer_name']); ?>. Your order has been received.</p>
    <?php else: ?>
      <p class="tagline">Order not found.</p>
    <?php endif; ?>
  </div>
</section>
<section class="checkout-main">
  <div class="checkout-inner">
    <?php if($order): ?>
      <div class="co-left">
        <h2 class="section-sub">Summary</h2>
        <ul class="co-lines">
          <?php foreach($order['items'] as $it): ?>
            <li>
              <span class="nm"><?php echo htmlspecialchars($it['product_name']); ?> × <?php echo (int)$it['quantity']; ?></span>
              <span class="amt"><?php echo money($it['line_total']); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="co-totals">
          <div class="row"><span>Subtotal</span><strong><?php echo money($order['subtotal']); ?></strong></div>
          <div class="row"><span>Tax</span><strong><?php echo money($order['tax']); ?></strong></div>
          <div class="row grand"><span>Total</span><strong><?php echo money($order['total']); ?></strong></div>
        </div>
      </div>
      <div class="co-right">
        <h2 class="section-sub">Customer</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?><br>
        <strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?><br>
        <strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?><br>
        <strong>Location:</strong> <?php echo htmlspecialchars(get_location_label($order['location_slug'])); ?><br>
        <?php if($order['notes']): ?><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($order['notes'])); ?><?php endif; ?></p>
        <p style="font-size:.75rem;color:#777;">Payment status: <strong><?php echo htmlspecialchars($order['payment_status']); ?></strong> (demo)</p>
        <p><a class="btn alt-btn" href="shop.php?location=<?php echo urlencode($order['location_slug']); ?>">Order Again</a></p>
      </div>
    <?php else: ?>
      <p><a href="shop.php">Return to shop</a></p>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__.'/includes/footer.php'; ?>