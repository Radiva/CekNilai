<?php include "header.php"; ?>
<div class="container mt-4">
  <h3>Tambah Mata Pelajaran</h3>
  <form method="post" action="proses-mapel.php?aksi=tambah">
    <div class="mb-3">
      <label>Nama Mapel</label>
      <input type="text" name="nama_mapel" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
  </form>
</div>
<?php include "footer.php"; ?>
