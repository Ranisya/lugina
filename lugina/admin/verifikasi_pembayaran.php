<?php
session_start();
include '../config/koneksi.php';

// Proses verifikasi pembayaran
if (isset($_POST['verifikasi_id'])) {
    $id = $_POST['verifikasi_id'];
    mysqli_query($conn, "UPDATE pembayaran SET status_verifikasi = 'sudah' WHERE id='$id'");
}

// Ambil data pembayaran + nama murid
$query = "
    SELECT p.id, a.nama_lengkap, p.tanggal_bayar, p.jumlah, p.bukti_transfer, p.status_verifikasi 
    FROM pembayaran p 
    JOIN akun_daftar a ON p.akun_id = a.id
    ORDER BY p.id ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Pembayaran</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>💰 Verifikasi Pembayaran</h2>
        <p>Berikut adalah daftar pembayaran yang dilakukan oleh calon murid:</p>

        <table class="tabel-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah</th>
                    <th>Bukti Transfer</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= $row['tanggal_bayar'] ?: '-' ?></td>
                    <td><?= $row['jumlah'] ? 'Rp ' . number_format($row['jumlah'], 0, ',', '.') : '-' ?></td>
                    <td>
                        <?php if ($row['bukti_transfer']) : ?>
                            <a href="../uploads/<?= $row['bukti_transfer'] ?>" target="_blank">🖼️</a>
                        <?php else : ?>
                            ❌
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['status_verifikasi'] === 'sudah') : ?>
                            <span class="badge badge-sukses">✅ Terverifikasi</span>
                        <?php elseif ($row['status_verifikasi'] === 'proses') : ?>
                            <span class="badge badge-warning">⏳ Menunggu Verifikasi</span>
                        <?php else : ?>
                            <span class="badge badge-gagal">❌ Belum Upload</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['status_verifikasi'] !== 'sudah' && $row['bukti_transfer']) : ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="verifikasi_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn-verifikasi">✔️ Verifikasi</button>
                        </form>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <br>
        <a href="dashboard.php" class="btn-kembali">⬅️ Kembali ke Dashboard</a>
    </div>
</body>
</html>
