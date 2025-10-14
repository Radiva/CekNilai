<?php
include "config.php";
session_start();

// Cek apakah sudah login admin
if (!isset($_SESSION['admin_id'])) {
    echo "<h3>Akses Terbatas</h3>";
    echo "Silakan login sebagai admin di <a href='index.php'>Login</a>.";
    exit;
}

// Jika ada aksi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aksi = $_POST['aksi'];
    $password = $_POST['password'];

    // Ambil data admin
    $id = $_SESSION['admin_id'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $admin = mysqli_fetch_assoc($res);

    if (!$admin || !password_verify($password, $admin['password'])) {
        echo "<p style='color:red'>❌ Password salah!</p>";
    } else {
        if ($aksi == 'reset') {
            // Reset data → truncate semua tabel
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
            mysqli_query($conn, "TRUNCATE TABLE nilai");
            mysqli_query($conn, "TRUNCATE TABLE siswa");
            mysqli_query($conn, "TRUNCATE TABLE kelas");
            mysqli_query($conn, "TRUNCATE TABLE mapel");
            mysqli_query($conn, "TRUNCATE TABLE users");
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

            // Tambah admin default lagi
            $pass = password_hash("admin123", PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('admin', '$pass')");

            echo "<p style='color:green'>✅ Reset data berhasil. Admin default dibuat ulang.</p>";

        } elseif ($aksi == 'setup') {
            // Setup ulang → drop semua tabel
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
            mysqli_query($conn, "DROP TABLE IF EXISTS nilai, siswa, kelas, mapel, users");
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

            echo "<p>✅ Semua tabel lama dihapus. Membuat tabel baru...</p>";

            // Buat ulang tabel
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
                "CREATE TABLE nilai (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    siswa_id INT,
                    mapel_id INT,
                    nilai DECIMAL(5,2) NOT NULL,
                    bobot DECIMAL(3,2) DEFAULT 1.0,
                    keterangan TEXT DEFAULT NULL,
                    FOREIGN KEY (siswa_id) REFERENCES siswa(id),
                    FOREIGN KEY (mapel_id) REFERENCES mapel(id)
                )"
            ];

            foreach ($sqls as $q) {
                mysqli_query($conn, $q) or die("Error: " . mysqli_error($conn));
            }

            // Buat admin default lagi
            $pass = password_hash("admin123", PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('admin', '$pass')");

            echo "<p style='color:green'>✅ Setup ulang selesai. Admin default dibuat (admin/admin123).</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Database</title>
</head>
<body>
    <h2>Maintenance Database</h2>
    <form method="post">
        <p>Masukkan password admin untuk melanjutkan:</p>
        <input type="password" name="password" required>
        <br><br>
        <button type="submit" name="aksi" value="reset">🔄 Reset Data</button>
        <button type="submit" name="aksi" value="setup">⚡ Setup Ulang</button>
    </form>
    <br>
    <a href="dashboard.php">⬅ Kembali ke Dashboard</a>
</body>
</html>
