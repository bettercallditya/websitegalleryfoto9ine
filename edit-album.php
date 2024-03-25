<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back{
            padding: 9.5px 18px;
            text-decoration: none;
            color: white;
            background-color: red;
            border-radius: 5px;
            font-size: 14px;
        }

        .back:hover{
            padding: 9.5px 18px;
            text-decoration: none;
            color: white;
            background-color: darkred;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
<body>
    <?php
    require_once("koneksi.php");

    // Ambil informasi album dari basis data berdasarkan AlbumID yang diterima dari URL
    if(isset($_GET['AlbumID'])) {
        $AlbumID = $_GET['AlbumID'];
        $query = "SELECT * FROM album WHERE AlbumID = $AlbumID";
        $result = mysqli_query($koneksi, $query);
        $album = mysqli_fetch_assoc($result);
    } else {
        echo "AlbumID tidak tersedia";
        exit();
    }
    ?>

    <h2>Edit Album</h2>
    <form action="proses-edit-album.php" method="POST">
        <input type="hidden" name="AlbumID" value="<?php echo $AlbumID; ?>">
        <label for="NamaAlbum">Nama Album:</label><br>
        <input type="text" id="NamaAlbum" name="NamaAlbum" value="<?php echo $album['NamaAlbum']; ?>"><br>
        <label for="Deskripsi">Deskripsi:</label><br>
        <input type="text" id="Deskripsi" name="Deskripsi" value="<?php echo $album['Deskripsi']; ?>"><br><br>
        <input type="submit" value="Simpan">
        <a href="album.php" class="back">Batal</a>
    </form>
</body>
</html>
