<?php
include "config.php";

// Cek apakah tabel admin sudah ada
$check = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
$tableExists = mysqli_num_rows($check) > 0;

if (!$tableExists) {
    // ======================================================
    // 1. Jika database masih kosong → buat tabel dari awal
    // ======================================================
    echo "<h3>Setup Database Awal</h3>";

    // Buat tabel
    $sqls = [

        "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE,
            password VARCHAR(255)
        )",

        "CREATE TABLE kelas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama_kelas VARCHAR(100) NOT NULL
        )",

        "CREATE TABLE siswa (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nis VARCHAR(20) UNIQUE,
            nama VARCHAR(100) NOT NULL,
            tgl_lahir DATE NOT NULL,
            kelas_id INT,
            FOREIGN KEY (kelas_id) REFERENCES kelas(id)
        )",

        "CREATE TABLE mapel (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama_mapel VARCHAR(100) NOT NULL
        )",

        "CREATE TABLE kelas_mapel (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kelas_id INT NOT NULL,
            mapel_id INT NOT NULL,
            FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
            FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE CASCADE,
            UNIQUE (kelas_id, mapel_id)
        )",

        "CREATE TABLE sub_nilai (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mapel_id INT,
            nama_sub VARCHAR(100),
            bobot DECIMAL(5,2),
            FOREIGN KEY (mapel_id) REFERENCES mapel(id) ON DELETE CASCADE
        )",

        "CREATE TABLE nilai (
            id INT AUTO_INCREMENT PRIMARY KEY,
            siswa_id INT,
            sub_id INT,
            nilai DECIMAL(5,2),
            keterangan TEXT DEFAULT NULL,
            FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
            FOREIGN KEY (sub_id) REFERENCES sub_nilai(id) ON DELETE CASCADE
        )"
    ];

    foreach ($sqls as $q) {
        mysqli_query($conn, $q) or die("Error: " . mysqli_error($conn));
    }

    // Tambah admin default
    $pass = password_hash("admin123", PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('admin', '$pass')");

    echo "✅ Setup selesai. Admin default dibuat (username: <b>admin</b>, password: <b>admin123</b>).";
    exit;
}

// ======================================================
// 2. Kalau tabel sudah ada → butuh login admin
// ======================================================
session_start();
if (!isset($_SESSION['admin_id'])) {
    var_dump($_SESSION);
    echo "<h3>Akses Terbatas</h3>";
    echo "Silakan login sebagai admin di <a href='index.php'>Login</a>.";
    exit;
}

// Jika admin sudah login → tampilkan form konfirmasi password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];

    $id = $_SESSION['admin_id'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $admin = mysqli_fetch_assoc($res);

    if ($admin && password_verify($password, $admin['password'])) {
        // Jika password cocok → eksekusi reset ulang DB
        echo "<h3>Eksekusi Setup Ulang</h3>";

        // Drop tabel lama
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
        mysqli_query($conn, "DROP TABLE IF EXISTS nilai, siswa, kelas, mapel, admin");
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        echo "✅ Semua tabel lama dihapus.<br>";

        // Jalankan ulang file ini (rekursif)
        echo "<meta http-equiv='refresh' content='1'>";
        exit;
    } else {
        echo "<p style='color:red'>❌ Password salah!</p>";
    }
}

?>
<h3>Setup Ulang Database</h3>
<p>Untuk menjalankan setup ulang, silakan masukkan password admin:</p>
<form method="post">
    <input type="password" name="password" placeholder="Password Admin" required>
    <button type="submit">Jalankan Setup</button>
</form>
