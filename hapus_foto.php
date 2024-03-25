<?php
session_start();
require_once("koneksi.php");

if (empty($_SESSION['UserID'])) {
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('login.php');</script>";
    exit();
}

if (isset($_GET['photoID'])) {
    $photoID = $_GET['photoID'];
    
    // Hapus semua entri terkait dari tabel likefoto
    $query_delete_likes = "DELETE FROM likefoto WHERE FotoID = $photoID";
    if (mysqli_query($koneksi, $query_delete_likes)) {
        // Jika entri terkait berhasil dihapus, lanjutkan dengan menghapus foto dari tabel foto
        $query_delete_photo = "DELETE FROM foto WHERE FotoID = $photoID";
        if (mysqli_query($koneksi, $query_delete_photo)) {
            echo "<script>alert('Foto berhasil dihapus.'); window.location.assign('user.php');</script>";
            exit();
        } else {
            echo "<script>alert('Gagal menghapus foto. Silakan coba lagi.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menghapus foto. Silakan coba lagi.');</script>";
    }
} else {
    echo "<script>alert('ID foto tidak valid.'); window.location.assign('user.php');</script>";
}
?>
