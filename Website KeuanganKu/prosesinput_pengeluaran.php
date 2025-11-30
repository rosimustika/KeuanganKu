<?php
include "koneksipengeluaran.php";

$jumlah = $_POST['jumlah'];
$tanggal = $_POST['tanggal'];
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

// Pastikan nama tabel benar yaitu 'outcomes'
$simpan = mysqli_query($koneksipengeluaran, "INSERT INTO outcomes (jumlah, tanggal, kategori, keterangan) VALUES ('$jumlah', '$tanggal', '$kategori', '$keterangan')") or die(mysqli_error($koneksipengeluaran));

if ($simpan) {
    echo "<script>alert('Data Berhasil Disimpan'); window.location.href = 'pengeluaranlogin.php';</script>";
}
?>

