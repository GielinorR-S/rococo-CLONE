<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/admin_auth.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(validate_csrf()){
        admin_logout();
    }
    header('Location: admin_login.php');
    exit;
}
header('Location: dashboard.php');