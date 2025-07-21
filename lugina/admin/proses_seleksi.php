<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data gabungan akun dan hasil seleksi
$query = "
    SELECT a.id AS akun_id, a.nama_lengkap, 
           h.nilai_tes, h.status_kelulusan
    FROM akun_daftar a
    LEFT JOIN hasil_seleksi h ON a.id = h.akun_id
    JOIN biodata_murid b ON a.id = b.akun_id
    ORDER BY a.nama_lengkap ASC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Seleksi - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>📝 Proses Seleksi Calon Murid</h2>
    <p>Berikut adalah data nilai tes dan status kelulusan calon murid:</p>

    <div class="dashboard-box">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Nilai Tes</th>
                    <th>Status Kelulusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) :
                    $nilaiTes = $row['nilai_tes'] ?? '-';
                    $status = $row['status_kelulusan'] ?? '⏳ Belum Diumumkan';
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= $nilaiTes ?></td>
                    <td>
                        <?php if ($status === 'lulus'): ?>
                            <span class="badge badge-sudah">🎉 Lulus</span>
                        <?php elseif ($status === 'tidak lulus'): ?>
                            <span class="badge badge-belum">❌ Tidak Lulus</span>
                        <?php else: ?>
                            <span class="badge badge-menunggu">⏳ Belum Diumumkan</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="input_nilai.php?akun_id=<?= $row['akun_id'] ?>" class="btn-verifikasi">✏️ Input / Edit</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr><td colspan="5" style="text-align:center;">Belum ada data pendaftar.</td></tr>
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
