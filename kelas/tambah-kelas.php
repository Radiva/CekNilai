<?php 
include "../includes/header.php";
include "../config/config.php"; 
?>
<div class="container mt-4">
  <h3>Tambah Kelas</h3>
  <a href="kelas.php" class="btn btn-secondary mb-3">← Kembali</a>

  <form method="post" action="proses-kelas.php?aksi=tambah">
    <div class="mb-3">
      <label>Nama Kelas</label>
      <input type="text" name="nama_kelas" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>
</div>
<?php 
include "../includes/footer.php";
?>
