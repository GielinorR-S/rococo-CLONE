<?php
// Database configuration

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Change if needed
define('DB_PASSWORD', ''); // Change if needed
define('DB_NAME', 'rocco_db');

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>