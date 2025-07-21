<?php
include '../config/koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}

$akun_id       = $_POST['akun_id'];
$nik           = $_POST['nik'];
$nisn          = $_POST['nisn'];
$tempat_lahir  = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama         = $_POST['agama'];
$alamat        = $_POST['alamat'];
$no_hp         = $_POST['no_hp'];

$cek = mysqli_query($conn, "SELECT * FROM biodata_murid WHERE akun_id='$akun_id'");
if (mysqli_num_rows($cek) > 0) {
    // Update
    $query = "UPDATE biodata_murid SET 
        nik='$nik',
        nisn='$nisn',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir='$tanggal_lahir',
        jenis_kelamin='$jenis_kelamin',
        agama='$agama',
        alamat='$alamat',
        no_hp='$no_hp'
        WHERE akun_id='$akun_id'";
} else {
    // Insert
    $query = "INSERT INTO biodata_murid 
        (akun_id, nik, nisn, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, no_hp)
        VALUES 
        ('$akun_id', '$nik', '$nisn', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$agama', '$alamat', '$no_hp')";
}

mysqli_query($conn, $query);
header("Location: ../murid/sekolah.php");
exit;
