<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Murid - SPMB Lugina</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/step.css">
</head>
<script>
// Otomatis kapital huruf awal tiap kata
function capitalize(input) {
    input.value = input.value.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}
</script>

<body>
    <div class="login-container">
        <div class="login-box">
            <img src="../assets/img/lugina.jpg" alt="Logo Lugina" class="login-logo">
            <h2>📝 Daftar Akun Murid</h2>
            <p class="tagline">Silakan isi data berikut untuk membuat akun murid baru.</p>

            <form action="../proses/simpan_akun.php" method="POST" class="form-daftar">
                <div class="form-group">
                    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required oninput="capitalize(this)">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="text" name="no_hp" placeholder="Nomor HP Aktif" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    <input type="password" name="password" placeholder="Kata Sandi" required>
                </div>
                <div class="form-group">
                    <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Kata Sandi" required>
                </div>
                <button type="submit" class="btn-login">✅ Daftar Sekarang</button>
            </form>

            <div class="login-links">
                <a href="login.php">🔐 Sudah punya akun? Login di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
