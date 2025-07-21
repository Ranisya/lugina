<?php
session_start();
include __DIR__ . '/../koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$query = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data && $password === $data['password']) {
    $_SESSION['admin_id'] = $data['id'];
    $_SESSION['admin_nama'] = $data['nama_lengkap'];
    header("Location: dashboard.php");
    exit;
} else {
    // JANGAN langsung redirect. Tampilkan pesan dulu supaya tahu kenapa gagal.
    echo "<p style='color:red;'>Login gagal. Username atau password salah.</p>";
    echo "<a href='login.php'>🔁 Coba Lagi</a>";
    session_destroy(); // Tambahan biar session bersih
    exit;
}
?>
