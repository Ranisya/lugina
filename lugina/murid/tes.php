<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Ambil data hasil tes berdasarkan akun_id
$query = "SELECT * FROM hasil_seleksi WHERE akun_id = '$id'";
$result = mysqli_query($conn, $query);

$hasil = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Tes - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-section">
        <h2 class="hero-section-title">📊 Hasil Tes Seleksi</h2>
        <p class="hero-desc">Berikut adalah hasil tes seleksi kamu:</p>

        <?php if ($hasil): ?>
            <div class="dashboard-box">
                <?php if (!empty($hasil['nilai_tes'])): ?>
                    <p><strong>Nilai Tes:</strong> <?= htmlspecialchars($hasil['nilai_tes']) ?></p>
                <?php endif; ?>

                <p><strong>Status Kelulusan:</strong> 
                    <?php if ($hasil['status_kelulusan'] === 'lulus'): ?>
                        <span class="badge-verif">✅ Lulus</span>
                    <?php elseif ($hasil['status_kelulusan'] === 'tidak lulus'): ?>
                        <span class="badge-unverif">❌ Tidak Lulus</span>
                    <?php else: ?>
                        <span class="badge-pending">⏳ Belum Dinilai</span>
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="alert-box">
                ⏳ Hasil tes kamu belum tersedia. Silakan cek kembali nanti.
            </div>
        <?php endif; ?>

        <div style="margin-top: 30px;">
            <a href="dashboard.php" class="btn">⬅️ Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
