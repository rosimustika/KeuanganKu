<?php
include "koneksi.php";
include "koneksipengeluaran.php";
include "koneksiberanda.php";

session_start();
// Memastikan bahwa hanya user yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'user') {
    header("Location: index.php"); // Jika bukan user, redirect ke halaman login
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
                <li><a href="indexlogin.php">Dashboard</a></li>
                <li><a href="pemasukanlogin.php">Pemasukan</a></li>
                <li><a href="pengeluaranlogin.php">Pengeluaran</a></li>
                <li><a href="artikel.php">Artikel</a></li>
                <li><a href="profile.php"><img src="girl.profile.circle.png" alt="Foto Profil"></a></li>
            </ul>
        </nav>
    </div>

<!-- Dashboard -->
    <div class="dashboard-utama"></div>
        <div class="jurnal-keuangan">
            <p>Jurnal Keuangan</p>
        </div>
        <div class="bulan">
            <p>2024</p>
        </div>

        <div class="box-kecil total-tabungan">
            <div class="lingkaran-kecil"></div>
            <p>Total Tabungan</p>
            <h2><?= $saldo_rupiah; ?></h2>
        </div>
        <div class="box-kecil target-tabungan">
            <div class="lingkaran-kecil"></div>
            <p>Target Tabungan</p>
            <h2>50.000.000</h2>
        </div>
        <div class="box-besar box-pemasukan">
            <div class="tiga-lingkaran-pertama">
                <span class="persen-gaji-lingkaran">65%</span>
            </div>
                <span class="teks-gaji-lingkaran">Gaji</span>

            <div class="tiga-lingkaran-kedua">
                <span class="persen-investasi-lingkaran">30%</span>
            </div>
                <span class="teks-investasi-lingkaran">Investasi</span>

            <div class="tiga-lingkaran-ketiga">
                <span class="persen-hadiah-lingkaran">5%</span>
            </div>
                <span class="teks-hadiah-lingkaran">Hadiah</span>
            <div class="judul-pemasukan">
                <p>Pemasukan</p>
            </div>
        </div>
        
        <div class="box-besar box-pengeluaran">
            <div class="tiga-lingkaran-pertama-kedua">
                <span class="persen-makan-lingkaran">50%</span>
            </div>
                <span class="teks-makan-lingkaran">Makan</span>

            <div class="tiga-lingkaran-kedua-kedua">
                <span class="persen-pajak-lingkaran">15%</span>
            </div>
                <span class="teks-pajak-lingkaran">Pajak</span>

            <div class="tiga-lingkaran-ketiga-ketiga">
                <span class="persen-rokok-lingkaran">35%</span>
            </div>
                <span class="teks-rokok-lingkaran">Rokok</span>
            <div class="judul-pengeluaran">
                <p>Pengeluaran</p>
            </div>
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
            <?php
            $no = 1;

            // Query untuk menggabungkan pemasukan dan pengeluaran
            $query = "
                SELECT 'Pemasukan' AS jenis, kategori, jumlah, tanggal 
                FROM incomes
                UNION ALL
                SELECT 'Pengeluaran' AS jenis, kategori, jumlah, tanggal 
                FROM outcomes
                ORDER BY tanggal DESC
            ";

            // Eksekusi query
            $lihat = mysqli_query($koneksiberanda, $query) or die(mysqli_error($koneksiberanda));

            // Tampilkan hasil
            while ($data = mysqli_fetch_array($lihat)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="<?= $data['jenis'] === 'Pemasukan' ? 'text-success' : 'text-danger'; ?>">
                        <?= htmlspecialchars($data['jenis']); ?>
                    </td>
                    <td><?= htmlspecialchars($data['kategori']); ?></td>
                    <td style="color:<?= $data['jenis'] === 'Pemasukan' ? 'green' : 'red'; ?>">
                        <?= "Rp" . number_format($data['jumlah'], 0, ',', '.'); ?>
                    </td>
                    <td><?= date("j F Y", strtotime($data['tanggal'])); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
</body>
</html>