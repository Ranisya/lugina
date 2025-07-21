<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM akun_daftar ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Pendaftar</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>📄 Cetak Laporan Pendaftar</h2>
    <p>Dicetak pada: <?= date('d-m-Y H:i') ?></p>

    <a href="#" onclick="window.print();" class="btn-primary">🖨️ Cetak Halaman</a>

    <table class="data-table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>No. HP</th>
                <th>Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['no_hp']) ?></td>
                        <td>
                            <?php if ($row['status_verifikasi'] === 'sudah'): ?>
                                <span class="badge badge-sudah">Terverifikasi</span>
                            <?php else: ?>
                                <span class="badge badge-belum">Belum</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Tidak ada data pendaftar.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="back-wrap" style="margin-top: 30px;">
        <a href="dashboard.php" class="btn-back">⬅️ Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
