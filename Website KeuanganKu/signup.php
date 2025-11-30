<?php
// Masukkan koneksi database
include 'db_connect.php';

// Inisialisasi variabel untuk pesan sukses atau error
$success_message = "";
$error_message = "";

// Tangani data yang dikirim dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $nomer = htmlspecialchars($_POST['nomer']);
    $password = $_POST['password'];
    $passwordlagi = $_POST['passwordlagi'];

    // Validasi password
    if ($password !== $passwordlagi) {
        $error_message = "Password tidak cocok.";
    } else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data ke tabel users
        $sql = "INSERT INTO users (nama, email, nomer, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $nomer, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil!";
            // Redirect ke halaman dashboard (indexlogin.php) setelah registrasi berhasil
            header("Location: indexlogin.php");
            exit(); // Menghentikan eksekusi script setelah redirect
        } else {
            $error_message = "Terjadi kesalahan: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="signup.css">
</head>

<body>

    <div class="wrapper">
        <form method="POST">
            <h1>Sign Up</h1>

            <!-- Tampilkan pesan sukses atau error -->
            <?php if (!empty($success_message)): ?>
                <div style="color: green; margin-bottom: 10px;">
                    <?= $success_message ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div style="color: red; margin-bottom: 10px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="nama" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Masukkan Email" required>
            </div>

            <div class="input-box">
                <input type="text" name="nomer" placeholder="Masukkan Nomer Handphone" required>
            </div>

            <!-- Password input yang selalu terlihat -->
            <div class="input-box">
                <input type="text" name="password" placeholder="Masukkan Password" required> <!-- Ganti type="password" menjadi type="text" -->
            </div>

            <div class="input-box">
                <input type="text" name="passwordlagi" placeholder="Konfirmasi Password" required> <!-- Ganti type="password" menjadi type="text" -->
            </div>

            <button type="submit" class="btn">Sign Up</button>

            <div class="SignUp-link">
                <p>Sudah punya akun? <a href="index.php">Login disini</a></p>
            </div>
        </form>
    </div>

</body>

</html>