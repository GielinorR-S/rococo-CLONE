<?php
// Database configuration

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'rocco'); // I will change this to 'root'
define('DB_PASSWORD', 'rocco123'); // I will change this to my actual password
define('DB_NAME', 'rococo_db');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
