<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM akun_daftar WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);
$status = $data['status_verifikasi'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Akun</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="../assets/img/lugina.jpg" class="login-logo">
            <h2>Verifikasi Akun</h2>

            <?php if ($status === 'sudah'): ?>
                <p>✅ Akun Anda telah berhasil diverifikasi.</p>
                <a href="login.php" class="btn-login">🔐 Masuk ke Akun</a>
            <?php else: ?>
                <p>⏳ Akun Anda sedang menunggu verifikasi dari panitia.</p>
                <p>Silakan tunggu beberapa saat. Anda akan diberi akses setelah diverifikasi.</p>
                <a href="login.php" class="btn">🔄 Coba Login Ulang</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
