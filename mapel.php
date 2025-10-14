<?php
include "config.php";
include "header.php";

$mapel = mysqli_query($conn, "SELECT * FROM mapel ORDER BY nama_mapel ASC");
?>
<div class="container mt-4">
  <h3>Data Mata Pelajaran</h3>
  <a href="tambah-mapel.php" class="btn btn-primary mb-3">+ Tambah Mapel</a>
  <table class="table table-bordered">
    <tr>
      <th>ID</th>
      <th>Nama Mapel</th>
      <th>Aksi</th>
    </tr>
    <?php while($m = mysqli_fetch_assoc($mapel)): ?>
    <tr>
      <td><?= $m['id'] ?></td>
      <td><?= $m['nama_mapel'] ?></td>
      <td>
        <a href="edit-mapel.php?id=<?= $m['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="proses-mapel.php?aksi=hapus&id=<?= $m['id'] ?>" onclick="return confirm('Hapus mapel ini?')" class="btn btn-danger btn-sm">Hapus</a>
        <a href="sub-nilai.php?mapel_id=<?= $m['id'] ?>" class="btn btn-info btn-sm">Kelola Sub Nilai</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
<?php include "footer.php"; ?>
