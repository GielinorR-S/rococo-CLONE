<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/includes/products.php';
$action = $_POST['action'] ?? '';
$response = ['ok'=>false,'message'=>'Invalid action'];
if($action === 'add') {
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = max(1,(int)($_POST['qty'] ?? 1));
    $p = $pid ? get_product($pid) : null;
    if($p){
        cart_add($pid,$qty);
        $response['ok']=true;
        $response['message'] = $qty.' × '.$p['name'].' added to cart.';
    } else {
        $response['message'] = 'Product not found';
    }
} elseif($action === 'remove') {
    $pid = (int)($_POST['product_id'] ?? 0);
    if($pid){ cart_remove($pid); $response=['ok'=>true,'message'=>'Item removed.']; }
} elseif($action === 'update') {
    $lines = $_POST['qty'] ?? [];
    foreach($lines as $pid=>$q){ cart_update((int)$pid,(int)$q); }
    $response=['ok'=>true,'message'=>'Cart updated.'];
} elseif($action === 'clear_cart') {
    cart_init(); $_SESSION['cart'] = []; $response=['ok'=>true,'message'=>'Cart cleared.'];
}
// Return updated cart fragment
$items = cart_items();
$totals = cart_totals();
ob_start();
if(empty($items)){
    echo '<p class="cart-empty">Cart is empty.</p>';
} else {
    echo '<form method="post" class="cart-form" data-ajax="1">';
    echo '<input type="hidden" name="action" value="update" />';
    echo '<ul class="cart-lines">';
    foreach($items as $line){
        echo '<li class="cart-line" data-product-id="'.$line['id'].'">';
        echo '<div class="cl-main"><span class="cl-name">'.htmlspecialchars($line['name']).'</span><span class="cl-price">'.money($line['price']).'</span></div>';
        echo '<div class="cl-actions">';
        echo '<label class="visually-hidden" for="clqty-'.$line['id'].'">Qty for '.htmlspecialchars($line['name']).'</label>';
        echo '<input id="clqty-'.$line['id'].'" name="qty['.$line['id'].']" type="number" min="0" value="'.(int)$line['quantity'].'" />';
        echo '<button type="button" class="remove-btn" data-remove="'.$line['id'].'" aria-label="Remove '.htmlspecialchars($line['name']).'">×</button>';
        echo '</div>';
        echo '<div class="cl-total">'.money($line['line_total']).'</div>';
        echo '</li>';
    }
    echo '</ul>';
    echo '<div class="cart-summary">';
    echo '<div class="row"><span>Subtotal</span><strong>'.money($totals['subtotal']).'</strong></div>';
    echo '<div class="row"><span>Tax</span><strong>'.money($totals['tax']).'</strong></div>';
    echo '<div class="row total"><span>Total</span><strong>'.money($totals['total']).'</strong></div>';
    echo '</div>';
    echo '<div class="cart-actions">';
    echo '<button type="submit" class="btn small">Update</button>';
    echo '<a href="checkout.php" class="btn alt-btn small">Checkout</a>';
    echo '<button type="button" class="btn danger-btn small" data-clear="1">Clear Cart</button>';
    echo '</div>';
    echo '</form>';
}
$fragment = ob_get_clean();
$response['cart_html'] = $fragment;
$response['cart_count'] = array_sum(array_map(function($i){return $i['quantity'];}, $items));
if(!isset($response['ok'])) $response['ok']=false;
echo json_encode($response);
?>