<?php
include "config.php";

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];

    // Tambah Siswa
    if ($aksi == "tambah" && $_SERVER['REQUEST_METHOD']=="POST") {
        $nis  = mysqli_real_escape_string($conn, $_POST['nis']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $tgl  = $_POST['tanggal_lahir'];
        $kelas= $_POST['kelas_id'];
        mysqli_query($conn, "INSERT INTO siswa (nis, nama, tgl_lahir, kelas_id) 
                             VALUES ('$nis','$nama','$tgl','$kelas')");
        header("Location: siswa.php");
        exit;
    }

    // Edit Siswa
    if ($aksi == "edit" && $_SERVER['REQUEST_METHOD']=="POST") {
        $id   = $_POST['id'];
        $nis  = mysqli_real_escape_string($conn, $_POST['nis']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $tgl  = $_POST['tanggal_lahir'];
        $kelas= $_POST['kelas_id'];
        mysqli_query($conn, "UPDATE siswa 
                             SET nis='$nis', nama='$nama', tgl_lahir='$tgl', kelas_id='$kelas'
                             WHERE id=$id");
        header("Location: siswa.php");
        exit;
    }

    // Hapus Siswa
    if ($aksi == "hapus" && isset($_GET['id'])) {
        $id = $_GET['id'];
        mysqli_query($conn, "DELETE FROM siswa WHERE id=$id");
        header("Location: siswa.php");
        exit;
    }
}
?>
