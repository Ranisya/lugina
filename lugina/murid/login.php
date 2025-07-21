<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Murid - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="../assets/img/lugina.jpg" alt="Logo Lugina" class="login-logo">
            
            <h2>🔐 Login Akun Murid</h2>
            <p class="tagline">Silakan login untuk melanjutkan proses pendaftaran.</p>

            <form action="../proses/login.php" method="POST" class="form-login">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Kata Sandi" required>
                <button type="submit" class="btn-login">✅ Login Sekarang</button>
            </form>

            <div class="login-links">
                <p>Belum punya akun? <a href="daftar.php">📝 Daftar di sini</a></p>
                <p><a href="../admin/login.php">Login Panitia/Admin</a></p>
            </div>
        </div>
    </div>
</body>
</html>
