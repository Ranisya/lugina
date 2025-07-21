<?php
if (isset($_GET['error'])) {
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="../assets/img/lugina.jpg" alt="Logo Lugina" class="login-logo">
            
            <h2>🔐 Login Admin Panitia</h2>
            <p class="tagline">Silakan login untuk mengelola data pendaftaran murid baru.</p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert">Username atau password salah.</div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST" class="form-login">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Kata Sandi" required>
                <button type="submit" class="btn-login">✅ Login Admin</button>
            </form>

            <div class="login-links">
                <p><a href="../murid/login.php">🔙 Kembali ke Login Murid</a></p>
            </div>
        </div>
    </div>
</body>
</html>
