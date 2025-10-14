<?php
include "config.php";
include "header.php";

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM siswa WHERE id=$id");
$s = mysqli_fetch_assoc($data);

$kelas = mysqli_query($conn, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
?>
<div class="container mt-4">
    <h3>Edit Siswa</h3>
    <form method="post" action="proses-siswa.php?aksi=edit">
        <input type="hidden" name="id" value="<?= $s['id'] ?>">
        <div class="mb-3">
            <label>NIS</label>
            <input type="text" name="nis" value="<?= $s['nis'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $s['nama'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?= $s['tgl_lahir'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control" required>
                <?php while($k = mysqli_fetch_assoc($kelas)): ?>
                    <option value="<?= $k['id'] ?>" <?= ($s['kelas_id']==$k['id'])?'selected':'' ?>>
                        <?= $k['nama_kelas'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?php include "footer.php"; ?>
