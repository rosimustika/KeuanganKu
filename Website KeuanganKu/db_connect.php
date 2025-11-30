<?php
// Detail koneksi ke database
$host = "localhost";
$user = "root"; // Default username XAMPP
$password = ""; // Default password XAMPP
$dbname = "db_signup"; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>