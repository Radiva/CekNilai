<?php
include 'config.php';
include 'header.php';

$kelas_id = $_GET['kelas_id'] ?? 0;
$mapel_id = $_GET['mapel_id'] ?? 0;

// Ambil data kelas & mapel
$kelas = $conn->query("SELECT * FROM kelas WHERE id=$kelas_id")->fetch_assoc();
$mapel = $conn->query("SELECT * FROM mapel WHERE id=$mapel_id")->fetch_assoc();

// Ambil siswa di kelas
$siswa = $conn->query("SELECT * FROM siswa WHERE kelas_id=$kelas_id ORDER BY nama");

// Ambil sub mapel
$sub = $conn->query("SELECT * FROM sub_nilai WHERE mapel_id=$mapel_id ORDER BY id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['nilai'] as $siswa_id => $data) {
        foreach ($data as $sub_id => $nilaiData) {
            $nilai = $nilaiData['nilai'] !== '' ? $nilaiData['nilai'] : NULL;
            $keterangan = $nilaiData['keterangan'];
            if ($nilai !== NULL) {
                // Cek apakah sudah ada
                $cek = $conn->query("SELECT id FROM nilai WHERE siswa_id=$siswa_id AND sub_id=$sub_id");
                if ($cek->num_rows > 0) {
                    $row = $cek->fetch_assoc();
                    $conn->query("UPDATE nilai SET nilai=$nilai, keterangan='$keterangan' WHERE id=".$row['id']);
                } else {
                    $conn->query("INSERT INTO nilai (siswa_id, sub_id, nilai, keterangan) VALUES ($siswa_id, $sub_id, $nilai, '$keterangan')");
                }
            }
        }
    }
    header("Location: input-nilai-kelas.php?kelas_id=$kelas_id&mapel_id=$mapel_id&success=1");
    exit;
}
?>

<h2>Input Nilai: <?= $mapel['nama_mapel'] ?> (<?= $kelas['nama_kelas'] ?>)</h2>

<?php if(isset($_GET['success'])) echo "<p style='color:green'>Nilai berhasil disimpan!</p>"; ?>

<form method="post">
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>Nama Siswa</th>
        <?php 
        $sub_list = [];
        while($s = $sub->fetch_assoc()): 
            $sub_list[] = $s; 
        ?>
            <th style="text-align:center"><?= $s['nama_sub'] ?> <br /> (Bobot: <?= $s['bobot'] ?>)</th>
            <th style="text-align:center"><?= $s['nama_sub'] ?> <br /> (Keterangan)</th>
        <?php endwhile; ?>
        <th>Total Nilai</th>
    </tr>
    <?php
    $siswa->data_seek(0);
    while($sis = $siswa->fetch_assoc()):
        $total_nilai = 0;
        $total_bobot = 0;
    ?>
    <tr>
        <td><?= $sis['nama'] ?></td>
        <?php foreach($sub_list as $s): 
            $nilaiRow = $conn->query("SELECT nilai, keterangan FROM nilai WHERE siswa_id={$sis['id']} AND sub_id={$s['id']}")->fetch_assoc();
            $nilai = $nilaiRow['nilai'] ?? '';
            $keterangan = $nilaiRow['keterangan'] ?? '';
            if ($nilai !== '') {
                $total_nilai += $nilai * $s['bobot'];
                $total_bobot += $s['bobot'];
            }
        ?>
            <td>
                <input type="number" step="0.01" name="nilai[<?= $sis['id'] ?>][<?= $s['id'] ?>][nilai]" 
                       value="<?= $nilai ?>">
            </td>
            <td>
                <input type="text" name="nilai[<?= $sis['id'] ?>][<?= $s['id'] ?>][keterangan]" value="<?= htmlspecialchars($keterangan) ?>" style="width:150px">
            </td>
        <?php endforeach; ?>
        <td>
            <strong>
                <?= $total_bobot > 0 ? round($total_nilai / $total_bobot, 2) : '-' ?>
            </strong>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<button type="submit">Simpan Semua Nilai</button>
</form>

<?php include 'footer.php'; ?>
