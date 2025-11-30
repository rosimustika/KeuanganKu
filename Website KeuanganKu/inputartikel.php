<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal_berita";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = ""; // Variabel untuk pesan sukses atau error

// Proses penyimpanan data baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $judul = $conn->real_escape_string($_POST['title']);
    $isi = $conn->real_escape_string($_POST['content']);
    $teks = isset($_POST['tags']) ? $conn->real_escape_string($_POST['tags']) : null;
    $terbitkan = $conn->real_escape_string($_POST['publish']);
    $tanggal = date('Y-m-d');

    // Upload file gambar
    $gambar = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $gambarPath = $uploadDir . basename($_FILES['image']['name']);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $gambarPath)) {
            $gambar = $conn->real_escape_string($gambarPath);
        } else {
            $message = "Gagal mengunggah file gambar.";
        }
    }

    // Simpan data ke database
    $sql = "INSERT INTO berita (judul, isi, gambar, teks, terbitkan, tanggal) 
            VALUES ('$judul', '$isi', " . ($gambar ? "'$gambar'" : "NULL") . ", " . ($teks ? "'$teks'" : "NULL") . ", '$terbitkan', '$tanggal')";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Proses edit data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = (int)$_POST['id'];
    $judul = $conn->real_escape_string($_POST['title']);
    $isi = $conn->real_escape_string($_POST['content']);
    $teks = isset($_POST['tags']) ? $conn->real_escape_string($_POST['tags']) : null;
    $terbitkan = $conn->real_escape_string($_POST['publish']);

    // Update data ke database
    $sql = "UPDATE berita SET judul='$judul', isi='$isi', teks=" . ($teks ? "'$teks'" : "NULL") . ", terbitkan='$terbitkan' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil diperbarui.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Proses hapus data
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM berita WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Berita berhasil dihapus.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita - Admin</title>
    <link rel="stylesheet" href="input.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                <li><a href="profileadmin.php"><img src="pp.admin.png" alt="Foto Profil"></a></li>
            </ul>
        </nav>
    </div>

        <h1>Tambah/Edit Berita</h1>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>

        <form id="newsForm" action="inputartikel.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <input type="hidden" id="id" name="id">

            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Isi Berita:</label>
            <textarea id="content" name="content" rows="5" required></textarea>

            <label for="image">Gambar:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label for="tags">Teks:</label>
            <input type="text" id="tags" name="tags" placeholder="Masukkan tag">

            <label for="publish">Terbitkan:</label>
            <select id="publish" name="publish">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <button type="submit">Simpan</button>
        </form>

        <h2>List Berita</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="newsList">
            <?php
// Query untuk menampilkan data berita
$sql = "SELECT * FROM berita ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Iterasi setiap baris data dari hasil query
    while ($row = $result->fetch_assoc()) {
        // Escaping untuk data yang akan dimasukkan dalam atribut HTML
        $judul = htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8');
        $isi = htmlspecialchars($row['isi'], ENT_QUOTES, 'UTF-8');
        $teks = htmlspecialchars($row['teks'], ENT_QUOTES, 'UTF-8');
        $terbitkan = htmlspecialchars($row['terbitkan'], ENT_QUOTES, 'UTF-8');

        // Output data ke tabel
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$judul}</td>
            <td>{$row['tanggal']}</td>
            <td>
                <button class='edit-btn' onclick=\"editNews({$row['id']}, '{$judul}', '{$isi}', '{$teks}', '{$terbitkan}')\">Edit</button>
                <button class='delete-btn' onclick=\"if(confirm('Yakin ingin menghapus?')) { window.location.href = '?action=delete&id={$row['id']}'; }\">Hapus</button>
            </td>
        </tr>";
    }
} else {
    // Jika tidak ada data berita
    echo "<tr><td colspan='5'>Belum ada berita.</td></tr>";
}
?>

            </tbody>
        </table>

    <script>
        function editNews(id, title, content, tags, publish) {
            document.getElementById('id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('content').value = content;
            document.getElementById('tags').value = tags;
            document.getElementById('publish').value = publish;
            document.getElementById('newsForm').action = 'inputartikel.php';
            document.getElementById('newsForm').querySelector('[name="action"]').value = 'edit';
        }
    </script>
</body>
</html>
