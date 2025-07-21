<?php
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM akun_daftar WHERE username='$username'");
$data = mysqli_fetch_assoc($query);

if ($data && password_verify($password, $data['password'])) {
    if ($data['status_verifikasi'] == 'belum') {
        echo "<script>
            alert('Akun belum diverifikasi! Silakan cek kode terlebih dahulu.');
            window.location.href='../murid/verifikasi.php?id={$data['id']}';
        </script>";
        exit;
    }

    $_SESSION['id'] = $data['id'];
    $_SESSION['nama'] = $data['nama_lengkap'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = 'murid';

    header("Location: ../murid/dashboard.php");
} else {
    echo "<script>
        alert('Login gagal! Username atau password salah.');
        window.location.href='../murid/login.php';
    </script>";
}
?>
