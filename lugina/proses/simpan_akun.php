<?php
include '../config/koneksi.php';

// Ambil data dari form
$nama = $_POST['nama_lengkap'];
$username = $_POST['username'];
$no_hp = $_POST['no_hp']; // Ganti dari whatsapp jadi no_hp
$password = $_POST['password'];
$konfirmasi = $_POST['konfirmasi_password'];

// Cek password dan konfirmasi sama
if ($password != $konfirmasi) {
    echo "Password dan konfirmasi tidak sama!";
    exit;
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah username sudah digunakan
$cek = mysqli_query($conn, "SELECT * FROM akun_daftar WHERE username='$username'");
if (mysqli_num_rows($cek) > 0) {
    echo "Username sudah digunakan. Silakan pilih yang lain.";
    exit;
}

// Generate kode verifikasi (acak 6 digit)
$kode = rand(100000, 999999);

// Simpan ke database
$sql = "INSERT INTO akun_daftar (nama_lengkap, username, no_hp, password, kode_verifikasi)
        VALUES ('$nama', '$username', '$no_hp', '$password_hash', '$kode')";

if (mysqli_query($conn, $sql)) {
    echo "Akun berhasil didaftarkan! Silakan login.";
    header("Refresh:2; url=../murid/login.php");
} else {
    echo "Gagal menyimpan akun: " . mysqli_error($conn);
}
?>
