<?php
include "config.php";
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']['tmp_name'])) {
    $file = $_FILES['file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== FALSE) {
        $row = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $row++;
            if ($row == 1) continue; // skip header

            $nis       = mysqli_real_escape_string($conn, $data[0]);
            $nama      = mysqli_real_escape_string($conn, $data[1]);
            $tgl_lahir = mysqli_real_escape_string($conn, $data[2]);
            $kelasNama = mysqli_real_escape_string($conn, $data[3]);

            // cek kelas, buat jika belum ada
            $q = mysqli_query($conn, "SELECT id FROM kelas WHERE nama_kelas='$kelasNama'");
            if (mysqli_num_rows($q) > 0) {
                $kelas = mysqli_fetch_assoc($q);
                $kelas_id = $kelas['id'];
            } else {
                mysqli_query($conn, "INSERT INTO kelas (nama_kelas) VALUES ('$kelasNama')");
                $kelas_id = mysqli_insert_id($conn);
            }

            // cek apakah NIS sudah ada
            $cek = mysqli_query($conn, "SELECT id FROM siswa WHERE nis='$nis'");
            if (mysqli_num_rows($cek) == 0) {
                mysqli_query($conn, "INSERT INTO siswa (nis, nama, tgl_lahir, kelas_id) 
                    VALUES ('$nis', '$nama', '$tgl_lahir', '$kelas_id')");
            }
        }
        fclose($handle);
        $msg = "✅ Import selesai.";
    } else {
        $msg = "❌ Gagal membaca file.";
    }
}
?>

<body>
    <h2>Import Data Siswa dari CSV</h2>
    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>
    <form method="post" enctype="multipart/form-data">
        <p>Pilih file CSV (format: nis,nama,tgl_lahir,kelas):</p>
        <input type="file" name="file" accept=".csv" required>
        <br><br>
        <button type="submit">Upload & Import</button>
    </form>
    <br>
    <a href="siswa.php">⬅ Kembali ke Data Siswa</a>

<?php include 'footer.php' ?>
