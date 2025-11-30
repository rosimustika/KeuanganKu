<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'portal_berita';

// Buat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data artikel dari tabel 'berita'
$sql_berita = "SELECT * FROM berita WHERE terbitkan = 'yes' ORDER BY tanggal DESC";
$result_berita = $conn->query($sql_berita);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Tips</title>
    <link rel="stylesheet" href="artikeladmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <!-- Navigasi -->
    <div class="fnavigasi">
        <nav class="isinavigasi">
            <div class="logokeuanganku">
                <div class="fname">Keuangan</div>
                <div class="lname">Ku</div>
            </div>
            <ul class="itemnavigasi">
            <li><a href="indexlogin.php">Dashboard</a></li>
                <li><a href="pemasukanlogin.php">Pemasukan</a></li>
                <li><a href="pengeluaranlogin.php">Pengeluaran</a></li>
                <li><a href="artikel.php">Artikel</a></li>
                <li><a href="profile.php"><img src="girl.profile.circle.png" alt="Foto Profil"></a></li>
            </ul>
        </nav>
    </div>

    <!-- Artikel -->
    <h1>What's New</h1>
    <div class="container">
        <?php if ($result_berita->num_rows > 0): ?>
            <?php while ($row = $result_berita->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?= $row['gambar']; ?>" alt="<?= $row['judul']; ?>" class="image">
                    <h3><?= $row['judul']; ?></h3>
                    <p><?= substr($row['isi'], 0, 100); ?>...</p>
                    <a href="detailberita.php?id=<?= $row['id']; ?>">Baca Selengkapnya</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada artikel yang tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
