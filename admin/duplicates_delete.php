<?php
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
require_once __DIR__.'/../includes/products.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){ http_response_code(405); exit; }
if(!validate_csrf()){
	header('Location: duplicates.php?err=csrf');
	exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if($id <= 0){ header('Location: duplicates.php?err=invalid'); exit; }

$db = rocco_db();
// fetch product to ensure exists
$stmt = $db->prepare('SELECT id, name FROM products WHERE id=?');
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$prod = $res->fetch_assoc();
$stmt->close();
if(!$prod){ header('Location: duplicates.php?err=missing'); exit; }

// We intentionally do NOT cascade to order_items; historical rows retain product_name.
$del = $db->prepare('DELETE FROM products WHERE id=? LIMIT 1');
$del->bind_param('i',$id);
$del->execute();
$del->close();

header('Location: duplicates.php?deleted='.$id);
exit;