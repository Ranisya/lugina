<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

$akun           = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM akun_daftar WHERE id='$id'"));
$data_biodata   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM biodata_murid WHERE akun_id='$id'"));
$data_sekolah   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_sekolah WHERE akun_id='$id'"));
$data_ortu      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM data_orangtua WHERE akun_id='$id'"));
$data_jurusan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pilihan_jurusan WHERE akun_id='$id'"));
$data_berkas    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berkas_pendaftaran WHERE akun_id='$id'"));
$data_seleksi   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hasil_seleksi WHERE akun_id='$id'"));
$data_bayar     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pembayaran WHERE akun_id='$id'"));

$status_text  = ($akun['status_verifikasi'] === 'sudah') ? 'Terverifikasi' : 'Belum Terverifikasi';
$status_class = ($akun['status_verifikasi'] === 'sudah') ? 'verif-success' : 'verif-failed';

function langkah($nomor, $nama, $data, $link, $opsi = '') {
    if ($nama === 'Upload Berkas') {
        if ($data) {
            if ($data['status_upload'] === 'sudah') {
                $status = '<span class="verif-success">✅ Terverifikasi</span>';
            } elseif ($data['status_upload'] === 'proses') {
                $status = '<span class="verif-pending">⏳ Menunggu Verifikasi</span>';
            } else {
                $status = '<span class="verif-failed">❌ Belum diisi</span>';
            }
        } else {
            $status = '<span class="verif-failed">❌ Belum diisi</span>';
        }
    } elseif ($opsi === 'verif') {
        if (!$data) {
            $status = '<span class="verif-failed">❌ Belum diisi</span>';
        } elseif ($data['status_verifikasi'] === 'sudah') {
            $status = '<span class="verif-success">✅ Terverifikasi</span>';
        } else {
            $status = '<span class="verif-pending">⏳ Menunggu Verifikasi</span>';
        }
    } else {
        $status = $data ? '<span class="verif-success">✅ Selesai</span>' : '<span class="verif-failed">❌ Belum diisi</span>';
    }

    return "<li>{$nomor}️⃣ <a href='{$link}' class='step-link'>{$nama}</a>: {$status}</li>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Murid - Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .step-link {
            text-decoration: none;
            font-weight: bold;
            color: #004c8c;
        }
        .step-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h2>👋 Halo, <?= htmlspecialchars($akun['nama_lengkap']) ?></h2>
    <p>Selamat datang di sistem pendaftaran SMK Lugina. Di bawah ini adalah status langkah-langkah pendaftaran kamu:</p>

    <?php if ($data_seleksi && $data_seleksi['status_kelulusan'] === 'lulus'): ?>
        <div class="alert-box verif-success" style="margin-bottom: 20px;">
            🎉 <strong>Selamat!</strong> Kamu dinyatakan <strong>LULUS</strong> seleksi penerimaan murid baru SMK Lugina!
        </div>
    <?php endif; ?>

    <div class="dashboard-box">
        <h3>📌 Progress Pendaftaran</h3>
        <ul>
            <li>1️⃣ Pendaftaran Akun: <span class="verif-success">✅ Selesai</span></li>
            <li>2️⃣ <a href="#" class="step-link">Verifikasi Akun</a>: <span class="<?= $status_class ?>"><?= $status_text ?></span></li>
            <?= langkah('3', 'Biodata', $data_biodata, 'biodata.php') ?>
            <?= langkah('4', 'Data Sekolah', $data_sekolah, 'sekolah.php') ?>
            <?= langkah('5', 'Data Orang Tua', $data_ortu, 'orangtua.php') ?>
            <?= langkah('6', 'Pilih Jurusan', $data_jurusan, 'jurusan.php') ?>
            <?= langkah('7', 'Upload Berkas', $data_berkas, 'berkas.php') ?>
            <?= langkah('8', 'Hasil Seleksi', $data_seleksi, 'tes.php') ?>
            <?= langkah('9', 'Administrasi Pembayaran', $data_bayar, 'pembayaran.php', 'verif') ?>
        </ul>
    </div>

    <?php
    $step_link = '';
    $step_text = '';

    if (!$data_biodata) {
        $step_link = 'biodata.php';
        $step_text = 'Isi Biodata';
    } elseif (!$data_sekolah) {
        $step_link = 'sekolah.php';
        $step_text = 'Isi Data Sekolah';
    } elseif (!$data_ortu) {
        $step_link = 'orangtua.php';
        $step_text = 'Isi Data Orang Tua';
    } elseif (!$data_jurusan) {
        $step_link = 'jurusan.php';
        $step_text = 'Pilih Jurusan';
    } elseif (!$data_berkas) {
        $step_link = 'berkas.php';
        $step_text = 'Upload Berkas';
    } elseif (!$data_seleksi) {
        $step_link = 'seleksi.php';
        $step_text = 'Lihat Hasil Seleksi';
    } elseif (!$data_bayar) {
        $step_link = 'pembayaran.php';
        $step_text = 'Administrasi Pembayaran';
    }
    ?>

    <?php if ($step_link): ?>
        <div class="form-group" style="text-align:center; margin-top: 30px;">
            <a href="<?= $step_link ?>" class="btn">➡️ Lanjutkan Pendaftaran: <?= $step_text ?></a>
        </div>
    <?php else: ?>
        <div class="alert-box" style="margin-top: 30px;">
            ✅ Semua langkah pendaftaran telah selesai. Terima kasih!
        </div>
    <?php endif; ?>

    <div class="dashboard-box">
        <h3>🧾 Data Akun</h3>
        <p><strong>Username:</strong> <?= htmlspecialchars($akun['username']) ?></p>
        <p><strong>No HP:</strong> <?= htmlspecialchars($akun['no_hp']) ?></p>
        <p><strong>Status Verifikasi:</strong> <span class="<?= $status_class ?>"><?= $status_text ?></span></p>
        <p><strong>Tanggal Daftar:</strong> <?= htmlspecialchars($akun['tanggal_daftar']) ?></p>
    </div>

    <?php if ($akun['status_verifikasi'] !== 'sudah') : ?>
        <div class="verif-warning">
            ⚠️ Akun kamu <strong>belum terverifikasi</strong>. Silakan tunggu proses verifikasi oleh panitia.
        </div>
    <?php endif; ?>

    <div class="logout-wrap">
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</div>
</body>
</html>
