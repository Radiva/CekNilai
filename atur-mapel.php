<?php
include "header.php";
include "config.php";
if (!isset($_SESSION['login'])) {
    header("Location: index.php?error=Silakan login dulu");
    exit;
}

$kelas_id = $_GET['kelas_id'] ?? 0;

// Ambil data kelas
$kelas = $conn->query("SELECT * FROM kelas WHERE id=$kelas_id")->fetch_assoc();

// Ambil semua mapel
$mapel = $conn->query("SELECT * FROM mapel ORDER BY nama_mapel");

// Ambil mapel yang sudah terhubung
$mapel_kelas = $conn->query("SELECT mapel_id FROM kelas_mapel WHERE kelas_id=$kelas_id");
$mapel_aktif = [];
while($row = $mapel_kelas->fetch_assoc()) {
    $mapel_aktif[] = $row['mapel_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pilihan = $_POST['mapel'] ?? [];

    // Hapus dulu semua mapel kelas
    $conn->query("DELETE FROM kelas_mapel WHERE kelas_id=$kelas_id");

    // Tambahkan yang baru
    foreach ($pilihan as $m) {
        $conn->query("INSERT INTO kelas_mapel (kelas_id, mapel_id) VALUES ($kelas_id, $m)");
    }

    header("Location: kelas.php");
    exit;
}
?>

<div class="container mt-4">
  <h3>Atur Mapel untuk <?= $kelas['nama_kelas'] ?></h3>

  <form method="post">
    <?php while($m = $mapel->fetch_assoc()) : ?>
        <label>
            <input type="checkbox" name="mapel[]" value="<?= $m['id'] ?>" 
                <?= in_array($m['id'], $mapel_aktif) ? 'checked' : '' ?>>
            <?= $m['nama_mapel'] ?>
        </label><br>
    <?php endwhile; ?>
    <br>
    <button type="submit">Simpan</button>
</form>
</div>
<?php include "footer.php"; ?>
