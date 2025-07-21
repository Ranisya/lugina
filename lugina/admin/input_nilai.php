<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$akun_id = isset($_GET['akun_id']) ? intval($_GET['akun_id']) : 0;

// Ambil data akun
$query = "SELECT nama_lengkap FROM akun_daftar WHERE id = $akun_id";
$result = mysqli_query($conn, $query);
$data_akun = mysqli_fetch_assoc($result);

if (!$data_akun) {
    echo "Akun tidak ditemukan.";
    exit;
}

// Ambil data tes dari tabel hasil_seleksi
$tes = mysqli_query($conn, "SELECT * FROM hasil_seleksi WHERE akun_id = $akun_id");
$data_tes = mysqli_fetch_assoc($tes);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Nilai Tes - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>📝 Input Nilai Tes Seleksi</h2>
    <p>Silakan isi atau edit nilai tes untuk calon murid:</p>

    <div class="dashboard-box">
        <form action="simpan_nilai.php" method="post">
            <input type="hidden" name="akun_id" value="<?= $akun_id ?>">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" value="<?= htmlspecialchars($data_akun['nama_lengkap']) ?>" disabled>
            </div>

            <div class="form-group">
                <label>Nilai Tes</label>
                <input type="number" name="nilai_tes" min="0" max="100" value="<?= $data_tes['nilai_tes'] ?? '' ?>" required>
            </div>

            <button type="submit" class="btn-simpan">💾 Simpan Nilai</button>
        </form>
    </div>

    <div class="logout-wrap">
        <a href="proses_seleksi.php" class="btn-kembali">⬅️ Kembali ke Proses Seleksi</a>
    </div>
</div>
</body>
</html>
