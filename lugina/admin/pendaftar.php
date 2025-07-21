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
    <title>Data Pendaftar - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>📋 Data Pendaftar Akun</h2>
    <p>Berikut adalah daftar calon murid yang telah mendaftar akun:</p>

    <div class="dashboard-box">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>No. HP</th>
                    <th>Status Verifikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($row['no_hp']) ?></td>
                            <td>
                                <?php if ($row['status_verifikasi'] === 'sudah'): ?>
                                    <span class="badge badge-sudah">✅ Terverifikasi</span>
                                <?php else: ?>
                                    <span class="badge badge-belum">❌ Belum</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status_verifikasi'] !== 'sudah'): ?>
                                    <a href="ubah_status_akun.php?id=<?= $row['id'] ?>" class="btn-verifikasi">✔️ Verifikasi</a>
                                <?php else: ?>
                                    <em>✔️ Sudah</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center;">Belum ada pendaftar.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="logout-wrap">
        <a href="dashboard.php" class="btn-kembali">⬅️ Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
