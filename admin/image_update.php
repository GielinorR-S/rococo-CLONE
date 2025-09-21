<?php
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
require_once __DIR__.'/../includes/products.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!validate_csrf()) { http_response_code(400); echo 'Bad CSRF token'; exit; }
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $url = trim($_POST['image_url'] ?? '');
    if($id > 0 && $url) {
        $db = rocco_db();
        $stmt = $db->prepare("UPDATE products SET image_url=? WHERE id=? LIMIT 1");
        $stmt->bind_param('si', $url, $id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: image_audit.php');
    exit;
}
http_response_code(405);
?>