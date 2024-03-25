<!-- create.php -->
<?php
session_start();
require_once("koneksi.php");
if(empty($_SESSION['UserID'])){
    echo"<script>alert('Maaf Anda Belum Login');
    window.location.assign('login.php'); </script>";
}
// Ambil informasi pengguna dari basis data
$UserID = $_SESSION['UserID'];
$query = "SELECT * FROM user WHERE UserID = $UserID";
$result = mysqli_query($koneksi, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $Username = $user['Username'];
} else {
    // Jika tidak dapat mengambil data pengguna, beri nama pengguna default
    $Username = "Tamu";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari formulir
    $JudulFoto = $_POST['judul'];
    $DeskripsiFoto = $_POST['deskripsi'];
    $AlbumID = $_POST['AlbumID'];
    $TanggalUnggah = date("Y-m-d");
    $UserID = $_SESSION['UserID'];

    // Mendapatkan nama file dan ekstensi
    $namaFile = $_FILES['gambar']['name'];
    $namaSementara = $_FILES['gambar']['tmp_name'];

    // Direktori penyimpanan gambar
    $direktori = "uploads/" . $namaFile;

    // Pindahkan file yang diunggah ke direktori penyimpanan
    if (move_uploaded_file($namaSementara, $direktori)) {
        // Simpan data ke database
        $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID) VALUES ('$JudulFoto', '$DeskripsiFoto', '$TanggalUnggah', '$namaFile', '$AlbumID', '$UserID')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>alert('Gambar berhasil diunggah');</script>";
        } else {
            echo "<script>alert('Gagal mengunggah gambar');</script>";
        }
    } else {
        echo "<script>alert('Gagal memindahkan file');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Pinterest -Dogs</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: system-ui, -apple-system, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #ffff;
    }

    nav {
        display: flex;
        padding: 10px;
        align-items: center;
        gap: 10px;
        position: fixed;
        top: 0;
        background: #fff;
        left: 0;
        right: 0;
        justify-content: space-between;
    }

    nav .logo img{
        width: 50px;
        height: auto;
        color: #E60023;
    }

    nav ul {
        display: flex;
        list-style-type: none;
    }

    nav ul li {
        margin-right: 10px;
    }

    nav ul li a {
        text-decoration: none;
        color: #000;
        font-weight: 600;
        padding: 10px 15px;
        border-radius: 20px;
    }

    nav ul li a.active {
        background: #000;
        color: #fff;
    }

    .form-input{
        position: relative;
        width: 100%;
    }

    input.search {
        width: 100%;
            padding: 15px; /* Menyesuaikan padding input */
            border-radius: 20px;
            border: none;
            outline: none;
            background: #e9e9e9;
            font-weight: 500;
        }


        input.search::placeholder {
            color: #999;
        }

        button.search-btn {
            width: 50px; /* Menyesuaikan lebar tombol */
            height: 45px; /* Menyesuaikan tinggi tombol agar sama dengan input */
            border: none;
            outline: none;
            background: #e9e9e9;
            border-radius: 0 20px 20px 0; /* Membuat sudut tombol kiri bawah dan kanan bawah menjadi bundar */
            cursor: pointer;
            position: absolute;
            right: 0;
        }

        button.search-btn:hover {
            background: #ddd;
        }

        .search-icon {
            color: #666; /* Mengatur warna ikon */
        }

    .user{
        font-weight: 700;
        font-size: 20px;
        text-decoration: none;
        color: #000;
        transition: text-shadow 0.8s ease;
    }

    .user:hover{
        color: blue;
        text-shadow: 1px 1px 8px lightblue;
    }


    .tab-control {
        display: inline-block;
        border-bottom: 2px solid transparent;
        font-size: 1.25rem;
        padding: 0.6rem 1rem;
        cursor: pointer;
        transition: all 0.25s ease;
        color: #000;
        text-decoration: none;
    }

    .tab-control:hover {
        color: #3565ff;
    }

    .logo {
        font-size: 30px;
        color: #E60023;
    }

    a.icon {
        font-size: 20px;
        border-radius: 50px;
    }

    a.icon:hover {
        background: #d2d2d2;
    }

.create-img {
    margin-top: 100px;
    margin-bottom: 65px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column; /* Tambahkan ini agar konten berada di tengah secara vertikal */
    width: 100%; /* Sesuaikan lebar formulir dengan kebutuhan Anda */
}
.uploaded-image {
    margin-bottom: 20px; /* Tambahkan margin bawah agar formulir input tidak terlalu dekat dengan gambar */
    max-width: 100%; /* Membuat gambar responsif */
}

#create-img form {
    width: 100%; /* Mengatur lebar formulir agar responsif */
}

#create-img form input[type="submit"] {
    margin-top: 20px;
    background-color: #e60023;
    width: 100%; /* Mengatur lebar tombol submit agar responsif */
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

h2{
    font-weight: 1000;
    font-size: 45px;
}
        .create-img form {
            width: 70%;
        }
        .create-img form input[type="text"],
        .create-img form input[type="file"],
        .create-img form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 30px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
        }
        .create-img form input[type="submit"] {
            margin-top: 20px;
            background-color: #e60023;
            width: 100%;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .create-img form input[type="submit"]:hover {
            background-color: #c4001a;
        }
        .create-img form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            cursor: pointer;
        }
        .create-img option {
            padding: 100%;
        }
        #preview-image{
            margin-top: 20px;
            width: 350px;
            height: 400px;
            object-fit: cover;
            border-radius: 10%;
        }
        .icon-links {
       display: none;
    }

    .search-container{
        display:none;
    }
    @media only screen and (max-width: 768px) {
            /* Media query for screens smaller than 768px (typical mobile devices) */

            .tab-control {
                display: none; /* Hide text for navbar links */
            }

            .search-container {
                display: none; /* Hide search container initially */
                position: absolute;
                top: 60px; /* Adjust this value based on your navbar height */
                width: 100%;
                background-color: #fff;
                padding: 10px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 999;
                left: 0;
            }

            .search-container input.search {
                width: 100%; /* Adjust input width */
            }

            .search-container button{
                margin-right: 10px;
            }

            .icon-links {
                display: flex;
                justify-content: space-between;
            }

            /* CSS untuk ikon di perangkat mobile */
            .icon-links i {
                color: gray; 
                transition: background-color 0.3s ease; 
                padding: 0px 1rem;
                font-size: 1.5rem;
            }

            .icon-links i:hover {
                color: #da4453; 
            }
            .form-input{
                display: none;
            }
            uploaded-image img {
                max-width: 100%; /* Membuat gambar responsif */
                height: auto; /* Membuat tinggi gambar otomatis menyesuaikan lebar */
                max-height: 400px; /* Mengatur tinggi maksimum gambar */
            }
        }
</style>

<body>
<nav>
        <a class="logo" href="#"><img src="waltpaper.jpeg"/></a>
        <div class="icon-links">
            <a href="index.php" class="icon"><i class="fas fa-home"></i></a>
            <a href="create.php" class="icon"><i class="fas fa-plus"></i></a>
            <a href="album.php" class="icon"><i class="fas fa-book"></i></a>
            <a href="javascript:void(0);" class="icon" onclick="toggleSearch()">
                <i class="fas fa-search"></i>
            </a>
        </div>
        <div class="search-container" id="searchContainer">
            <form action="search.php" method="GET" class="form-input-mobile">
                <input type="text" class="search" placeholder="Search" name="search">
                <button type="submit" class="search-btn"><i class="fas fa-search search-icon"></i></button>
            </form>
        </div>
        <a href="index.php" class="tab-control">Home</a>
        <a href="create.php" class="tab-control">Create</a>
        <a href="album.php" class="tab-control">Album</a>
        <form action="search.php" method="GET" class="form-input">
        <input type="text" class="search" placeholder="Search" name="search">
        <button type="submit" class="search-btn"><i class="fas fa-search search-icon"></i></button>
    </form>
        <a href="user.php" class="user">
        <?php echo $Username; ?>
        </a>

    </nav>
    <div class="create-img">
    <h2>Upload Your Image</h2>
    <!-- Temporary container for uploaded image -->
    <div class="uploaded-image">
        <img id="preview-image" src="no.jpg" alt="Preview Image">
    </div>
    <!-- Form for uploading image -->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="gambar" id="upload-image" accept="image/" onchange="previewImage(event)" required>
        <input type="text" name="judul" placeholder="Judul Foto" required>
        <input type="text" name="deskripsi" placeholder="Deskripsi Foto" required>
        <select name="AlbumID" required>
            <option value="">Pilih Album</option>
            <?php
            $UserID = $_SESSION['UserID'];
            $sql = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$UserID'");
            while ($data = mysqli_fetch_array($sql)) {
                ?>
                <option value="<?= $data['AlbumID'] ?>"><?= $data['NamaAlbum'] ?></option>
            <?php
            }
            ?>
        </select>
        <input type="submit" value="Upload">
    </form>
</div>
           
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('preview-image');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
        // JavaScript function to toggle search container visibility
        function toggleSearch() {
            var searchContainer = document.getElementById('searchContainer');
            if (searchContainer.style.display === 'block') {
                searchContainer.style.display = 'none';
            } else {
                searchContainer.style.display = 'block';
            }
        }
</script>

</body>

</html>


