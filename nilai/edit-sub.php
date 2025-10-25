<?php
include "../config/config.php";
include "../includes/header.php";

$id = $_GET['id'];
$mapel_id = $_GET['mapel_id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sub_nilai WHERE id=$id"));
?>
<div class="container mt-4">
  <h3>Edit Sub Nilai</h3>
  <form method="post" action="proses-sub.php?aksi=edit&mapel_id=<?= $mapel_id ?>">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <div class="mb-3">
      <label>Nama Sub Nilai</label>
      <input type="text" name="nama_sub" value="<?= $data['nama_sub'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Bobot (0 - 1)</label>
      <input type="number" step="0.01" name="bobot" value="<?= $data['bobot'] ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
<?php include "../includes/footer.php"; ?>
