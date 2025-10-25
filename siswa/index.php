<?php
include "../config/config.php";
include "../includes/header.php";

$siswa = mysqli_query($conn, "
    SELECT s.id, s.nis, s.nama, s.tgl_lahir, k.nama_kelas 
    FROM siswa s 
    LEFT JOIN kelas k ON s.kelas_id = k.id
    ORDER BY s.id ASC
");
?>
<div class="container mt-4">
    <h3>Data Siswa</h3>
    <a href="tambah-siswa.php" class="btn btn-primary mb-3">+ Tambah Siswa</a>

    <a href="import-siswa.php" class="btn btn-primary mb-3">+ Import Siswa</a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($siswa)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nis'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['tgl_lahir'] ?></td>
            <td><?= $row['nama_kelas'] ?></td>
            <td>
                <a href="edit-siswa.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="proses-siswa.php?aksi=hapus&id=<?= $row['id'] ?>" 
                   onclick="return confirm('Yakin hapus siswa ini?')" 
                   class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include "../includes/footer.php"; ?>
