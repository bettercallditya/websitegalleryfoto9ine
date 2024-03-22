<?php
session_start();
require_once("koneksi.php");

if (empty($_SESSION['UserID'])) {
    exit();
}

if (isset($_POST['photo_id'])) {
    $photo_id = $_POST['photo_id'];
    $user_id = $_SESSION['UserID'];

    // Periksa apakah pengguna telah menyukai foto ini sebelumnya
    $query_check_like = "SELECT * FROM likefoto WHERE FotoID = '$photo_id' AND UserID = '$user_id'";
    $result_check_like = mysqli_query($koneksi, $query_check_like);

    if ($result_check_like && mysqli_num_rows($result_check_like) > 0) {
        // Jika pengguna sudah menyukai foto ini, hapus like dari database
        $query_delete_like = "DELETE FROM likefoto WHERE FotoID = '$photo_id' AND UserID = '$user_id'";
        mysqli_query($koneksi, $query_delete_like);
    } else {
        // Jika pengguna belum menyukai foto ini sebelumnya, tambahkan like ke database
        $query_add_like = "INSERT INTO likefoto (FotoID, UserID, TanggalLike) VALUES ('$photo_id', '$user_id', CURRENT_DATE())";
        mysqli_query($koneksi, $query_add_like);
    }

    // Arahkan kembali ke halaman detail foto setelah selesai like atau unlike
    header("Location: detail-foto.php?photo_id=$photo_id");
    exit();
}
?>
