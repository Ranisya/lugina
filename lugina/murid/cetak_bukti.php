<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    die("Akses ditolak");
}

$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM pembayaran WHERE akun_id='$id' AND status_verifikasi='sudah'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan atau belum diverifikasi.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Bukti Pembayaran - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body onload="window.print()">
    <div class="form-container">
        <div class="form-box">
            <h2 class="hero-section-title">🧾 Bukti Pembayaran</h2>
            <p class="tagline">Berikut adalah rincian pembayaran kamu:</p>

            <div class="dashboard-box">
                <p><strong>Tanggal Pembayaran:</strong> <?= htmlspecialchars($data['tanggal_bayar']) ?></p>
                <p><strong>Jumlah:</strong> Rp<?= number_format($data['jumlah'], 0, ',', '.') ?></p>
                <p><strong>Status Verifikasi:</strong> <span class="verif-success">Terverifikasi</span></p>
            </div>

            <p style="margin-top: 20px;">Terima kasih telah melakukan pembayaran. Silakan simpan bukti ini sebagai arsip pribadi.</p>
        </div>
    </div>
</body>
</html>
