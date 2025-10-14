<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // cek user
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);

        // verifikasi password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: index.php?error=Password salah");
            exit;
        }
    } else {
        header("Location: index.php?error=Username tidak ditemukan");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
