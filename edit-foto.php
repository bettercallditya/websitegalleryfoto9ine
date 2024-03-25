<!-- edit-foto.php -->
<?php
session_start();
require_once("koneksi.php");
if (empty($_SESSION['UserID'])) {
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('login.php');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    // Mendapatkan nilai dari formulir
    $FotoID = $_POST['foto_id'];
    $JudulFoto = $_POST['judul'];
    $DeskripsiFoto = $_POST['deskripsi'];
    $AlbumID = $_POST['AlbumID'];

    // Update data di database
    $query = "UPDATE foto SET JudulFoto='$JudulFoto', DeskripsiFoto='$DeskripsiFoto', AlbumID='$AlbumID' WHERE FotoID='$FotoID'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Foto berhasil diperbarui'); window.location.assign('user.php');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui foto');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $FotoID = $_GET['foto_id'];

    // Hapus foto dari database
    $query_delete = "DELETE FROM foto WHERE FotoID='$FotoID'";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
        echo "<script>alert('Foto berhasil dihapus'); window.location.assign('user.php');</script>";
    } else {
        echo "<script>alert('Gagal menghapus foto');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23888"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #e60023;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #c4001a;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #666;
            font-size: 14px;
        }

        a:hover {
            color: #333;
        }

        .foto-container {
            max-width: 400px;
            margin: 20px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .foto-container img {
            width: 100%;
            display: block;
        }
    </style>
</head>

<body>
    <h1>Edit Foto</h1>
    <?php
    if (isset($_GET['foto_id'])) {
        $FotoID = $_GET['foto_id'];
        $query_foto = "SELECT * FROM foto WHERE FotoID = $FotoID";
        $result_foto = mysqli_query($koneksi, $query_foto);
        $foto = mysqli_fetch_assoc($result_foto);
        ?>
        <form action="" method="post">
            <div class="foto-container">
                <img src="uploads/<?php echo $foto['LokasiFile']; ?>" alt="Foto yang Diedit">
            </div>
            <input type="hidden" name="foto_id" value="<?php echo $FotoID; ?>">
            <label for="judul">Judul Foto:</label>
            <input type="text" id="judul" name="judul" value="<?php echo $foto['JudulFoto']; ?>">
            <label for="deskripsi">Deskripsi Foto:</label>
            <textarea id="deskripsi" name="deskripsi"><?php echo $foto['DeskripsiFoto']; ?></textarea>
            <label for="album">Pilih Album:</label>
            <select name="AlbumID">
                <?php
                $UserID = $_SESSION['UserID'];
                $sql = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$UserID'");
                while ($data = mysqli_fetch_array($sql)) {
                    if ($data['AlbumID'] == $foto['AlbumID']) {
                        echo "<option value='" . $data['AlbumID'] . "' selected>" . $data['NamaAlbum'] . "</option>";
                    } else {
                        echo "<option value='" . $data['AlbumID'] . "'>" . $data['NamaAlbum'] . "</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" name="edit" value="Simpan Perubahan">
        </form>
        <a href="user.php">Batal</a>
        <br><br>
        <a href="?delete&foto_id=<?php echo $FotoID; ?>" onclick="return confirm('Anda yakin ingin menghapus foto ini?');">Hapus Foto</a>
    <?php } else {
        echo "Foto tidak ditemukan.";
    }
    ?>
</body>

</html>

