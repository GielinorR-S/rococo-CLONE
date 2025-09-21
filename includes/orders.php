<?php
// Order storage helpers (groundwork for checkout & Stripe)
require_once __DIR__.'/config.php';
require_once __DIR__.'/products.php';

function ensure_order_tables(){
    static $done=false; if($done) return; $done=true;
    $db = rocco_db();
    $db->query("CREATE TABLE IF NOT EXISTS orders (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        customer_name VARCHAR(160) NOT NULL,\n        customer_email VARCHAR(160) NOT NULL,\n        customer_phone VARCHAR(60) NOT NULL,\n        notes TEXT,\n        location_slug VARCHAR(40) NOT NULL,\n        subtotal DECIMAL(10,2) NOT NULL,\n        tax DECIMAL(10,2) NOT NULL,\n        total DECIMAL(10,2) NOT NULL,\n        payment_status ENUM('pending','paid','failed','cancelled') DEFAULT 'pending',\n        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $db->query("CREATE TABLE IF NOT EXISTS order_items (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        order_id INT NOT NULL,\n        product_id INT NULL,\n        product_name VARCHAR(160) NOT NULL,\n        quantity INT NOT NULL,\n        unit_price DECIMAL(10,2) NOT NULL,\n        line_total DECIMAL(10,2) NOT NULL,\n        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

ensure_order_tables();

function create_order(array $customer, string $location, array $cartItems, array $totals): ?int {
    $db = rocco_db();
    $stmt = $db->prepare("INSERT INTO orders (customer_name,customer_email,customer_phone,notes,location_slug,subtotal,tax,total) VALUES (?,?,?,?,?,?,?,?)");
    $notes = $customer['notes'] ?? '';
    $stmt->bind_param('ssssdddd',$customer['name'],$customer['email'],$customer['phone'],$notes,$location,$totals['subtotal'],$totals['tax'],$totals['total']);
    if(!$stmt->execute()) return null;
    $orderId = $stmt->insert_id;
    $stmt->close();
    $itemStmt = $db->prepare("INSERT INTO order_items (order_id,product_id,product_name,quantity,unit_price,line_total) VALUES (?,?,?,?,?,?)");
    foreach($cartItems as $line){
        $pid = $line['id'] ?? null;
        $itemStmt->bind_param('iisidd',$orderId,$pid,$line['name'],$line['quantity'],$line['price'],$line['line_total']);
        $itemStmt->execute();
    }
    $itemStmt->close();
    return $orderId;
}

function get_order(int $id): ?array {
    $db = rocco_db();
    $stmt = $db->prepare("SELECT * FROM orders WHERE id=? LIMIT 1");
    $stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result();
    $o = $res->fetch_assoc();
    if(!$o) return null;
    $items = [];
    $ir = $db->prepare("SELECT * FROM order_items WHERE order_id=? ORDER BY id");
    $ir->bind_param('i',$id); $ir->execute(); $rs = $ir->get_result();
    while($row = $rs->fetch_assoc()) $items[] = $row;
    $o['items'] = $items;
    return $o;
}
?>