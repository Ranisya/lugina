<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM data_orangtua WHERE akun_id='$id'");
$data = mysqli_fetch_assoc($query);

$penghasilan_opsi = [
    'Kurang dari 500.000',
    '500.000 – 1.000.000',
    '1.000.000 – 2.000.000',
    '2.000.000 – 3.000.000',
    'Di atas 3.000.000'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Orang Tua</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
    function capitalize(input) {
        input.value = input.value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
    </script>
</head>
<body>
    <div class="form-container">
        <div class="form-box">
            <img src="../assets/img/lugina.jpg" class="login-logo">
            <h2 class="hero-section-title">👪 Data Orang Tua</h2>
            <p class="tagline">Lengkapi data orang tua kamu di bawah ini.</p>

            <form action="../proses/simpan_orangtua.php" method="POST" class="form-biodata">
                <input type="hidden" name="akun_id" value="<?= $id ?>">

                <div class="form-group">
                    <label>Nama Ayah</label>
                    <input type="text" name="nama_ayah" required oninput="capitalize(this)" value="<?= $data['nama_ayah'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>NIK Ayah</label>
                    <input type="text" name="nik_ayah" required value="<?= $data['nik_ayah'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" required oninput="capitalize(this)" value="<?= $data['pekerjaan_ayah'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Penghasilan Ayah</label>
                    <select name="penghasilan_ayah" required>
                        <option value="">-- Pilih Penghasilan --</option>
                        <?php foreach ($penghasilan_opsi as $opt): ?>
                            <option value="<?= $opt ?>" <?= (isset($data['penghasilan_ayah']) && $data['penghasilan_ayah'] == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text" name="nama_ibu" required oninput="capitalize(this)" value="<?= $data['nama_ibu'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>NIK Ibu</label>
                    <input type="text" name="nik_ibu" required value="<?= $data['nik_ibu'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" required oninput="capitalize(this)" value="<?= $data['pekerjaan_ibu'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Penghasilan Ibu</label>
                    <select name="penghasilan_ibu" required>
                        <option value="">-- Pilih Penghasilan --</option>
                        <?php foreach ($penghasilan_opsi as $opt): ?>
                            <option value="<?= $opt ?>" <?= (isset($data['penghasilan_ibu']) && $data['penghasilan_ibu'] == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>No. HP Orang Tua</label>
                    <input type="text" name="no_hp_ortu" required value="<?= $data['no_hp_ortu'] ?? '' ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <button type="submit" class="btn-submit">💾 Simpan & Lanjut</button>
                <div class="login-links">
                    <a href="dashboard.php">⬅️ Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
