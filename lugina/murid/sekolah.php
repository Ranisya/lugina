<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Cek apakah sudah isi biodata, kalau belum, arahkan balik
$cek_biodata = mysqli_query($conn, "SELECT * FROM biodata_murid WHERE akun_id='$id'");
if (mysqli_num_rows($cek_biodata) === 0) {
    header("Location: biodata.php");
    exit;
}

// Ambil data sekolah jika sudah ada
$data_sekolah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_sekolah WHERE akun_id='$id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Sekolah - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <div class="form-container">
        <div class="form-box">
            <img src="../assets/img/lugina.jpg" alt="Logo Lugina" class="login-logo">
            <h2 class="hero-section-title">Data Sekolah</h2>
            <p class="tagline">Lengkapi informasi sekolah asal kamu dengan benar.</p>

            <form action="../proses/simpan_sekolah.php" method="POST" class="form-sekolah">
                <div class="form-group">
                    <label for="asal_sekolah">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" id="asal_sekolah" value="<?= $data_sekolah['asal_sekolah'] ?? '' ?>" required oninput="this.value = this.value.replace(/(^\w|\s\w)/g, m => m.toUpperCase())">
                </div>

                <div class="form-group">
                    <label for="alamat_sekolah">Alamat Sekolah</label>
                    <textarea name="alamat_sekolah" id="alamat_sekolah" required><?= $data_sekolah['alamat_sekolah'] ?? '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="tahun_lulus">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" id="tahun_lulus" value="<?= $data_sekolah['tahun_lulus'] ?? '' ?>" required>
                </div>

                <button type="submit" class="btn-submit">💾 Simpan & Lanjut</button>
                <div class="login-links">
                    <a href="dashboard.php">← Kembali ke Dashboard</a>
                    <?php if ($data_sekolah): ?>
                        | <a href="biodata.php">👈 Lihat Biodata</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
