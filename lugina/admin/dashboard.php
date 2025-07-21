<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_nama = $_SESSION['admin_nama'];

// Ambil data statistik
$jumlah_pendaftar   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM akun_daftar"))['total'];
$belum_verif_akun   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM akun_daftar WHERE status_verifikasi != 'sudah'"))['total'];
$berkas_masuk       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM berkas_pendaftaran"))['total'];
$pembayaran_masuk   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pembayaran WHERE status_verifikasi = 'sudah'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>👋 Selamat Datang, <?= htmlspecialchars($admin_nama) ?></h2>
    <p>Berikut ini ringkasan data pendaftaran murid SMK Lugina:</p>

    <div class="dashboard-box">
        <h3>📊 Statistik Pendaftaran</h3>
        <ul>
            <li>👥 Total Pendaftar: <strong><?= $jumlah_pendaftar ?> murid</strong></li>
            <li>📑 Belum Diverifikasi Akun: <strong><?= $belum_verif_akun ?> murid</strong></li>
            <li>📎 Berkas Masuk: <strong><?= $berkas_masuk ?> berkas</strong></li>
            <li>💵 Pembayaran Masuk: <strong><?= $pembayaran_masuk ?> transaksi</strong></li>
        </ul>
    </div>

    <div class="dashboard-box">
        <h3>📂 Menu Navigasi</h3>
        <ul>
            <li><a href="pendaftar.php" class="step-link">📋 Data Pendaftar</a></li>
            <li><a href="verifikasi_berkas.php" class="step-link">📎 Verifikasi Berkas</a></li>
            <li><a href="verifikasi_pembayaran.php" class="step-link">💰 Verifikasi Pembayaran</a></li>
            <li><a href="proses_seleksi.php" class="step-link">📝 Proses Seleksi</a></li>
            <li><a href="laporan.php" class="step-link">📄 Laporan Pendaftaran</a></li>
        </ul>
    </div>

    <div class="logout-wrap">
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</div>
</body>
</html>
