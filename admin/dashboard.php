<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/admin_auth.php';
require_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.admin-shell{max-width:1240px;margin:2.5rem auto;padding:0 1.25rem;font-family:system-ui,sans-serif;color:#eee;}
.admin-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;}
.admin-top h1{font-size:1.6rem;margin:0;font-weight:600;}
.admin-nav a{color:#bbb;text-decoration:none;margin-right:1.25rem;font-size:.9rem;}
.admin-nav a:hover{color:#fff;}
.admin-card-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.25rem;margin-bottom:2rem;}
.admin-card{background:#1d1d1d;border:1px solid #333;padding:1.1rem 1.1rem 1.2rem;border-radius:6px;display:flex;flex-direction:column;}
.admin-card h2{font-size:1rem;margin:0 0 .55rem;color:#fff;font-weight:600;}
.admin-card p{font-size:.75rem;line-height:1.3;color:#aaa;margin:0 0 .75rem;}
.admin-card a.btn{margin-top:auto;align-self:flex-start;background:#444;color:#fff;padding:.55rem .8rem;border-radius:4px;font-size:.8rem;text-decoration:none;}
.admin-card a.btn:hover{background:#555;}
.logout-form{display:inline;}
.logout-form button{background:#2e2e2e;color:#ccc;border:1px solid #444;padding:.4rem .8rem;border-radius:4px;cursor:pointer;font-size:.75rem;}
.logout-form button:hover{background:#3a3a3a;color:#fff;}
.flash{background:#203d2e;color:#9ae6b4;border:1px solid #2f6b4c;padding:.65rem .75rem;border-radius:4px;margin-bottom:1rem;font-size:.8rem;}
</style>
</head>
<body>
<div class="admin-shell">
    <div class="admin-top">
        <h1>Dashboard</h1>
        <div class="admin-nav">
            <a href="dashboard.php">Overview</a>
            <a href="products.php">Products</a>
            <a href="categories.php">Categories</a>
            <form class="logout-form" method="post" action="logout.php" style="display:inline-block;">
                <?php csrf_field(); ?>
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <?php if(!validate_csrf()){ echo '<div class="flash" role="alert">Security token invalid - refresh page.</div>'; } ?>
    <div class="admin-card-grid">
        <div class="admin-card">
            <h2>Products</h2>
            <p>Add, edit and deactivate menu items for each location and category grouping.</p>
            <a class="btn" href="products.php">Manage Products</a>
        </div>
        <div class="admin-card">
            <h2>Categories</h2>
            <p>Create or reorganize categories and assign group names to control storefront grouping.</p>
            <a class="btn" href="categories.php">Manage Categories</a>
        </div>
        <div class="admin-card">
            <h2>Security</h2>
            <p>Rotate your admin password regularly (password change feature coming soon).</p>
            <a class="btn" href="admin_login.php">Review</a>
        </div>
    </div>
    <p style="font-size:.65rem;color:#555;">Session User: <?php echo htmlspecialchars($_SESSION['admin_user']['username']); ?></p>
</div>
</body>
</html>