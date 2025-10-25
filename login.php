<?php include "config/config.php"; 
session_start();

// Jika sudah login → langsung ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Admin/Guru</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Login</h4>
        </div>
        <div class="card-body">
          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= $_GET['error'] ?></div>
          <?php endif; ?>
          <form method="post" action="proses-login.php">
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
      </div>
      <div class="text-center mt-3">
        <a href="cek-nilai.php">Cek Nilai Siswa</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
