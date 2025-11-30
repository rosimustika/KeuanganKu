<?php
include "koneksipengeluaran.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="pengeluaran.css">
    <link rel="stylesheet" href="navbar.css">
    <script src="pemasukan.js"></script>
</head>
<body>
<div class="header">
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
</div>

<div class="wrapper">
    <div class="pemasukanbox">
        <h2 class="fw-bold text-muted">Pengeluaran</h2>
        <form action="prosesinput_pengeluaran.php" method="POST">
            <label for="pengeluaran">Jumlah</label><br>
            <input class="text-muted" type="number" id="nominal" name="jumlah" placeholder="Masukkan Nominal"><br>
            
            <label for="tanggal">Tanggal</label><br>
            <input type="date" id="tanggal" name="tanggal"><br>
            
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <option value="Makan">Makan</option>
                <option value="Pajak">Pajak</option>
                <option value="Rokok">Rokok</option>
                <option value="Rokok">Belanja</option>
                <option value="Rokok">Self Reward</option>
                <option value="Rokok">Traktir Teman</option>
                <option value="Rokok">Bayar Kos</option>
                <option value="Lainnya">Lainnya</option>
            </select><br>
            
            <label for="keterangan">Keterangan</label><br>
            <input type="text" id="keterangan" name="keterangan"><br>
            
            <input type="submit" id="submit-button" value="Submit">
        </form>
    </div>


<table class="fixed-header">
    <thead>
        <tr>
            <th>No</th>
            <th>Tipe</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody class="table-body">
    <?php
    $no = 1;

    // Query untuk mengambil data pengeluaran saja dan menyortir berdasarkan tanggal terbaru
    $query = "
        SELECT 'Pengeluaran' AS jenis, kategori, jumlah, tanggal 
        FROM outcomes
        ORDER BY tanggal DESC
    ";

    // Eksekusi query
    $lihat = mysqli_query($koneksipengeluaran, $query) or die(mysqli_error($koneksipengeluaran));

    // Loop untuk menampilkan hasil query
    while ($data = mysqli_fetch_array($lihat)) {
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td class="text-danger">
                <?= htmlspecialchars($data['jenis']); ?>
            </td>
            <td><?= htmlspecialchars($data['kategori']); ?></td>
            <td style="color:red;">
                <?= "Rp" . number_format($data['jumlah'], 0, ',', '.'); ?>
            </td>
            <td><?= date("j F Y", strtotime($data['tanggal'])); ?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
</div>
</body>
</html>