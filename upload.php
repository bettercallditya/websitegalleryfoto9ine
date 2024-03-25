<!-- upload.php -->
<?php
session_start();
require_once("koneksi.php");

$JudulFoto = $_POST['judul'];
$DeskripsiFoto = $_POST['deskripsi'];
$AlbumID = $_POST['AlbumID'];
$TanggalUnggah = date("Y-m-d");
$UserID = $_SESSION['UserID'];

$namaFile = $_FILES['gambar']['name'];
$ukuranFile = $_FILES['gambar']['size'];
$error = $_FILES['gambar']['error'];
$tmpName = $_FILES['gambar']['tmp_name'];

if ($error === 4) {
    echo "<script>alert('Pilih gambar terlebih dahulu');</script>";
    exit();
}

$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
$ekstensiGambar = explode('.', $namaFile);
$ekstensiGambar = strtolower(end($ekstensiGambar));

if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>alert('File yang diunggah bukan gambar');</script>";
    exit();
}

// Maksimal ukuran file 1MB
if ($ukuranFile > 1000000) {
    echo "<script>alert('Ukuran gambar terlalu besar');</script>";
    exit();
}

// Generate nama file baru
$namaFileBaru = uniqid();
$namaFileBaru .= '.';
$namaFileBaru .= $ekstensiGambar;

// Pindahkan file yang diunggah ke folder uploads
$target = 'uploads/' . $namaFileBaru;
if (move_uploaded_file($tmpName, $target)) {
    // Simpan data ke database
    $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID) VALUES ('$JudulFoto', '$DeskripsiFoto', '$TanggalUnggah', '$namaFileBaru', '$AlbumID', '$UserID')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Gambar berhasil diunggah');</script>";
        // Arahkan ke index.php setelah berhasil mengunggah gambar
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Gagal mengunggah gambar');</script>";
    }
} else {
    echo "<script>alert('Gagal memindahkan file');</script>";
}
?>

