<?php
// Memeriksa apakah foto_id disediakan melalui POST request
if(isset($_POST['foto_id'])) {
    // Memuat koneksi ke database
    require_once("koneksi.php");

    // Mengambil foto_id dari POST request
    $fotoID = $_POST['foto_id'];

    // Lakukan penghapusan foto dari album (misalnya, dengan mengatur AlbumID foto menjadi NULL)
    // Anda bisa menyesuaikan dengan logika penghapusan yang sesuai dengan aplikasi Anda

    // Menutup koneksi database
    mysqli_close($koneksi);

    // Mengirim pesan ke klien bahwa foto telah dihapus dari album
    echo "Foto ini telah dihapus dari Album";
} else {
    // Jika foto_id tidak disediakan
    echo "Gagal menghapus foto dari Album";
}
?>
