<?php
define('BASE_PATH', dirname(__DIR__));
// config.php
$host = "localhost";
$user = "username";
$pass = "password";
$db   = "database"; // sesuaikan dengan nama database kamu
$BASE_URL = "http://www.domain.com/public/"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
