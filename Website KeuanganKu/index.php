<?php 
session_start();
include 'db_connect.php'; // Koneksi ke database

$error_message = ""; // Variabel untuk menyimpan pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']); // Input username atau email
    $password = $_POST['password']; // Input password

    // Query untuk mencari pengguna berdasarkan email atau nama
    $sql = "SELECT * FROM users WHERE email = ? OR nama = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika password benar, simpan data ke sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['role'] = $user['role'];  // Menyimpan role pengguna di sesi

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: indexadmin.php"); // Halaman khusus admin
            } else {
                header("Location: indexlogin.php"); // Halaman khusus user biasa
            }
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username atau Email tidak ditemukan!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Pastikan Bootstrap Icons diimpor -->
    <link rel="stylesheet" href="signup.css">
    <script>
        // Fungsi untuk menampilkan atau menyembunyikan password
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.innerHTML = '<i class="bi bi-eye"></i>';  // Ubah ikon menjadi mata terbuka
            } else {
                passwordInput.type = "password";
                toggleIcon.innerHTML = '<i class="bi bi-eye-slash"></i>';  // Ubah ikon menjadi mata tertutup
            }
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <form method="POST" action="index.php">
            <h1>Login</h1>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (!empty($error_message)): ?>
                <div style="color: red; margin-bottom: 10px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username atau Email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box" style="position: relative;">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
                <!-- Tombol untuk menampilkan atau menyembunyikan password -->
                <span id="toggle-icon" onclick="togglePassword()" style="cursor: pointer; position: absolute; right: 10px; top: 12px;">
                    <i class="bi bi-eye-slash"></i> <!-- Default icon adalah eye-slash -->
                </span>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox"> Ingat Saya</label>
                <a href="#">Lupa Password</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="SignUp-link">
                <p>Belum memiliki akun? <a href="signup.php">Daftar</a></p>
            </div>
        </form>
    </div>
</body>

</html>