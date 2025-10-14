<?php
include 'config.php';

$error = '';
$data_siswa = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = $_POST['nis'];
    $tgl_lahir = $_POST['tgl_lahir'];

    // Cari siswa
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE nis=? AND tgl_lahir=?");
    $stmt->bind_param("ss", $nis, $tgl_lahir);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_siswa = $result->fetch_assoc();

    if (!$data_siswa) {
        $error = "Data siswa tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cek Nilai Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        form {
            text-align: center;
            margin-top: 20px;
        }
        form input, form button {
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            background: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }
        form button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .info {
            margin: 20px 0;
            padding: 15px;
            background: #e9f7ef;
            border-left: 4px solid #28a745;
        }
        h3 {
            margin-top: 25px;
            color: #444;
        }
        h4 {
            margin-bottom: 8px;
            margin-top: 20px;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .total-row {
            background: #e9ecef;
            font-weight: bold;
        }
        .print-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 14px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .print-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="container">
<h2>Cek Nilai Siswa</h2>

<?php if(!$data_siswa): ?>
    <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        <label>NIS:</label><br>
        <input type="text" name="nis" required><br><br>
        <label>Tanggal Lahir:</label><br>
        <input type="date" name="tgl_lahir" required><br><br>
        <button type="submit">Cek Nilai</button>
    </form>

<?php else: ?>
    <h3>Data Siswa</h3>
    <p><strong>Nama:</strong> <?= htmlspecialchars($data_siswa['nama']) ?></p>
    <p><strong>NIS:</strong> <?= htmlspecialchars($data_siswa['nis']) ?></p>
    <p><strong>Kelas:</strong> 
        <?php
        $kelas = $conn->query("SELECT * FROM kelas WHERE id=".$data_siswa['kelas_id'])->fetch_assoc();
        echo htmlspecialchars($kelas['nama_kelas']);
        ?>
    </p>

    <h3>Nilai</h3>
    <?php
    // Ambil semua mapel untuk kelas siswa
    $mapel_q = $conn->query("
        SELECT DISTINCT m.id, m.nama_mapel 
        FROM mapel m 
        JOIN kelas_mapel km ON km.mapel_id = m.id
        WHERE km.kelas_id = ".$data_siswa['kelas_id']."
    ");

    while($mapel = $mapel_q->fetch_assoc()):
        echo "<h4>".htmlspecialchars($mapel['nama_mapel'])."</h4>";
        echo "<table>";
        echo "<tr><th>Sub Nilai</th><th>Nilai</th><th>Keterangan</th></tr>";

        $sub_q = $conn->query("SELECT * FROM sub_nilai WHERE mapel_id=".$mapel['id']);
        $total_nilai = 0;
        $total_bobot = 0;

        while($sub = $sub_q->fetch_assoc()):
            $nilaiRow = $conn->query("
                SELECT nilai, keterangan 
                FROM nilai 
                WHERE siswa_id={$data_siswa['id']} AND sub_id={$sub['id']}
            ")->fetch_assoc();

            $nilai = $nilaiRow['nilai'] ?? '-';
            $ket   = $nilaiRow['keterangan'] ?? '';

            if ($nilai !== '-' && $nilai !== null) {
                $total_nilai += $nilai * $sub['bobot'];
                $total_bobot += $sub['bobot'];
            }
    ?>
        <tr>
            <td><?= htmlspecialchars($sub['nama_sub']) ?></td>
            <td><?= $nilai ?></td>
            <td><?= htmlspecialchars($ket) ?></td>
        </tr>
    <?php endwhile; ?>
        <tr>
            <td colspan="2"><strong>Total Nilai</strong></td>
            <td><strong><?= $total_bobot > 0 ? round($total_nilai / $total_bobot, 2) : '-' ?></strong></td>
        </tr>
        </table>
    <?php endwhile; ?>
<?php endif; ?>

</body>
          </div>
</html>
