<?php
// config.php
$host = "localhost";
$user = "username";
$pass = "password";
$db   = "database"; // sesuaikan dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
