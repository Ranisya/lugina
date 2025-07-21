<?php
include '../config/koneksi.php';

$id = $_GET['id'] ?? '';

if ($id) {
    $query = "UPDATE akun_daftar SET status_verifikasi = 'sudah' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: pendaftar.php");
exit;
