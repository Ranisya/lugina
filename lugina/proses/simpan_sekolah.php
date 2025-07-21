<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: ../murid/login.php");
    exit;
}

$id = $_SESSION['id'];

// Ambil data dari form
$asal_sekolah    = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
$alamat_sekolah  = mysqli_real_escape_string($conn, $_POST['alamat_sekolah']);
$tahun_lulus     = mysqli_real_escape_string($conn, $_POST['tahun_lulus']);

// Cek apakah data sudah ada
$cek = mysqli_query($conn, "SELECT * FROM data_sekolah WHERE akun_id='$id'");

if (mysqli_num_rows($cek) > 0) {
    // Update
    $query = "UPDATE data_sekolah SET 
                asal_sekolah = '$asal_sekolah',
                alamat_sekolah = '$alamat_sekolah',
                tahun_lulus = '$tahun_lulus'
              WHERE akun_id = '$id'";
} else {
    // Insert
    $query = "INSERT INTO data_sekolah (akun_id, asal_sekolah, alamat_sekolah, tahun_lulus) 
              VALUES ('$id', '$asal_sekolah', '$alamat_sekolah', '$tahun_lulus')";
}

if (mysqli_query($conn, $query)) {
    header("Location: ../murid/orangtua.php");
    exit;
} else {
    echo "Gagal menyimpan data sekolah: " . mysqli_error($conn);
}
?>
