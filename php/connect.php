<?php
// Konfigurasi koneksi
$host     = "localhost";
$username = "root";    
$password = "";
$database = "super_league";

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
