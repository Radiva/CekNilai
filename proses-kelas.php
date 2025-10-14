<?php
include "config.php";

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    // Tambah Kelas
    if ($aksi == "tambah" && $_SERVER['REQUEST_METHOD'] == "POST") {
        $nama = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
        mysqli_query($conn, "INSERT INTO kelas (nama_kelas) VALUES ('$nama')");
        header("Location: kelas.php");
        exit;
    }

    // Edit Kelas
    if ($aksi == "edit" && $_SERVER['REQUEST_METHOD'] == "POST") {
        $id   = $_POST['id'];
        $nama = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
        mysqli_query($conn, "UPDATE kelas SET nama_kelas='$nama' WHERE id=$id");
        header("Location: kelas.php");
        exit;
    }

    // Hapus Kelas
    if ($aksi == "hapus" && isset($_GET['id'])) {
        $id = $_GET['id'];
        mysqli_query($conn, "DELETE FROM kelas WHERE id=$id");
        header("Location: kelas.php");
        exit;
    }
}
?>
