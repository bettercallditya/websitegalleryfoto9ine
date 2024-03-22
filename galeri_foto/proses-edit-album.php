<?php
session_start();
require_once("koneksi.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari form
    $AlbumID = $_POST['AlbumID'];
    $NamaAlbum = $_POST['NamaAlbum'];
    $Deskripsi = $_POST['Deskripsi'];

    // Update data album di database
    $update_query = "UPDATE album SET NamaAlbum = '$NamaAlbum', Deskripsi = '$Deskripsi' WHERE AlbumID = $AlbumID";
    $update_result = mysqli_query($koneksi, $update_query);

    if($update_result) {
        echo "<script>alert('Album berhasil diupdate'); window.location.href='album.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal mengupdate album'); window.location.href='album.php';</script>";
        exit();
    }
} else {
    echo "Akses tidak sah";
}
?>
