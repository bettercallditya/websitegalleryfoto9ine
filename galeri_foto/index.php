<!-- index.php -->
<?php
session_start();
require_once("koneksi.php");

// Periksa apakah pengguna telah login
if (empty($_SESSION['UserID'])) {
    // Jika belum login, alihkan ke halaman login
    echo "<script>alert('Maaf Anda Belum Login'); window.location.assign('login.php');</script>";
    exit();
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
        z-index: 1000;
    }

    nav .logo {
        font-size: 30px;
        color: #e60023;
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
        transition: text-shadow 0.3s ease;
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

    .logo img{
        width: 50px;
        height: auto;
        color: #E60023;
    }

    a.icon {
        font-size: 20px;
        border-radius: 50px;
    }

    a.icon:hover {
        background: #d2d2d2;
    }

    /* CSS untuk masonry grid */
#container {
    columns: 4;
    columns-gap: 40px;
    margin-top: 100px;
}

.col {
    width: 100%;
    margin-bottom: 10px; /* Jarak antar baris */
    break-inside: avoid;
}

.col img {
    width: 100%;
    border-radius: 10px;
    box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.3); /* Efek bayangan pada gambar */
    transition: transform 0.3s ease; /* Transisi saat gambar dihover */
}

.col img:hover {
    transform: scale(1.05); /* Efek zoom saat gambar dihover */
}


    .card {
        margin: 0;
        width: 100%;
    }

    .card img {
        width: 100%;
        height: auto;
        object-fit: contain;
        border-radius: 20px;
    }

</style>

<body>
    <nav>
        <a class="logo" href="#"><img src="waltpaper.jpeg"/></a>
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

    <div class="tab-content">
        <div id="tab-panel-1" class="tab-panel">
            <div id="container">
                <?php
                // Query untuk mengambil data gambar dari database
                $query = "SELECT * FROM foto";
                $result = mysqli_query($koneksi, $query);

                // Loop untuk menampilkan gambar dalam class col
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Di dalam loop while -->
                <div class="col">
                <a href="detail-foto.php?photo_id=<?php echo $row['FotoID']; ?>">
                    <div class="card" onclick="openSidebar('<?php echo $row['JudulFoto']; ?>', '<?php echo $row['DeskripsiFoto']; ?>', 'uploads/<?php echo $row['LokasiFile']; ?>', '<?php echo $row['FotoID']; ?>', '<?php echo $row['UserID']; ?>', '<?php echo $row['TanggalUnggah']; ?>')">
                        <img src="uploads/<?php echo $row['LokasiFile']; ?>" alt="<?php echo $row['JudulFoto']; ?>">
                        <div class="card-body">
                        </div>
                    </div>
                </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>

