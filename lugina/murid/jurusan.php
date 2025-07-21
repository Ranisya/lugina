<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Ambil data jika sudah pernah diisi
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pilihan_jurusan WHERE akun_id='$id'"));

// Daftar jurusan yang tersedia
$daftar_jurusan = [
    "Teknik Permesinan",
    "Teknik Kendaraan Ringan",
    "Teknik Sepeda Motor",
    "Rekayasa Perangkat Lunak"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Memilih Jurusan - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-box">
            <h2 class="hero-section-title">🎓 Memilih Jurusan</h2>
            <p class="tagline">Silakan pilih jurusan yang kamu minati.</p>

            <form action="../proses/simpan_jurusan.php" method="POST" class="form-biodata">
                <input type="hidden" name="akun_id" value="<?= $id ?>">

                <div class="form-group">
                    <label for="pilihan_1">Pilihan Jurusan 1</label>
                    <select name="pilihan_1" id="pilihan_1" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php foreach ($daftar_jurusan as $j): ?>
                            <option value="<?= $j ?>" <?= (isset($data['pilihan_1']) && $data['pilihan_1'] == $j) ? 'selected' : '' ?>><?= $j ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pilihan_2">Pilihan Jurusan 2</label>
                    <select name="pilihan_2" id="pilihan_2">
                        <option value="">-- Pilih Jurusan (Opsional) --</option>
                        <?php foreach ($daftar_jurusan as $j): ?>
                            <option value="<?= $j ?>" <?= (isset($data['pilihan_2']) && $data['pilihan_2'] == $j) ? 'selected' : '' ?>><?= $j ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="text-align: center;">
                    <button type="submit" class="btn-submit">💾 Simpan & Lanjut</button>
                    <a href="dashboard.php" class="btn">🏠 Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
