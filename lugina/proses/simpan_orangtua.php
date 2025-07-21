<?php
include '../config/koneksi.php';

$akun_id = $_POST['akun_id'];
$nama_ayah = ucwords(trim($_POST['nama_ayah']));
$nik_ayah = preg_replace('/\D/', '', $_POST['nik_ayah']); // Hanya angka
$pekerjaan_ayah = ucwords(trim($_POST['pekerjaan_ayah']));
$penghasilan_ayah = $_POST['penghasilan_ayah'];

$nama_ibu = ucwords(trim($_POST['nama_ibu']));
$nik_ibu = preg_replace('/\D/', '', $_POST['nik_ibu']); // Hanya angka
$pekerjaan_ibu = ucwords(trim($_POST['pekerjaan_ibu']));
$penghasilan_ibu = $_POST['penghasilan_ibu'];

$no_hp_ortu = preg_replace('/\D/', '', $_POST['no_hp_ortu']); // hanya angka

// Cek apakah data sudah ada
$cek = mysqli_query($conn, "SELECT * FROM data_orangtua WHERE akun_id='$akun_id'");

if (mysqli_num_rows($cek) > 0) {
    // Update
    $query = "UPDATE data_orangtua SET 
        nama_ayah='$nama_ayah',
        nik_ayah='$nik_ayah',
        pekerjaan_ayah='$pekerjaan_ayah',
        penghasilan_ayah='$penghasilan_ayah',
        nama_ibu='$nama_ibu',
        nik_ibu='$nik_ibu',
        pekerjaan_ibu='$pekerjaan_ibu',
        penghasilan_ibu='$penghasilan_ibu',
        no_hp_ortu='$no_hp_ortu'
        WHERE akun_id='$akun_id'";
} else {
    // Insert
    $query = "INSERT INTO data_orangtua (
        akun_id, nama_ayah, nik_ayah, pekerjaan_ayah, penghasilan_ayah,
        nama_ibu, nik_ibu, pekerjaan_ibu, penghasilan_ibu, no_hp_ortu
    ) VALUES (
        '$akun_id', '$nama_ayah', '$nik_ayah', '$pekerjaan_ayah', '$penghasilan_ayah',
        '$nama_ibu', '$nik_ibu', '$pekerjaan_ibu', '$penghasilan_ibu', '$no_hp_ortu'
    )";
}

mysqli_query($conn, $query);

// Redirect ke step selanjutnya
header("Location: ../murid/jurusan.php");
exit;
