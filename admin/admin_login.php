<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/admin_auth.php';

$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!validate_csrf()){
        $error = 'Invalid session token. Please try again.';
    } else {
        $u = trim($_POST['username'] ?? '');
        $p = trim($_POST['password'] ?? '');
        if(admin_login($u,$p)){
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.admin-login-wrapper{max-width:420px;margin:4rem auto;padding:2rem;background:#1d1d1d;border:1px solid #333;border-radius:6px;color:#eee;font-family:system-ui,sans-serif;}
.admin-login-wrapper h1{font-size:1.4rem;margin:0 0 1.2rem;font-weight:600;}
.admin-login-wrapper label{display:block;font-size:.85rem;margin-bottom:.35rem;color:#aaa;}
.admin-login-wrapper input[type=text], .admin-login-wrapper input[type=password]{width:100%;padding:.65rem .75rem;border:1px solid #444;background:#111;color:#eee;border-radius:4px;font-size:.95rem;}
.admin-login-wrapper input[type=text]:focus, .admin-login-wrapper input[type=password]:focus{outline:2px solid #666;}
.admin-login-wrapper button{width:100%;padding:.75rem 1rem;margin-top:1rem;background:#444;color:#fff;border:0;border-radius:4px;font-size:1rem;cursor:pointer;}
.admin-login-wrapper button:hover{background:#555;}
.admin-login-wrapper .error{background:#572020;color:#f5b5b5;padding:.65rem .75rem;border:1px solid #803333;border-radius:4px;margin-bottom:1rem;font-size:.85rem;}
.admin-login-wrapper .hint{font-size:.7rem;color:#777;margin-top:.75rem;line-height:1.3;}
</style>
</head>
<body>
<div class="admin-login-wrapper">
<h1>Admin Login</h1>
<?php if($error): ?><div class="error" role="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<form method="post" action="">
    <?php csrf_field(); ?>
    <label for="username">Username</label>
    <input id="username" name="username" type="text" autocomplete="username" required>
    <label for="password">Password</label>
    <input id="password" name="password" type="password" autocomplete="current-password" required>
    <button type="submit">Sign In</button>
    <p class="hint">Default credentials seeded if none exist:<br>Username: <code>admin</code><br>Password: <code>admin123</code><br>Please change after first login (feature coming soon).</p>
</form>
</div>
</body>
</html>