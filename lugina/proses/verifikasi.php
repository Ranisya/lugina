<?php
include '../config/koneksi.php';

$id = $_POST['id'];
$kode = $_POST['kode'];

$query = "SELECT * FROM akun_daftar WHERE id = '$id' AND kode_verifikasi = '$kode'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    mysqli_query($conn, "UPDATE akun_daftar SET status_verifikasi = 'sudah' WHERE id = '$id'");
    echo "<script>
        alert('Verifikasi berhasil! Silakan login.');
        window.location.href = '../murid/login.php';
    </script>";
} else {
    echo "<script>
        alert('Kode salah! Coba lagi.');
        window.history.back();
    </script>";
}
?>
