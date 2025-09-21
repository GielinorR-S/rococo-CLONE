<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
require_once __DIR__.'/../includes/products.php';
$db = rocco_db();

function ensure_csrf_valid(){ if(!validate_csrf()){ $_SESSION['admin_flash']='Security token invalid.'; header('Location: products.php'); exit; } }

// Fetch categories for selects
$catMap = [];
$resCats = $db->query("SELECT id, location_slug, name FROM product_categories ORDER BY location_slug, name");
while($resCats && $r = $resCats->fetch_assoc()){ $catMap[$r['id']] = $r; }

$action = $_POST['action'] ?? '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    if($action==='create'){
        ensure_csrf_valid();
        $cid = (int)($_POST['category_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $img = trim($_POST['image_url'] ?? '');
        if($cid && $name && $price >= 0){
            $stmt = $db->prepare("INSERT INTO products (category_id,name,description,price,image_url,is_active) VALUES (?,?,?,?,?,1)");
            $imgParam = $img ?: null;
            $stmt->bind_param('issds',$cid,$name,$desc,$price,$imgParam);
            $stmt->execute();
            $_SESSION['admin_flash'] = 'Product created';
        }
        header('Location: products.php'); exit;
    } elseif($action==='update') {
        ensure_csrf_valid();
        $id = (int)($_POST['id'] ?? 0);
        $cid = (int)($_POST['category_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $img = trim($_POST['image_url'] ?? '');
        $active = isset($_POST['is_active']) ? 1 : 0;
        if($id && $cid && $name){
            $stmt = $db->prepare("UPDATE products SET category_id=?, name=?, description=?, price=?, image_url=?, is_active=? WHERE id=?");
            $imgParam = $img ?: null;
            $stmt->bind_param('issdsii',$cid,$name,$desc,$price,$imgParam,$active,$id);
            $stmt->execute();
            $_SESSION['admin_flash'] = 'Product updated';
        }
        header('Location: products.php'); exit;
    } elseif($action==='delete') {
        ensure_csrf_valid();
        $id = (int)($_POST['id'] ?? 0);
        if($id){
            $stmt = $db->prepare("DELETE FROM products WHERE id=? LIMIT 1");
            $stmt->bind_param('i',$id); $stmt->execute();
            $_SESSION['admin_flash'] = 'Product deleted';
        }
        header('Location: products.php'); exit;
    }
}

// Fetch products with category + location
$products = [];
$sql = "SELECT p.id,p.name,p.price,p.is_active,p.image_url,p.category_id,p.description,c.location_slug,c.name AS category_name
        FROM products p JOIN product_categories c ON c.id = p.category_id
        ORDER BY c.location_slug, c.name, p.name";
$res = $db->query($sql);
while($res && $row=$res->fetch_assoc()){ $products[] = $row; }

$locations = get_shop_locations();

function flash(){ if(isset($_SESSION['admin_flash'])){ echo '<div class="flash" role="status">'.htmlspecialchars($_SESSION['admin_flash']).'</div>'; unset($_SESSION['admin_flash']); } }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Products</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.admin-shell{max-width:1300px;margin:2.5rem auto;padding:0 1.25rem;font-family:system-ui,sans-serif;color:#eee;}
.admin-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;}
.admin-top h1{font-size:1.5rem;margin:0;font-weight:600;}
.admin-nav a{color:#bbb;text-decoration:none;margin-right:1.25rem;font-size:.85rem;}
.admin-nav a:hover{color:#fff;}
.flash{background:#203d2e;color:#9ae6b4;border:1px solid #2f6b4c;padding:.65rem .75rem;border-radius:4px;margin-bottom:1rem;font-size:.8rem;}
.table{width:100%;border-collapse:collapse;margin-bottom:2.5rem;font-size:.78rem;}
.table th,.table td{border:1px solid #333;padding:.5rem .55rem;text-align:left;vertical-align:top;}
.table th{background:#222;font-weight:600;}
.inline-form{display:grid;grid-template-columns:repeat(10,minmax(60px,1fr));gap:.35rem;align-items:start;}
.inline-form input[type=text], .inline-form input[type=number], .inline-form textarea, .new-prod-form input[type=text], .new-prod-form input[type=number], .new-prod-form textarea{background:#111;border:1px solid #333;color:#eee;padding:.4rem .5rem;border-radius:3px;font-size:.7rem;width:100%;}
.inline-form textarea{grid-column: span 3; min-height:60px;}
.inline-form button, .new-prod-form button{background:#444;color:#fff;border:0;padding:.45rem .6rem;border-radius:3px;cursor:pointer;font-size:.7rem;}
.inline-form button:hover, .new-prod-form button:hover{background:#555;}
.new-prod-form{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:.55rem;margin-bottom:2rem;font-size:.72rem;}
.new-prod-form textarea{grid-column:1/-1;min-height:60px;}
.badge{display:inline-block;background:#333;padding:.2rem .45rem;border-radius:3px;font-size:.6rem;color:#bbb;margin-left:.4rem;}
.toggle-active{display:flex;align-items:center;gap:.3rem;font-size:.65rem;}
</style>
</head>
<body>
<div class="admin-shell">
    <div class="admin-top">
        <h1>Products</h1>
        <div class="admin-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Products</a>
            <a href="categories.php">Categories</a>
            <form method="post" action="logout.php" style="display:inline;">
                <?php csrf_field(); ?>
                <button style="background:#2e2e2e;border:1px solid #444;padding:.35rem .7rem;color:#ccc;border-radius:3px;cursor:pointer;font-size:.65rem;">Logout</button>
            </form>
        </div>
    </div>
    <?php flash(); ?>

    <form class="new-prod-form" method="post">
        <?php csrf_field(); ?>
        <input type="hidden" name="action" value="create">
        <select name="category_id" required>
            <option value="">Category</option>
            <?php foreach($catMap as $cid=>$cinfo): ?>
              <option value="<?php echo (int)$cid; ?>"><?php echo htmlspecialchars($locations[$cinfo['location_slug']] . ' – ' . $cinfo['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="name" placeholder="Name" required>
        <input type="number" name="price" min="0" step="0.01" placeholder="Price" required>
        <input type="text" name="image_url" placeholder="Image URL (optional)">
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Add Product</button>
    </form>

    <table class="table">
        <thead>
            <tr><th>ID</th><th>Location/Category</th><th>Name & Details</th><th>Price</th><th>Image</th><th>Active</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach($products as $prod): ?>
            <tr>
                <td><?php echo (int)$prod['id']; ?></td>
                <td><?php echo htmlspecialchars(($locations[$prod['location_slug']] ?? $prod['location_slug']).' – '.$prod['category_name']); ?></td>
                <td>
                  <form class="inline-form" method="post">
                    <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo (int)$prod['id']; ?>">
                    <select name="category_id" style="grid-column: span 2;">
                        <?php foreach($catMap as $cid=>$cinfo): ?>
                          <option value="<?php echo (int)$cid; ?>" <?php if($cid==$prod['category_id']) echo 'selected'; ?>><?php echo htmlspecialchars($locations[$cinfo['location_slug']] . ' – ' . $cinfo['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($prod['name']); ?>" required>
                    <textarea name="description" placeholder="Description"><?php echo htmlspecialchars($prod['description']); ?></textarea>
                    <input type="number" name="price" min="0" step="0.01" value="<?php echo number_format((float)$prod['price'],2,'.',''); ?>">
                    <input type="text" name="image_url" value="<?php echo htmlspecialchars($prod['image_url']); ?>" placeholder="Image URL">
                    <label class="toggle-active"><input type="checkbox" name="is_active" value="1" <?php if($prod['is_active']) echo 'checked'; ?>> Active</label>
                    <button type="submit" style="grid-column: span 1;">Save</button>
                  </form>
                </td>
                <td><?php echo money($prod['price']); ?></td>
                <td><?php if($prod['image_url']): ?><img src="<?php echo htmlspecialchars($prod['image_url']); ?>" alt="" style="width:60px;height:auto;display:block;object-fit:cover;" /><?php else: ?><span class="badge">fallback</span><?php endif; ?></td>
                <td><?php echo $prod['is_active'] ? 'Yes' : 'No'; ?></td>
                <td>
                  <form method="post" onsubmit="return confirm('Delete product?');">
                    <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo (int)$prod['id']; ?>">
                    <button style="background:#552828;">Delete</button>
                  </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>