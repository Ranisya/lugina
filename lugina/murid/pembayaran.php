<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM pembayaran WHERE akun_id='$id'");
$data_bayar = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Administrasi Pembayaran</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function formatRupiah(el) {
            let angka = el.value.replace(/[^,\d]/g, '').toString();
            let split = angka.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            el.value = 'Rp ' + rupiah + (split[1] ? ',' + split[1] : '');
        }
    </script>
</head>
<body>
<div class="form-container">
    <div class="form-box">
        <h2 class="hero-section-title">💸 Administrasi Pembayaran</h2>
        <p class="tagline">Silakan lakukan pembayaran dan upload bukti transfer kamu di sini.</p>

        <?php if ($data_bayar): ?>
            <div class="dashboard-box">
                <h3>📄 Bukti Pembayaran</h3>
                <p><strong>Tanggal Bayar:</strong> <?= htmlspecialchars($data_bayar['tanggal_bayar']) ?></p>
                <p><strong>Jumlah:</strong> Rp<?= number_format($data_bayar['jumlah'], 0, ',', '.') ?></p>
                <p><strong>Status Verifikasi:</strong>
                    <?= $data_bayar['status_verifikasi'] === 'sudah'
                        ? '<span class="verif-success">Terverifikasi</span>'
                        : '<span class="verif-warning">Menunggu Verifikasi</span>' ?>
                </p>
                <p><strong>Bukti Transfer:</strong></p>
                <img src="../uploads/<?= htmlspecialchars($data_bayar['bukti_transfer']) ?>" alt="Bukti Transfer" width="300" style="border-radius:8px;box-shadow:0 0 10px #ccc;">

                <?php if ($data_bayar['status_verifikasi'] === 'sudah'): ?>
                    <div style="margin-top: 20px;">
                        <a href="cetak_bukti.php" target="_blank" class="btn">🧾 Cetak Bukti Pembayaran</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <form action="../proses/simpan_pembayaran.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="akun_id" value="<?= $id ?>">

                <div class="form-group">
                    <label for="tanggal_bayar">Tanggal Pembayaran</label>
                    <input type="date" name="tanggal_bayar" id="tanggal_bayar" required>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah Bayar</label>
                    <input type="text" name="jumlah" id="jumlah" onkeyup="formatRupiah(this)" required placeholder="Contoh: 200000">
                </div>

                <div class="form-group">
                    <label for="bukti_transfer">Upload Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" accept="image/*" required>
                </div>

                <button type="submit" class="btn-submit">💾 Simpan & Selesai</button>
            </form>
        <?php endif; ?>

        <div class="login-links" style="margin-top: 30px;">
            <a href="dashboard.php">🔙 Kembali ke Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
