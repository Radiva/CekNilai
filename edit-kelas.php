<?php
include "header.php";
include "config.php";
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kelas WHERE id=$id");
$kelas = mysqli_fetch_assoc($data);
?>
<div class="container mt-4">
  <h3>Edit Kelas</h3>
  <a href="kelas.php" class="btn btn-secondary mb-3">← Kembali</a>

  <form method="post" action="proses-kelas.php?aksi=edit">
    <input type="hidden" name="id" value="<?= $kelas['id']; ?>">
    <div class="mb-3">
      <label>Nama Kelas</label>
      <input type="text" name="nama_kelas" value="<?= $kelas['nama_kelas']; ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>

<?php
include "footer.php";
?>
