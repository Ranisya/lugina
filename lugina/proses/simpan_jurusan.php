<?php
session_start();
include '../config/koneksi.php';

if (!isset($_POST['akun_id'])) {
    header("Location: ../murid/jurusan.php");
    exit;
}

$akun_id = $_POST['akun_id'];
$pilihan_1 = mysqli_real_escape_string($conn, $_POST['pilihan_1']);
$pilihan_2 = mysqli_real_escape_string($conn, $_POST['pilihan_2']);

// Cek apakah data sudah ada
$cek = mysqli_query($conn, "SELECT * FROM pilihan_jurusan WHERE akun_id='$akun_id'");

if (mysqli_num_rows($cek) > 0) {
    // Update jika sudah ada
    $query = "UPDATE pilihan_jurusan 
              SET pilihan_1='$pilihan_1', pilihan_2='$pilihan_2' 
              WHERE akun_id='$akun_id'";
} else {
    // Insert jika belum ada
    $query = "INSERT INTO pilihan_jurusan (akun_id, pilihan_1, pilihan_2) 
              VALUES ('$akun_id', '$pilihan_1', '$pilihan_2')";
}

if (mysqli_query($conn, $query)) {
    header("Location: ../murid/berkas.php");
    exit;
} else {
    echo "Gagal menyimpan data jurusan: " . mysqli_error($conn);
}
?>
