<?php
include "../config/config.php";
include "../includes/header.php";

$mapel_id = $_GET['mapel_id'];
?>
<div class="container mt-4">
  <h3>Tambah Sub Nilai</h3>
  <form method="post" action="proses-sub.php?aksi=tambah&mapel_id=<?= $mapel_id ?>">
    <div class="mb-3">
      <label>Nama Sub Nilai</label>
      <input type="text" name="nama_sub" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Bobot (0 - 1)</label>
      <input type="number" step="0.01" name="bobot" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
  </form>
</div>
<?php include "../includes/footer.php"; ?>
