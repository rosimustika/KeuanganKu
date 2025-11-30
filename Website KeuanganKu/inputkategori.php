<?php
// Konfigurasi koneksi database
$servername = "localhost"; // Nama server
$username = "root";        // Username database (default XAMPP)
$password = "";            // Password database (kosong untuk default XAMPP)
$dbname = "portal_berita"; // Nama database Anda

// Membuat koneksi ke database
$connect = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($connect->connect_error) {
    die("Koneksi gagal: " . $connect->connect_error);
}

$kategori = "";
$alias = "";
$tampilkan = "";
$ID = "";

// Jika tombol submit ditekan
if (isset($_POST['tambahkategori'])) {
    $kategori = $_POST['kategori'];
    $alias = $_POST['alias'];
    $tampilkan = $_POST['tampilkan'];

    // Query untuk menambahkan data ke tabel
    $sql = "INSERT INTO kategori (kategori, alias, tampilkan) VALUES ('$kategori', '$alias', '$tampilkan')";

    // Eksekusi query dan periksa hasilnya
    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('Kategori berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Error: " . $connect->error . "');</script>";
    }
}

// Jika tombol edit kategori ditekan
if (isset($_POST['editkategori'])) {
    $kategori = $_POST['kategori'];
    $alias = $_POST['alias'];
    $tampilkan = $_POST['tampilkan'];
    $ID = $_POST['ID'];

    // Query untuk mengedit data di tabel
    $sql = "UPDATE kategori SET kategori='$kategori', alias='$alias', tampilkan='$tampilkan' WHERE ID='$ID'";

    // Eksekusi query dan periksa hasilnya
    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('Kategori berhasil diupdate!');</script>";
    } else {
        echo "<script>alert('Error: " . $connect->error . "');</script>";
    }
}

// Jika mode edit diaktifkan
if (isset($_GET['act']) && $_GET['act'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $connect->query("SELECT * FROM kategori WHERE ID = '$id'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kategori = $row['kategori'];
        $alias = $row['alias'];
        $tampilkan = $row['tampilkan'];
        $ID = $row['ID'];
    }
}

// Jika tombol hapus kategori ditekan
if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
    $id = (int)$_GET['id'];

    // Query untuk menghapus data di tabel
    $sql = "DELETE FROM kategori WHERE ID='$id'";

    // Eksekusi query dan periksa hasilnya
    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('Kategori berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Error: " . $connect->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Administrator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="input.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <div class="fnavigasi">
        <nav class="isinavigasi">
            <div class="logokeuanganku">
                <div class="fname">Keuangan</div>
                <div class="lname">Ku</div>
            </div>
            <ul class="itemnavigasi">
                <li><a href="indexadmin.php">Dashboard</a></li>
                <li><a href="inputartikel.php">Input Artikel</a></li>
                <li><a href="inputkategori.php">Input Kategori</a></li>
                <li><a href="profileadmin.php"><img src="pp.admin.png" alt="Foto Profil"></a></li>
            </ul>
        </nav>
    </div>
        <main>
            <section class="form-section">
                <h2><?= $ID ? "EDIT KATEGORI" : "TAMBAH KATEGORI" ?></h2>
                <form action="" method="POST">
                    <input type="hidden" name="ID" value="<?= $ID; ?>">

                    <label for="kategori">Nama Kategori:</label>
                    <input type="text" id="kategori" name="kategori" placeholder="Masukkan nama kategori" value="<?= $kategori; ?>" required>

                    <label for="alias">Alias:</label>
                    <input type="text" id="alias" name="alias" placeholder="Masukkan alias" value="<?= $alias; ?>" required>

                    <label for="tampilkan">Tampilkan:</label>
                    <select id="tampilkan" name="tampilkan">
                        <option value="no" <?= $tampilkan == 'no' ? 'selected' : ''; ?>>No</option>
                        <option value="yes" <?= $tampilkan == 'yes' ? 'selected' : ''; ?>>Yes</option>
                    </select>

                    <button type="submit" name="<?= $ID ? 'editkategori' : 'tambahkategori'; ?>" class="btn btn-primary mt-3">
                        <?= $ID ? 'Update' : 'Tambah'; ?>
                    </button>
                </form>
            </section>
            <section class="list-section mt-5">
                <h2>LIST KATEGORI</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Alias</th>
                            <th>Tampilkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Tampilkan data dari database
                        $result = $connect->query("SELECT * FROM kategori");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . $row['ID'] . "</td>
                                    <td>" . $row['kategori'] . "</td>
                                    <td>" . $row['alias'] . "</td>
                                    <td>" . $row['tampilkan'] . "</td>
                                    <td>
                                        <a href='?act=edit&id=" . $row['ID'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='?act=hapus&id=" . $row['ID'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Belum ada data.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
</body>
</html>
