<?php
session_start();
require_once("koneksi.php");

// Periksa apakah pengguna telah login
if (empty($_SESSION['UserID'])) {
    // Jika belum login, alihkan ke halaman login
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('login.php');</script>";
    exit();
}

// Mengambil data UserID dari sesi
$userID = $_SESSION['UserID'];

// Mengecek apakah data FotoID dan isi komentar telah disertakan dalam request
if(isset($_POST['photo_id']) && isset($_POST['comment_content'])) {
    $fotoID = $_POST['photo_id'];
    $isiKomentar = $_POST['comment_content'];

    // Memasukkan data komentar ke dalam tabel komentarfoto
    $sql = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) VALUES ('$fotoID', '$userID', '$isiKomentar', NOW())";
    
    if ($koneksi->query($sql) === TRUE) {
        // Redirect kembali ke halaman detail foto setelah komentar ditambahkan
        header("Location: detail-foto.php?photo_id=$fotoID");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} else {
    echo "FotoID atau isi komentar tidak ditemukan dalam request.";
}

$koneksi->close();
?>
