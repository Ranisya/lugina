<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $akun_id = intval($_POST['akun_id']);
    $nilai_tes = intval($_POST['nilai_tes']);

    if (!$akun_id) {
        die("ID murid tidak ditemukan.");
    }

    $status = ($nilai_tes >= 70) ? 'Lulus' : 'Tidak Lulus';

    // Cek apakah data sudah ada
    $cek = mysqli_query($conn, "SELECT id FROM hasil_seleksi WHERE akun_id = $akun_id");

    if (mysqli_num_rows($cek) > 0) {
        // Update
        $query = "UPDATE hasil_seleksi SET nilai_tes=$nilai_tes, status_kelulusan='$status' WHERE akun_id=$akun_id";
    } else {
        // Insert
        $query = "INSERT INTO hasil_seleksi (akun_id, nilai_tes, status_kelulusan) VALUES ($akun_id, $nilai_tes, '$status')";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: proses_seleksi.php?pesan=sukses");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    echo "Metode tidak valid.";
}
?>
