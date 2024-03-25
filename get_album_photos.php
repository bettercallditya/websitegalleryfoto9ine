<?php
// Pastikan albumID telah disediakan
if (!isset($_GET['albumID'])) {
    echo "Album ID not provided";
    exit();
}

$albumID = $_GET['albumID'];

// Lakukan koneksi ke database atau termasuk file koneksi.php jika diperlukan
require_once("koneksi.php");

// Query untuk mengambil foto-foto yang terkait dengan album tertentu
$query = "SELECT * FROM foto WHERE AlbumID = $albumID";
$result = mysqli_query($koneksi, $query);

// Periksa apakah ada foto yang terkait dengan album tersebut
if (mysqli_num_rows($result) > 0) {
    // Tampilkan foto-foto dalam format yang sesuai dengan kebutuhan Anda
    while ($row = mysqli_fetch_assoc($result)) {
        // Misalnya, tampilkan gambar dengan judul foto sebagai tooltip
        echo "<img src='uploads/{$row['LokasiFile']}' alt='{$row['JudulFoto']}' title='{$row['JudulFoto']}'>";
    }
} else {
    echo "Tidak ada foto dalam album ini";
}
?>
