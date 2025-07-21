<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Ambil data akun dan biodata
$akun = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM akun_daftar WHERE id='$id'"));
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM biodata_murid WHERE akun_id='$id'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Biodata</title>
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
            <h2 class="hero-section-title">Biodata</h2>
            <p class="hero-desc">Isi data pribadi kamu dengan lengkap dan benar ya.</p>

            <form action="../proses/simpan_biodata.php" method="POST" class="form-biodata">
                <input type="hidden" name="akun_id" value="<?= $id ?>">

                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" required
                        value="<?= htmlspecialchars($data['nik'] ?? '') ?>"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" id="nisn" name="nisn" required
                        value="<?= htmlspecialchars($data['nisn'] ?? '') ?>"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" required
                        value="<?= htmlspecialchars($data['tempat_lahir'] ?? '') ?>"
                        oninput="capitalize(this)">
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                        value="<?= $data['tanggal_lahir'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" <?= ($data['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($data['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="agama">Agama</label>
                    <select name="agama" id="agama" required>
                        <option value="">-- Pilih Agama --</option>
                        <?php
                        $agama_list = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'];
                        foreach ($agama_list as $agama) {
                            $selected = ($data['agama'] ?? '') === $agama ? 'selected' : '';
                            echo "<option value='$agama' $selected>$agama</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" required><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP</label>
                    <input type="text" id="no_hp" name="no_hp" required
                        value="<?= htmlspecialchars($data['no_hp'] ?? $akun['whatsapp'] ?? '') ?>"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>

                <button type="submit" class="btn-submit">💾 Simpan & Lanjut</button>
            </form>

            <div class="login-links" style="margin-top: 30px;">
                <a href="dashboard.php">🔙 Kembali ke Dashboard</a>
                <?php if ($data) : ?>
                    | <a href="#biodata-lama">👁️ Lihat Data Sebelumnya</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
