<?php
session_start();
require_once("koneksi.php");

// Periksa apakah pengguna telah login
if (empty($_SESSION['UserID'])) {
    // Jika belum login, alihkan ke halaman login
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('login.php');</script>";
    exit();
}

// Pastikan AlbumID tersedia
if(isset($_GET['AlbumID'])) {
    $AlbumID = $_GET['AlbumID'];

    // Hapus terlebih dahulu semua data yang terkait dengan foto di tabel likefoto
    $delete_like_query = "DELETE FROM likefoto WHERE FotoID IN (SELECT FotoID FROM foto WHERE AlbumID = $AlbumID)";
    $delete_like_result = mysqli_query($koneksi, $delete_like_query);

    // Hapus terlebih dahulu semua komentar foto terkait yang merujuk ke foto dalam album
    $delete_komentar_query = "DELETE FROM komentarfoto WHERE FotoID IN (SELECT FotoID FROM foto WHERE AlbumID = $AlbumID)";
    $delete_komentar_result = mysqli_query($koneksi, $delete_komentar_query);

    // Hapus semua foto terkait album
    $delete_foto_query = "DELETE FROM foto WHERE AlbumID = $AlbumID";
    $delete_foto_result = mysqli_query($koneksi, $delete_foto_query);

    // Hapus album dari database
    $delete_album_query = "DELETE FROM album WHERE AlbumID = $AlbumID";
    $delete_album_result = mysqli_query($koneksi, $delete_album_query);

    if ($delete_foto_result && $delete_album_result && $delete_komentar_result && $delete_like_result) {
        // Redirect kembali ke halaman album.php setelah penghapusan berhasil
        echo "<script>alert('Album beserta foto, komentar, dan likes berhasil dihapus'); window.location.assign('album.php');</script>";
        exit();
    } else {
        // Jika gagal menghapus album, tampilkan pesan kesalahan
        echo "<script>alert('Gagal menghapus album beserta foto, komentar, dan likes');</script>";
    }
} else {
    echo "AlbumID tidak tersedia";
    exit();
}
?>
