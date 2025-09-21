<?php
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
require_once __DIR__.'/../includes/products.php';

$db = rocco_db();
// Find duplicate product names (case-insensitive)
$sql = "SELECT LOWER(name) lname, COUNT(*) c FROM products GROUP BY lname HAVING c > 1 ORDER BY c DESC";
$res = $db->query($sql);
$dupes = [];
while($row = $res->fetch_assoc()) { $dupes[$row['lname']] = (int)$row['c']; }

$groups = [];
if($dupes){
    $in = implode(',', array_fill(0, count($dupes), '?'));
    // Build dynamic query selecting all rows for duplicate names
    $types = str_repeat('s', count($dupes));
    $stmt = $db->prepare("SELECT id, name, price, image_url, category_id FROM products WHERE LOWER(name) IN ($in) ORDER BY LOWER(name), id");
    $params = array_keys($dupes);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $r2 = $stmt->get_result();
    while($p = $r2->fetch_assoc()){
        $groups[strtolower($p['name'])][] = $p;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Duplicate Products</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body { background:#111; color:#eee; font-family:system-ui,sans-serif; }
main { width:min(1200px,92%); margin:40px auto 80px; }
header h1 { font-size:1.55rem; margin:0 0 .6rem; }
.group { background:#181818; border:1px solid #262626; padding:1rem 1.2rem 1.1rem; border-radius:14px; margin-bottom:1.2rem; }
.group h2 { font-size:.9rem; margin:0 0 .7rem; letter-spacing:.5px; font-weight:600; }
.products { display:grid; gap:.8rem; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); }
.card { background:#202020; border:1px solid #2c2c2c; border-radius:10px; padding:.65rem .75rem .75rem; display:flex; flex-direction:column; gap:.45rem; position:relative; }
.card.keep { border-color:#317b3d; }
.card-remove { position:absolute; top:6px; right:6px; }
.badge { display:inline-block; font-size:.55rem; background:#333; padding:.15rem .45rem; border-radius:20px; letter-spacing:.5px; text-transform:uppercase; }
.keep .badge { background:#285c34; }
.card form { margin:0; }
.btn-del { background:#b53434; border:none; color:#fff; font-size:.6rem; padding:.35rem .6rem; border-radius:5px; cursor:pointer; }
.btn-del:hover { background:#c44545; }
.notice { font-size:.65rem; color:#aaa; margin:.4rem 0 1rem; }
.empty { font-size:.8rem; color:#bbb; margin-top:2rem; }
pre.sql { background:#222; padding:.6rem .8rem; font-size:.6rem; border:1px solid #333; border-radius:8px; overflow:auto; }
</style>
</head>
<body>
<main>
  <header>
    <h1>Duplicate Products Audit</h1>
    <p class="notice">Showing groups where the same product name appears more than once. By default, keep the lowest ID (oldest) and remove the newer duplicates.</p>
  </header>
  <?php if(empty($groups)): ?>
    <p class="empty">No duplicate product names found. ✅</p>
  <?php else: ?>
    <?php foreach($groups as $lname => $items): $keepId = $items[0]['id']; ?>
      <div class="group">
        <h2><?php echo htmlspecialchars(ucwords($lname)); ?> <span class="badge">x<?php echo count($items); ?></span></h2>
        <div class="products">
          <?php foreach($items as $prod): $isKeep = ($prod['id'] == $keepId); ?>
            <div class="card <?php echo $isKeep ? 'keep' : ''; ?>">
              <div class="row" style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                <strong style="font-size:.7rem;line-height:1.2;">#<?php echo $prod['id']; ?> · <?php echo htmlspecialchars($prod['name']); ?></strong>
                <?php if($isKeep): ?><span class="badge">keep</span><?php endif; ?>
              </div>
              <div style="font-size:.62rem;color:#ccc;display:flex;justify-content:space-between;">
                <span>$<?php echo number_format($prod['price'],2); ?></span>
                <span><?php echo $prod['image_url'] ? 'IMG' : 'NO IMG'; ?></span>
              </div>
              <?php if(!$isKeep): ?>
              <form method="post" action="duplicates_delete.php" onsubmit="return confirm('Delete product ID <?php echo $prod['id']; ?>? This cannot be undone.');">
                <?php csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo $prod['id']; ?>">
                <button type="submit" class="btn-del">Delete</button>
              </form>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>
</body>
</html>
