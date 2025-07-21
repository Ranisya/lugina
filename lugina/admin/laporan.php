<?php
include '../config/koneksi.php';

// Ambil semua data murid dari tabel akun_daftar
$sql = "SELECT ad.id, ad.nama_lengkap, ad.username, ad.no_hp, ad.status_verifikasi, ad.tanggal_daftar,
               bm.nik, bm.nisn, bm.tempat_lahir,
               bp.pas_foto, bp.ijazah, bp.kartu_keluarga, bp.status_upload
        FROM akun_daftar ad
        LEFT JOIN biodata_murid bm ON ad.id = bm.akun_id
        LEFT JOIN berkas_pendaftaran bp ON ad.id = bp.akun_id
        ORDER BY ad.tanggal_daftar DESC";

$query = mysqli_query($conn, $sql) or die("Query error: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendaftaran - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>📋 Laporan Pendaftaran Murid</h2>
    <a href="cetak_laporan.php" class="btn-utama" target="_blank">🖨️ Cetak Laporan</a>

    <div class="dashboard-box">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>No HP</th>
                    <th>Status Verifikasi</th>
                    <th>Tanggal Daftar</th>
                    <th>NIK</th>
                    <th>NISN</th>
                    <th>Tempat Lahir</th>
                    <th>Berkas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) :
                    $berkasLengkap = $row['pas_foto'] || $row['ijazah'] || $row['kartu_keluarga'];
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['status_verifikasi']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_daftar']) ?></td>
                    <td><?= htmlspecialchars($row['nik'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['nisn'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['tempat_lahir'] ?? '-') ?></td>
                    <td>
                        <?php if ($berkasLengkap): ?>
                            <span class="badge badge-sudah">Berkas ✅</span>
                        <?php else: ?>
                            <span class="badge badge-belum">Belum</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($query) === 0): ?>
                    <tr><td colspan="10" style="text-align:center;">Belum ada data murid.</td></tr>
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
