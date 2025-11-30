<?php
include "koneksi.php";

$jumlah = $_POST['jumlah'];
$tanggal = $_POST['tanggal'];
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

// Pastikan nama tabel benar yaitu 'incomes'
$simpan = mysqli_query($koneksi, "INSERT INTO incomes (jumlah, tanggal, kategori, keterangan) VALUES ('$jumlah', '$tanggal', '$kategori', '$keterangan')") or die(mysqli_error($koneksi));

if ($simpan) {
    echo "<script>alert('Data Berhasil Disimpan'); window.location.href = 'pemasukanlogin.php';</script>";
}
?>


