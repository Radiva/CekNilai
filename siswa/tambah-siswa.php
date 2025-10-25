<?php
include "../config/config.php";
include "../includes/header.php";

$kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
?>
<div class="container mt-4">
    <h3>Tambah Siswa</h3>
    <form method="post" action="proses-siswa.php?aksi=tambah">
        <div class="mb-3">
            <label>NIS</label>
            <input type="text" name="nis" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php while($k = mysqli_fetch_assoc($kelas)): ?>
                    <option value="<?= $k['id'] ?>"><?= $k['nama_kelas'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
<?php include "../includes/footer.php"; ?>
