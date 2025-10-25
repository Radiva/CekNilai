<?php 
include "includes/header.php"; 

// hitung jumlah data
$jml_kelas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM kelas"))['jml'];
$jml_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"))['jml'];
$jml_mapel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM mapel"))['jml'];
$jml_nilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM nilai"))['jml'];
?>
<div class="container">
  <h2>Selamat Datang, Admin</h2>
  <p class="lead">Gunakan menu di sebelah kiri untuk mengelola data.</p>

  <div class="row mt-4">
    <div class="col-md-3">
      <div class="card text-bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Data Kelas</h5>
          <h3><?= $jml_kelas ?></h3>
          <p class="card-text">Jumlah kelas terdaftar</p>
          <a href="kelas.php" class="btn btn-light btn-sm">Kelola</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Data Siswa</h5>
          <h3><?= $jml_siswa ?></h3>
          <p class="card-text">Jumlah siswa terdaftar</p>
          <a href="siswa.php" class="btn btn-light btn-sm">Kelola</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Data Mapel</h5>
          <h3><?= $jml_mapel ?></h3>
          <p class="card-text">Jumlah mata pelajaran</p>
          <a href="mapel.php" class="btn btn-light btn-sm">Kelola</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Data Nilai</h5>
          <h3><?= $jml_nilai ?></h3>
          <p class="card-text">Jumlah nilai tersimpan</p>
          <a href="nilai.php" class="btn btn-light btn-sm">Kelola</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "includes/footer.php"; ?>
