<?php
include '../config/koneksi.php';

$akun_id = $_POST['akun_id'];
$dir = "../uploads/";

// Fungsi upload tanpa filter
function uploadFile($field_name, $target_dir) {
    if ($_FILES[$field_name]['error'] !== 0) {
        echo "<script>alert('Upload gagal untuk $field_name. Error code: " . $_FILES[$field_name]['error'] . "');history.back();</script>";
        exit;
    }

    $filename = basename($_FILES[$field_name]['name']);
    $target_file = $target_dir . time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $filename);

    if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $target_file)) {
        return $target_file;
    } else {
        echo "<script>alert('Gagal memindahkan file $field_name.');history.back();</script>";
        exit;
    }
}

// Upload semua berkas
$pas_foto = uploadFile('pas_foto', $dir);
$ijazah = uploadFile('ijazah', $dir);
$kk = uploadFile('kartu_keluarga', $dir);

// Cek jika salah satu gagal upload
if (!$pas_foto || !$ijazah || !$kk) {
    echo "<script>alert('Gagal upload berkas. Silakan coba lagi.');history.back();</script>";
    exit;
}

// Cek apakah data sudah ada
$cek = mysqli_query($conn, "SELECT * FROM berkas_pendaftaran WHERE akun_id='$akun_id'");
if (mysqli_num_rows($cek) > 0) {
    // Update
    mysqli_query($conn, "UPDATE berkas_pendaftaran SET 
        pas_foto='$pas_foto', 
        ijazah='$ijazah', 
        kartu_keluarga='$kk', 
        status_upload='lengkap' 
        WHERE akun_id='$akun_id'");
} else {
    // Insert
    mysqli_query($conn, "INSERT INTO berkas_pendaftaran 
        (akun_id, pas_foto, ijazah, kartu_keluarga, status_upload) VALUES 
        ('$akun_id', '$pas_foto', '$ijazah', '$kk', 'lengkap')");
}

header("Location: ../murid/tes.php");
exit;
