<?php
include "header.php";
include "config.php";
if (!isset($_SESSION['login'])) {
    header("Location: index.php?error=Silakan login dulu");
    exit;
}

// Ambil data kelas
$result = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id DESC");
?>

<div class="container mt-4">
  <h3>Data Kelas</h3>
  <a href="tambah-kelas.php" class="btn btn-primary mb-3">+ Tambah Kelas</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Kelas</th>
        <th>Mapel</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nama_kelas'] ?></td>
         <td>
            <a href="atur-mapel.php?kelas_id=<?= $row['id'] ?>">Atur Mapel</a>
        </td>
        <td>
          <a href="edit-kelas.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="proses-kelas.php?aksi=hapus&id=<?= $row['id'];  ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include "footer.php"; ?>
