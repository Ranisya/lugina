<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Proses verifikasi berkas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verifikasi'])) {
    $akun_id = intval($_POST['akun_id']);
    mysqli_query($conn, "UPDATE berkas_pendaftaran SET status_upload='sudah' WHERE akun_id=$akun_id");
    header("Location: verifikasi_berkas.php?berhasil");
    exit;
}

// Ambil data gabungan akun dan berkas
$query = "
    SELECT a.id, a.nama_lengkap, b.pas_foto, b.ijazah, b.kartu_keluarga, b.status_upload
    FROM akun_daftar a
    LEFT JOIN berkas_pendaftaran b ON a.id = b.akun_id
    ORDER BY a.nama_lengkap ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Berkas - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>📎 Verifikasi Berkas Pendaftar</h2>
    <p>Berikut adalah daftar berkas yang telah diunggah oleh calon murid:</p>

    <div class="dashboard-box">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Pas Foto</th>
                    <th>Ijazah</th>
                    <th>Kartu Keluarga</th>
                    <th>Status Berkas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) :
                    $foto   = $row['pas_foto'];
                    $ijazah = $row['ijazah'];
                    $kk     = $row['kartu_keluarga'];
                    $status = $row['status_upload'];
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= $foto ? "🖼️" : "❌" ?></td>
                    <td><?= $ijazah ? "📄" : "❌" ?></td>
                    <td><?= $kk ? "👨‍👩‍👧‍👦" : "❌" ?></td>
                    <td>
                        <?php if (!$foto && !$ijazah && !$kk): ?>
                            <span class="badge badge-belum">❌ Belum Upload</span>
                        <?php elseif ($status === 'sudah'): ?>
                            <span class="badge badge-sudah">✅ Terverifikasi</span>
                        <?php else: ?>
                            <span class="badge badge-menunggu">⏳ Menunggu Verifikasi</span>
                            <form method="post">
                                <input type="hidden" name="akun_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="verifikasi" class="btn-verifikasi">✔️ Verifikasi</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr><td colspan="6" style="text-align:center;">Belum ada data pendaftar.</td></tr>
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
