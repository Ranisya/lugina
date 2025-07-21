<?php
include '../config/koneksi.php';

$akun_id = $_POST['akun_id'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$jumlah = $_POST['jumlah'];
$status_verifikasi = 'belum';

$upload_dir = '../uploads/';
$file_name = $_FILES['bukti_transfer']['name'];
$file_tmp = $_FILES['bukti_transfer']['tmp_name'];
$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$file_new_name = 'bukti_' . time() . '_' . rand(100, 999) . '.' . $file_ext;
$allowed = ['jpg', 'jpeg', 'png', 'pdf'];
$jumlah = preg_replace('/[^\d]/', '', $_POST['jumlah']); // Buang simbol Rp dan titik

if (in_array($file_ext, $allowed)) {
    if (move_uploaded_file($file_tmp, $upload_dir . $file_new_name)) {
        $cek = mysqli_query($conn, "SELECT * FROM pembayaran WHERE akun_id='$akun_id'");
        if (mysqli_num_rows($cek) > 0) {
            $query = "UPDATE pembayaran SET 
                        tanggal_bayar='$tanggal_bayar',
                        jumlah='$jumlah',
                        bukti_transfer='$file_new_name',
                        status_verifikasi='$status_verifikasi'
                      WHERE akun_id='$akun_id'";
        } else {
            $query = "INSERT INTO pembayaran 
                        (akun_id, tanggal_bayar, jumlah, bukti_transfer, status_verifikasi)
                      VALUES
                        ('$akun_id', '$tanggal_bayar', '$jumlah', '$file_new_name', '$status_verifikasi')";
        }

        mysqli_query($conn, $query);
        header("Location: ../murid/pembayaran.php");
        exit;
    } else {
        echo "❌ Gagal upload file.";
    }
} else {
    echo "❌ Format file tidak diperbolehkan.";
}
?>

