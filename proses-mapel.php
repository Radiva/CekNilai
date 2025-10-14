<?php
include "config.php";

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    if ($aksi == "tambah" && $_SERVER['REQUEST_METHOD']=="POST") {
        $nama = mysqli_real_escape_string($conn, $_POST['nama_mapel']);
        mysqli_query($conn, "INSERT INTO mapel (nama_mapel) VALUES ('$nama')");
        header("Location: mapel.php"); exit;
    }

    if ($aksi == "edit" && $_SERVER['REQUEST_METHOD']=="POST") {
        $id   = $_POST['id'];
        $nama = mysqli_real_escape_string($conn, $_POST['nama_mapel']);
        mysqli_query($conn, "UPDATE mapel SET nama_mapel='$nama' WHERE id=$id");
        header("Location: mapel.php"); exit;
    }

    if ($aksi == "hapus" && isset($_GET['id'])) {
        $id = $_GET['id'];
        mysqli_query($conn, "DELETE FROM mapel WHERE id=$id");
        header("Location: mapel.php"); exit;
    }
}
?>
