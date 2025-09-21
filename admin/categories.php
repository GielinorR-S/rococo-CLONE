<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
require_once __DIR__.'/../includes/products.php';

$db = rocco_db();

// CSRF helper
function ensure_csrf_valid(){
    if(!validate_csrf()){
        $_SESSION['admin_flash'] = 'Security token invalid.';
        header('Location: categories.php');
        exit;
    }
}

// Handle actions
$action = $_POST['action'] ?? '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    if($action === 'create'){
        ensure_csrf_valid();
        $loc = trim($_POST['location_slug'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $group = trim($_POST['group_name'] ?? '');
        $order = (int)($_POST['display_order'] ?? 0);
        if($loc && $name){
            $stmt = $db->prepare("INSERT INTO product_categories (location_slug,name,group_name,display_order) VALUES (?,?,?,?)");
            $stmt->bind_param('sssi',$loc,$name,$group,$order);
            $stmt->execute();
            $_SESSION['admin_flash'] = 'Category created.';
        }
        header('Location: categories.php'); exit;
    } elseif($action === 'update') {
        ensure_csrf_valid();
        $id = (int)($_POST['id'] ?? 0); $name = trim($_POST['name'] ?? ''); $group = trim($_POST['group_name'] ?? ''); $order = (int)($_POST['display_order'] ?? 0);
        if($id && $name){
            $stmt = $db->prepare("UPDATE product_categories SET name=?, group_name=?, display_order=? WHERE id=?");
            $stmt->bind_param('ssii',$name,$group,$order,$id);
            $stmt->execute();
            $_SESSION['admin_flash'] = 'Category updated.';
        }
        header('Location: categories.php'); exit;
    } elseif($action === 'delete') {
        ensure_csrf_valid();
        $id = (int)($_POST['id'] ?? 0);
        if($id){
            // Only delete if no products OR we choose cascade by foreign key (already cascade). Accept direct delete.
            $stmt = $db->prepare("DELETE FROM product_categories WHERE id=? LIMIT 1");
            $stmt->bind_param('i',$id); $stmt->execute();
            $_SESSION['admin_flash'] = 'Category deleted.';
        }
        header('Location: categories.php'); exit;
    }
}

$locations = get_shop_locations();
// Fetch categories grouped by location for display
$allCats = [];
$catRes = $db->query("SELECT id, location_slug, name, group_name, display_order FROM product_categories ORDER BY location_slug, COALESCE(display_order,999), name");
while($catRes && $row = $catRes->fetch_assoc()){ $allCats[] = $row; }

function flash(){ if(isset($_SESSION['admin_flash'])){ echo '<div class="flash" role="status">'.htmlspecialchars($_SESSION['admin_flash']).'</div>'; unset($_SESSION['admin_flash']); } }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Categories</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.admin-shell{max-width:1240px;margin:2.5rem auto;padding:0 1.25rem;font-family:system-ui,sans-serif;color:#eee;}
.admin-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;}
.admin-top h1{font-size:1.5rem;margin:0;font-weight:600;}
.admin-nav a{color:#bbb;text-decoration:none;margin-right:1.25rem;font-size:.85rem;}
.admin-nav a:hover{color:#fff;}
.flash{background:#203d2e;color:#9ae6b4;border:1px solid #2f6b4c;padding:.65rem .75rem;border-radius:4px;margin-bottom:1rem;font-size:.8rem;}
.table{width:100%;border-collapse:collapse;margin-bottom:2rem;font-size:.8rem;}
.table th,.table td{border:1px solid #333;padding:.5rem .6rem;text-align:left;}
.table th{background:#222;font-weight:600;}
.actions{display:flex;gap:.4rem;}
.actions form{display:inline;}
.inline-form input[type=text], .inline-form input[type=number]{background:#111;border:1px solid #333;color:#eee;padding:.35rem .45rem;border-radius:3px;font-size:.75rem;}
.inline-form input[type=text]:focus{outline:1px solid #555;}
.inline-form button{background:#444;color:#fff;border:0;padding:.4rem .65rem;border-radius:3px;cursor:pointer;font-size:.7rem;}
.inline-form button:hover{background:#555;}
.new-cat-form{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:.6rem;margin-bottom:2rem;font-size:.75rem;}
.new-cat-form input, .new-cat-form select{background:#111;border:1px solid #333;color:#eee;padding:.45rem .5rem;border-radius:3px;}
.new-cat-form button{grid-column:1/-1;margin-top:.3rem;background:#2f4f2f;}
.new-cat-form button:hover{background:#3a5f3a;}
.badge{display:inline-block;background:#333;padding:.2rem .45rem;border-radius:3px;font-size:.65rem;color:#bbb;margin-left:.4rem;}
</style>
</head>
<body>
<div class="admin-shell">
    <div class="admin-top">
        <h1>Categories</h1>
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

    <form class="new-cat-form" method="post">
        <?php csrf_field(); ?>
        <input type="hidden" name="action" value="create">
        <select name="location_slug" required>
            <option value="">Location</option>
            <?php foreach($locations as $slug=>$label): ?>
              <option value="<?php echo htmlspecialchars($slug); ?>"><?php echo htmlspecialchars($label); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="name" placeholder="Category Name" required>
        <input type="text" name="group_name" placeholder="Group (e.g. Pizza)">
        <input type="number" name="display_order" placeholder="Order" min="0">
        <button type="submit" class="inline-btn">Add Category</button>
    </form>

    <table class="table">
        <thead>
            <tr><th>ID</th><th>Location</th><th>Name</th><th>Group</th><th>Order</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach($allCats as $cat): ?>
            <tr>
                <td><?php echo (int)$cat['id']; ?></td>
                <td><?php echo htmlspecialchars($locations[$cat['location_slug']] ?? $cat['location_slug']); ?></td>
                <td>
                  <form method="post" class="inline-form" style="display:flex;gap:.4rem;flex-wrap:wrap;align-items:center;">
                    <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo (int)$cat['id']; ?>">
                    <input type="text" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
                    <input type="text" name="group_name" value="<?php echo htmlspecialchars($cat['group_name']); ?>" placeholder="Group">
                    <input type="number" name="display_order" value="<?php echo (int)$cat['display_order']; ?>" style="width:70px;">
                    <button type="submit">Save</button>
                  </form>
                </td>
                <td><?php echo htmlspecialchars($cat['group_name']); ?></td>
                <td><?php echo (int)$cat['display_order']; ?></td>
                <td class="actions">
                  <form method="post" onsubmit="return confirm('Delete this category? This will remove associated products by cascade.');">
                    <?php csrf_field(); ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo (int)$cat['id']; ?>">
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