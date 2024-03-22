<!-- koneksi.php -->
<?php
$host = "localhost"; // Ganti dengan host MySQL Anda
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$database = "gallery"; // Ganti dengan nama database Anda

$koneksi = mysqli_connect($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}
?>

