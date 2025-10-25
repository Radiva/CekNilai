<?php
include "../config/config.php";
include "../includes/header.php";

$mapel_id = $_GET['mapel_id'];
$mapel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mapel WHERE id=$mapel_id"));
$sub = mysqli_query($conn, "SELECT * FROM sub_nilai WHERE mapel_id=$mapel_id");
?>
<div class="container mt-4">
  <h3>Sub Nilai - <?= $mapel['nama_mapel'] ?></h3>
  <a href="tambah-sub.php?mapel_id=<?= $mapel_id ?>" class="btn btn-primary mb-3">+ Tambah Sub Nilai</a>
  <table class="table table-bordered">
    <tr>
      <th>ID</th>
      <th>Nama Sub</th>
      <th>Bobot</th>
      <th>Aksi</th>
    </tr>
    <?php while($s = mysqli_fetch_assoc($sub)): ?>
    <tr>
      <td><?= $s['id'] ?></td>
      <td><?= $s['nama_sub'] ?></td>
      <td><?= $s['bobot'] * 100 ?>%</td>
      <td>
        <a href="edit-sub.php?id=<?= $s['id'] ?>&mapel_id=<?= $mapel_id ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="proses-sub.php?aksi=hapus&id=<?= $s['id'] ?>&mapel_id=<?= $mapel_id ?>" 
           onclick="return confirm('Hapus sub nilai ini?')" 
           class="btn btn-danger btn-sm">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  <a href="mapel.php" class="btn btn-secondary">Kembali</a>
</div>
<?php include "../includes/footer.php"; ?>
