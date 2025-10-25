<?php
include "config/config.php"; 
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

global $BASE_URL;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Nilai - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <div class="bg-dark text-white p-3 sidebar" style="width:220px; min-height:100vh;">
    <h4 class="mb-4">Admin Panel</h4>
    <ul class="nav flex-column">
      <li class="nav-item"><a href="<?= $BASE_URL ?>dashboard.php" class="nav-link text-white">🏠 Dashboard</a></li>
      <li class="nav-item"><a href="<?= $BASE_URL ?>kelas" class="nav-link text-white">📚 Data Kelas</a></li>
      <li class="nav-item"><a href="<?= $BASE_URL ?>siswa" class="nav-link text-white">👨‍🎓 Data Siswa</a></li>
      <li class="nav-item"><a href="<?= $BASE_URL ?>mapel" class="nav-link text-white">📖 Data Mapel</a></li>
      <li class="nav-item"><a href="<?= $BASE_URL ?>input-nilai.php" class="nav-link text-white">📝 Data Nilai</a></li>
      <li class="nav-item mt-3"><a href="logout.php" class="btn btn-danger w-100">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="flex-grow-1 p-4">
