<?php
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
require_once __DIR__.'/../includes/products.php';

$db = rocco_db();
// Fetch products with and without images
$sql = "SELECT p.id, p.name, p.image_url, p.category_id, c.name AS category_name FROM products p LEFT JOIN product_categories c ON c.id = p.category_id ORDER BY (p.image_url IS NULL OR p.image_url='') DESC, p.name";
$res = $db->query($sql);
$missing = [];$with = [];
while($row = $res->fetch_assoc()){
    if(empty($row['image_url'])) $missing[] = $row; else $with[] = $row;
}
$total = count($missing) + count($with);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Image Audit</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body { background:#111; color:#eee; font-family:system-ui,sans-serif; }
main { width:min(1200px,92%); margin:40px auto 80px; }
header h1 { font-size:1.6rem; margin:0 0 .5rem; }
.table { width:100%; border-collapse:collapse; margin-top:1.2rem; }
.table th, .table td { padding:.55rem .65rem; border-bottom:1px solid #222; font-size:.75rem; text-align:left; }
.badge-missing { background:#b53333; color:#fff; font-size:.6rem; padding:.2rem .45rem; border-radius:4px; letter-spacing:.5px; }
.badge-ok { background:#2e6c3a; color:#fff; font-size:.55rem; padding:.2rem .45rem; border-radius:4px; letter-spacing:.5px; }
.actions form { display:flex; gap:.4rem; }
.inline-input { width:280px; padding:.35rem .55rem; border:1px solid #333; background:#1c1c1c; color:#eee; border-radius:6px; font-size:.65rem; }
.btn-save { background:#2563eb; border:none; padding:.4rem .9rem; color:#fff; font-size:.65rem; border-radius:6px; cursor:pointer; }
.btn-save:hover { background:#3775f5; }
.preview-thumb { width:60px; height:46px; object-fit:cover; border-radius:6px; display:block; }
.section-title { margin-top:2.2rem; font-size:1.05rem; }
.notice { margin-top:.6rem; font-size:.65rem; color:#aaa; }
.flex { display:flex; gap:1.2rem; }
.summary-box { background:#181818; border:1px solid #262626; padding:1rem 1.2rem; border-radius:12px; }
.summary-box h2 { font-size:.9rem; margin:0 0 .6rem; letter-spacing:.5px; }
.summary-box p { margin:.25rem 0; font-size:.65rem; color:#bbb; }
.large-badge { font-size:.65rem; padding:.3rem .6rem; background:#222; border:1px solid #333; border-radius:20px; }
.code { font-family:monospace; background:#222; padding:.15rem .4rem; border-radius:4px; }
form.inline-update { display:flex; align-items:center; gap:.4rem; }
</style>
</head>
<body>
<main>
  <header>
    <h1>Product Image Audit</h1>
    <p class="notice">Total products: <?php echo $total; ?> · Missing images: <strong><?php echo count($missing); ?></strong> · Complete: <strong><?php echo count($with); ?></strong></p>
  </header>
  <section>
    <h2 class="section-title">Missing Images (<?php echo count($missing); ?>)</h2>
    <?php if(empty($missing)): ?>
      <p class="notice">Great! Every product has an image_url.</p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr><th>ID</th><th>Name</th><th>Category</th><th>Add Image URL</th><th>Suggestions</th></tr>
        </thead>
        <tbody>
          <?php foreach($missing as $m): ?>
            <tr>
              <td><?php echo $m['id']; ?></td>
              <td><?php echo htmlspecialchars($m['name']); ?></td>
              <td><?php echo htmlspecialchars($m['category_name'] ?? ''); ?></td>
              <td>
                <form method="post" action="image_update.php" class="inline-update">
                  <?php csrf_field(); ?>
                  <input type="hidden" name="id" value="<?php echo $m['id']; ?>" />
                  <input type="url" name="image_url" class="inline-input" placeholder="https://..." required>
                  <button class="btn-save" type="submit">Save</button>
                </form>
              </td>
              <td style="max-width:260px;">
                <?php $sugs = product_image_suggestions($m['name']); ?>
                <div style="display:flex;flex-wrap:wrap;gap:4px;">
                  <?php foreach(array_slice($sugs,0,4) as $s): ?>
                    <button type="button" data-suggest="<?php echo htmlspecialchars($s); ?>" style="background:#2a2a2a;border:1px solid #3a3a3a;color:#bbb;padding:2px 6px;font-size:.55rem;border-radius:4px;cursor:pointer;" title="Use this image">Img</button>
                  <?php endforeach; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
  <section>
    <h2 class="section-title">Products With Images (<?php echo count($with); ?>)</h2>
    <table class="table">
      <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Preview</th><th>Replace</th></tr></thead>
      <tbody>
        <?php foreach($with as $w): ?>
        <tr>
          <td><?php echo $w['id']; ?></td>
          <td><?php echo htmlspecialchars($w['name']); ?></td>
          <td><?php echo htmlspecialchars($w['category_name'] ?? ''); ?></td>
          <td><?php if($w['image_url']): ?><img src="<?php echo htmlspecialchars($w['image_url']); ?>" alt="" class="preview-thumb"><?php endif; ?></td>
          <td>
            <form method="post" action="image_update.php" class="inline-update">
              <?php csrf_field(); ?>
              <input type="hidden" name="id" value="<?php echo $w['id']; ?>" />
              <input type="url" name="image_url" value="<?php echo htmlspecialchars($w['image_url']); ?>" class="inline-input" required>
              <button class="btn-save" type="submit">Update</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>
<script>
// Attach click handlers to suggestion buttons to populate sibling input
document.addEventListener('click', function(e){
  const btn = e.target.closest('button[data-suggest]');
  if(!btn) return;
  const url = btn.getAttribute('data-suggest');
  // Find the row's input
  const row = btn.closest('tr');
  if(!row) return;
  const input = row.querySelector('input[name=image_url]');
  if(input){ input.value = url; input.focus(); }
});
</script>
</body>
</html>
