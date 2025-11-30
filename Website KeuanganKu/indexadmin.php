<?php
include "koneksi.php";
include "koneksipengeluaran.php";
include "koneksiberanda.php";

session_start();
// Memastikan bahwa hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Jika bukan admin, redirect ke halaman login
    exit();
}


// Hitung saldo langsung dengan dua query
$query = mysqli_query($koneksi, "
    SELECT (IFNULL(SUM(jumlah), 0) - (SELECT IFNULL(SUM(jumlah), 0) FROM outcomes)) AS saldo FROM incomes") or die(mysqli_error($koneksi));

// Ambil hasil saldo
$data = mysqli_fetch_assoc($query);
$saldo = $data['saldo'];

// Format saldo ke dalam format rupiah
$saldo_rupiah = number_format($saldo, 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website KeuanganKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="indexlogin.css">
    <link rel="stylesheet" href="navbar.css">
    <script src="index.js"></script>
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
                <li><a href="indexadmin.php">Dashboard</a></li>
                <li><a href="inputartikel.php">Input Artikel</a></li>
                <li><a href="profileadmin.php"><img src="pp.admin.png" alt="Foto Profil"></a></li>
            </ul>
        </nav>
    </div>

<!-- Dashboard -->
    <div class="dashboard-utama"></div>
        <div class="jurnal-keuangan">
            <p>Jurnal Keuangan Admin</p>
        </div>
        <div class="bulan">
            <p>2024</p>
        </div>

        <div class="box-kecil total-tabungan">
            <div class="lingkaran-kecil"></div>
            <p>Total Tabungan</p>
            <h2>0</h2>
        </div>
        <div class="box-kecil target-tabungan">
            <div class="lingkaran-kecil"></div>
            <p>Target Tabungan</p>
            <h2>50.000.000</h2>
        </div>
        
        <table class="fixed-header">
            <thead>
                <tr>
                <th>No</th>
                <th>Tipe</th>
                <th>Aktivitas</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <tr>
                    <td>1</td>
                    <td class="text-success"></td>
                    <td></td>
                    <td class="text-success"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
</body>
</html>