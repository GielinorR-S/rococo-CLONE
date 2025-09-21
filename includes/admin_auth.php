<?php
// Basic admin authentication & CSRF utilities
// Usage: require_once __DIR__.'/admin_auth.php';
// ensure_admin_tables($mysqli); then login, require_admin(), etc.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__.'/config.php';

function ensure_admin_tables($mysqli){
    $mysqli->query("CREATE TABLE IF NOT EXISTS admin_users (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        username VARCHAR(100) NOT NULL UNIQUE,\n        password_hash VARCHAR(255) NOT NULL,\n        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // seed default admin if none
    $res = $mysqli->query("SELECT COUNT(*) c FROM admin_users");
    if($res){ $row = $res->fetch_assoc(); if((int)$row['c'] === 0){
        $u = 'admin';
        $p = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO admin_users(username,password_hash) VALUES(?,?)");
        $stmt->bind_param('ss',$u,$p);
        $stmt->execute();
        $stmt->close();
    }}
}

ensure_admin_tables($mysqli);

function admin_logged_in(){
    return !empty($_SESSION['admin_user']);
}

function admin_login($username, $password){
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, username, password_hash FROM admin_users WHERE username = ? LIMIT 1");
    if(!$stmt) return false;
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
    if($user && password_verify($password, $user['password_hash'])){
        // regenerate session id for security
        session_regenerate_id(true);
        $_SESSION['admin_user'] = [ 'id'=>$user['id'], 'username'=>$user['username'] ];
        return true;
    }
    return false;
}

function admin_logout(){
    unset($_SESSION['admin_user']);
}

// --- CSRF Utilities ---
function csrf_token(){
    if(empty($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function csrf_field(){
    $t = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    echo '<input type="hidden" name="csrf_token" value="'.$t.'">';
}
function validate_csrf(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $sent = $_POST['csrf_token'] ?? '';
        if(!$sent || !hash_equals($_SESSION['csrf_token'] ?? '', $sent)){
            return false;
        }
    }
    return true;
}

function require_admin(){
    if(!admin_logged_in()){
        header('Location: admin_login.php');
        exit;
    }
}
?>