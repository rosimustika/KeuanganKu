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

// Ambil ID dari parameter URL (jika ada)
$id = isset($_GET['id']) ? $_GET['id'] : null;
$berita = null;

if ($id) {
    // Query untuk mendapatkan data berita berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM berita WHERE id = ? AND terbitkan = 'yes'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $berita = $result->fetch_assoc();
    $stmt->close();
}

// Ambil data artikel untuk daftar berita
$sql_berita = "SELECT * FROM berita WHERE terbitkan = 'yes' ORDER BY tanggal DESC";
$result_berita = $conn->query($sql_berita);

// Ambil kategori dari tabel 'kategori'
$sql_kategori = "SELECT * FROM kategori";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $berita ? htmlspecialchars($berita['judul']) : 'Artikel'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="artikeladmin.css">
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

    <div class="container my-5">
        <?php if ($berita): ?>
            <!-- Detail Berita -->
            <h1 class="mb-3" style="text-align:justify;"><?= htmlspecialchars($berita['judul']); ?></h1>
            <p class="text-muted"><?= date('d F Y', strtotime($berita['tanggal'])); ?></p>
            <img src="<?= htmlspecialchars($berita['gambar']); ?>" class="img-fluid mb-4 d-flex mx-auto" alt="<?= htmlspecialchars($berita['judul']); ?>">
            <p style="text-align:justify;"><?= nl2br(htmlspecialchars($berita['isi'])); ?></p>
            <a href="artikel.php" class="btn btn-secondary mt-4">Kembali ke Artikel</a>
        <?php else: ?>
            <!-- Daftar Artikel -->
            <h1>What's New</h1>
            <div class="row">
                <?php if ($result_berita->num_rows > 0): ?>
                    <?php while ($row = $result_berita->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>
                                    <p class="card-text"><?= substr(htmlspecialchars($row['isi_berita']), 0, 100); ?>...</p>
                                    <a href="?id=<?= $row['id']; ?>" class="btn btn-primary">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Tidak ada artikel yang tersedia.</p>
                <?php endif; ?>
            </div>

            <!-- Kategori -->
            <div class="Kategori">
                <h2>Kategori</h2>
                <div class="button-grid">
                    <?php if ($result_kategori->num_rows > 0): ?>
                        <?php while ($row = $result_kategori->fetch_assoc()): ?>
                            <button onclick="location.href='kategori.php?id=<?= $row['ID']; ?>'">
                                <?= htmlspecialchars($row['kategori']); ?>
                            </button>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Tidak ada kategori yang tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
