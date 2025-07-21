<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berkas_pendaftaran WHERE akun_id='$id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Berkas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="form-section">
    <h2 class="hero-section-title">📎 Upload Berkas</h2>
    <p class="hero-desc">Silakan upload file berkas berikut dalam format .jpg, .jpeg, atau .pdf (maks. 1MB)</p>

    <form action="../proses/simpan_berkas.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="akun_id" value="<?= $id ?>">

        <div class="form-group">
            <label for="pas_foto">Pas Foto 3x4</label>
            <input type="file" name="pas_foto" id="pas_foto" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        <div class="form-group">
            <label for="ijazah">Scan Ijazah</label>
            <input type="file" name="ijazah" id="ijazah" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        <div class="form-group">
            <label for="kk">Kartu Keluarga</label>
            <input type="file" name="kartu_keluarga" id="kk" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        <button type="submit" class="btn-submit">💾 Simpan & Lanjut</button>
    </form>
</div>
</body>
</html>
