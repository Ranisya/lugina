<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $akun_id = $_GET['id'];
    $update = mysqli_query($conn, "UPDATE berkas_pendaftaran SET status_upload = 'sudah' WHERE akun_id = '$akun_id'");
}

header("Location: verifikasi_berkas.php");
exit;
