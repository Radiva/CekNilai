<?php
include 'config.php';
include 'header.php';

// Ambil semua kelas
$kelas = $conn->query("SELECT * FROM kelas ORDER BY nama_kelas");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas_id = $_POST['kelas_id'];
    $mapel_id = $_POST['mapel_id'];
    header("Location: input-nilai-kelas.php?kelas_id=$kelas_id&mapel_id=$mapel_id");
    exit;
}
?>

<h2>Input Nilai Kolektif</h2>

<form method="post">
    <label>Pilih Kelas:</label><br>
    <select name="kelas_id" required>
        <option value="">-- Pilih Kelas --</option>
        <?php while($k = $kelas->fetch_assoc()): ?>
            <option value="<?= $k['id'] ?>"><?= $k['nama_kelas'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Pilih Mapel:</label><br>
    <select name="mapel_id" required>
        <option value="">-- Pilih Mapel --</option>
        <?php
        $mapel = $conn->query("SELECT * FROM mapel ORDER BY nama_mapel");
        while($m = $mapel->fetch_assoc()):
        ?>
            <option value="<?= $m['id'] ?>"><?= $m['nama_mapel'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Lanjut</button>
</form>

<?php include 'footer.php'; ?>
