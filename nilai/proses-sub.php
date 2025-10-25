<?php
include "../config/config.php";

if (isset($_GET['aksi'])) {
    $aksi = $_GET['aksi'];
    $mapel_id = $_GET['mapel_id'];

    if ($aksi == "tambah" && $_SERVER['REQUEST_METHOD']=="POST") {
        $nama = mysqli_real_escape_string($conn, $_POST['nama_sub']);
        $bobot= $_POST['bobot'];
        mysqli_query($conn, "INSERT INTO sub_nilai (mapel_id, nama_sub, bobot) VALUES ('$mapel_id','$nama','$bobot')");
        header("Location: sub-nilai.php?mapel_id=$mapel_id"); exit;
    }

    if ($aksi == "edit" && $_SERVER['REQUEST_METHOD']=="POST") {
        $id   = $_POST['id'];
        $nama = mysqli_real_escape_string($conn, $_POST['nama_sub']);
        $bobot= $_POST['bobot'];
        mysqli_query($conn, "UPDATE sub_nilai SET nama_sub='$nama', bobot='$bobot' WHERE id=$id");
        header("Location: sub-nilai.php?mapel_id=$mapel_id"); exit;
    }

    if ($aksi == "hapus" && isset($_GET['id'])) {
        $id = $_GET['id'];
        mysqli_query($conn, "DELETE FROM sub_nilai WHERE id=$id");
        header("Location: sub-nilai.php?mapel_id=$mapel_id"); exit;
    }
}
?>
