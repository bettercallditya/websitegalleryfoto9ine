
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

// Ambil data foto yang sedang dilihat
if(isset($_GET['photo_id'])) {
    $photo_id = $_GET['photo_id'];
    $query_photo = "SELECT foto.*, user.Username AS UploaderUsername FROM foto JOIN user ON foto.UserID = user.UserID WHERE FotoID = $photo_id";
    $result_photo = mysqli_query($koneksi, $query_photo);

    if ($result_photo && mysqli_num_rows($result_photo) > 0) {
        $photo = mysqli_fetch_assoc($result_photo);
        $judul_foto = $photo['JudulFoto'];
        $deskripsi_foto = $photo['DeskripsiFoto'];
        $lokasi_foto = $photo['LokasiFile'];
        $uploader_username = $photo['UploaderUsername']; // Ambil username uploader
        $tanggal_upload = $photo['TanggalUnggah'];
    } else {
        // Jika tidak dapat mengambil data foto, kembalikan ke halaman sebelumnya
        header("Location: index.php");
        exit();
    }
} else {
    // Jika tidak ada parameter foto_id, kembalikan ke halaman sebelumnya
    header("Location: index.php");
    exit();
}
// Query untuk menghitung jumlah like
$query_count_likes = "SELECT COUNT(*) AS jumlah_likes FROM likefoto WHERE FotoID = '$photo_id'";
$result_count_likes = mysqli_query($koneksi, $query_count_likes);
$row_count_likes = mysqli_fetch_assoc($result_count_likes);
$jumlah_likes = $row_count_likes['jumlah_likes'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Detail Foto</title>
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
            background: linear-gradient(to right, #da4453, #89216b);
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
            justify-content: space-between;
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

        .tab-content {
            margin-top: 80px;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 800px;
        }

        .card {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 20px;
            background-color: white;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 20px;
        }

        .like-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .like-container button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .like-container span {
            margin-left: 10px;
        }

        .comments-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .comment {
            padding: 15px 20px;
            border-radius: 20px;
            background-color: #f0f0f0;
            position: relative;
            max-width: 70%;
        }

        .comment:before {
            content: '';
            position: absolute;
            top: 50%;
            left: -20px;
            width: 0;
            height: 0;
            border: 10px solid transparent;
            border-right-color: #f0f0f0;
            border-left: 0;
            border-bottom: 0;
            margin-top: -10px;
        }

        .comment .user {
            font-weight: bold;
        }

        .comment .date {
            font-size: 12px;
            color: gray;
        }

        form[action="komentar.php"] {
            width: 100%;
        }

        form[action="komentar.php"] textarea {
            width: calc(100% - 20px);
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        form[action="komentar.php"] button {
            background-color: #e60023;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form[action="komentar.php"] button:hover {
            background-color: #c5001a;
        }
        textarea{
            width: 100%;
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
            #container {
                columns: 2;
                columns-gap: 40px;
                margin-top: 100px;
            }
        }
    </style>

</head>

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


    <div class="tab-content">
        <div id="tab-panel-1" class="tab-panel">
            <div class="container">
                <div class="col">
                    <div class="card">
                            <h2><?php echo $uploader_username; ?></h2>
                            <small><?php echo $tanggal_upload; ?></small>
                        <img src="uploads/<?php echo $lokasi_foto; ?>" alt="<?php echo $judul_foto; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $judul_foto; ?></h5>
                            <p class="card-text"><?php echo $deskripsi_foto; ?></p>
                                    
                        <!-- Fitur Like -->
                        <div class="like-container">
                            <form id="like-form" method="post" action="like.php">
                                <input type="hidden" name="photo_id" value="<?php echo $photo_id; ?>">
                                <button type="submit" name="like_submit" id="like-button">
                                    <?php
                                    // Periksa apakah pengguna sudah menyukai foto ini sebelumnya
                                    $query_check_like = "SELECT * FROM likefoto WHERE FotoID = '$photo_id' AND UserID = '$UserID'";
                                    $result_check_like = mysqli_query($koneksi, $query_check_like);
                                    if ($result_check_like && mysqli_num_rows($result_check_like) > 0) {
                                        // Jika pengguna sudah menyukai foto ini, tampilkan ikon hati yang sudah terisi (liked)
                                        echo '<i class="fas fa-heart like-icon" style="color: red;"></i>';
                                    } else {
                                        // Jika pengguna belum menyukai foto ini, tampilkan ikon hati kosong (unliked)
                                        echo '<i class="fas fa-heart like-icon" style="color: black;"></i>';
                                    }
                                    ?>
                                </button>
                            </form>
                            <span id="like-count"><?php echo $jumlah_likes; ?></span>
                        </div>


        <!-- Fitur Komentar -->
        <form action="komentar.php" method="post">
            <input type="hidden" name="photo_id" value="<?php echo $photo_id; ?>">
            <textarea name="comment_content" placeholder="Komentar"></textarea>
            <button type="submit" name="comment_submit">Kirim Komentar</button>
        </form>
        </div>
        <!-- Tampilan komentar -->
        <div class="comments-container">
            <?php
            // Query untuk mendapatkan komentar foto dari database
            $query_comments = "SELECT komentarfoto.*, user.Username FROM komentarfoto JOIN user ON komentarfoto.UserID = user.UserID WHERE FotoID = $photo_id";
            $result_comments = mysqli_query($koneksi, $query_comments);

            // Menampilkan komentar
            if ($result_comments && mysqli_num_rows($result_comments) > 0) {
                while ($comment = mysqli_fetch_assoc($result_comments)) {
                    $comment_username = $comment['Username'];
                    $comment_date = $comment['TanggalKomentar'];
                    $comment_content = $comment['IsiKomentar'];
            ?>
                    <div class="comment">
                        <span class="user"><?php echo $comment_username; ?></span>
                        <span class="date"><?php echo $comment_date; ?></span>
                        <p><?php echo $comment_content; ?></p>
                    </div>
            <?php
                }
            } else {
                echo "Belum ada komentar untuk foto ini.";
            }
            ?>
                </div>
            </div>
        </div>
    </div>
<!-- Script JavaScript -->
<script>
    // Menggunakan AJAX untuk mengirim permintaan ke like.php
    function toggleLike() {
        var photo_id = "<?php echo $photo_id; ?>";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Merefresh halaman setelah permintaan selesai
                location.reload();
            }
        };
        xhttp.open("POST", "like.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("photo_id=" + photo_id);
    }

    // Memanggil fungsi toggleLike() saat ikon hati ditekan
    document.getElementById("like-icon").addEventListener("click", toggleLike);

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

