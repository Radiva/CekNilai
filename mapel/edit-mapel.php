<?php
include "../config/config.php";
include "../includes/header.php";

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM mapel WHERE id=$id");
$m = mysqli_fetch_assoc($data);
?>
<div class="container mt-4">
  <h3>Edit Mapel</h3>
  <form method="post" action="proses-mapel.php?aksi=edit">
    <input type="hidden" name="id" value="<?= $m['id'] ?>">
    <div class="mb-3">
      <label>Nama Mapel</label>
      <input type="text" name="nama_mapel" value="<?= $m['nama_mapel'] ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
<?php include "../includes/footer.php"; ?>
