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
    $NamaLengkap = $user['NamaLengkap'];
} else {
    // Jika tidak dapat mengambil data pengguna, alihkan ke halaman login
    echo "<script>alert('Maaf, Terjadi Kesalahan'); window.location.assign('login.php');</script>";
    exit();
}

// Query untuk mengambil foto yang diunggah oleh pengguna
$query_foto = "SELECT * FROM foto WHERE UserID = $UserID";
$result_foto = mysqli_query($koneksi, $query_foto);

// Query untuk mengambil album yang dibuat oleh pengguna
$query_album = "SELECT * FROM album WHERE UserID = $UserID";
$result_album = mysqli_query($koneksi, $query_album);

// Handling penghapusan album
if (isset($_GET['delete_album'])) {
    $album_id = $_GET['delete_album'];
    // Pastikan $album_id adalah integer
    if (!is_numeric($album_id)) {
        echo "<script>alert('ID album tidak valid.'); window.location.assign('user.php');</script>";
        exit();
    }
    // Query untuk menghapus album dan foto-foto yang terkait
    $query_delete_photos = "DELETE FROM foto WHERE AlbumID = $album_id";
    $query_delete_album = "DELETE FROM album WHERE AlbumID = $album_id";
    // Eksekusi query
    if (mysqli_query($koneksi, $query_delete_photos) && mysqli_query($koneksi, $query_delete_album)) {
        echo "<script>alert('Album berhasil dihapus.'); window.location.assign('user.php');</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menghapus album. Silakan coba lagi.');</script>";
    }
}

// Handling edit foto
if (isset($_POST['edit_photo'])) {
    $photo_id = $_POST['photo_id'];
    $new_title = $_POST['new_title'];
    $new_description = $_POST['new_description'];

    // Query untuk memperbarui detail foto
    $update_photo_query = "UPDATE foto SET JudulFoto = '$new_title', DeskripsiFoto = '$new_description' WHERE FotoID = $photo_id";

    if (mysqli_query($koneksi, $update_photo_query)) {
        echo "<script>alert('Foto berhasil diperbarui.'); window.location.assign('user.php');</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui foto. Silakan coba lagi.');</script>";
    }
}

// Handling pengambilan data foto untuk diedit
if (isset($_GET['edit_photo'])) {
    $photo_id = $_GET['edit_photo'];
    // Query untuk mengambil data foto berdasarkan ID foto
    $query_fetch_photo = "SELECT * FROM foto WHERE FotoID = $photo_id AND UserID = $UserID";
    $result_fetch_photo = mysqli_query($koneksi, $query_fetch_photo);
    if ($result_fetch_photo && mysqli_num_rows($result_fetch_photo) > 0) {
        $photo_data = mysqli_fetch_assoc($result_fetch_photo);
        // Tampilkan form edit foto dengan data yang diambil dari database
        echo "<script>
                document.getElementById('photo_id').value = {$photo_data['FotoID']};
                document.getElementById('new_title').value = '{$photo_data['JudulFoto']}';
                document.getElementById('new_description').value = '{$photo_data['DeskripsiFoto']}';
                document.getElementById('editPhotoModal').style.display = 'block';
              </script>";
    } else {
        // Jika foto tidak ditemukan atau tidak milik pengguna, tampilkan pesan kesalahan
        echo "<script>alert('Tidak dapat mengambil data foto yang dipilih.');</script>";
    }
}
// Handling edit informasi pengguna
if (isset($_POST['edit_user'])) {
  // Proses untuk mengubah detail pengguna
  $new_username = $_POST['new_username'];
  $new_fullname = $_POST['new_fullname'];
  $new_email = $_POST['new_email'];
  $new_address = $_POST['new_address'];

  // Query untuk memperbarui informasi pengguna
  $update_user_query = "UPDATE user SET Username = '$new_username', NamaLengkap = '$new_fullname', Email = '$new_email', Alamat = '$new_address' WHERE UserID = $UserID";

  if (mysqli_query($koneksi, $update_user_query)) {
      // Update session jika informasi pengguna yang sedang login diubah
      $_SESSION['Username'] = $new_username;
      $_SESSION['NamaLengkap'] = $new_fullname;

      echo "<script>alert('Detail pengguna berhasil diperbarui.'); window.location.assign('user.php');</script>";
      exit();
  } else {
      echo "<script>alert('Gagal memperbarui detail pengguna. Silakan coba lagi.'); window.location.assign('user.php');</script>";
  }
}

// Handling edit password
if (isset($_POST['edit_password'])) {
  // Proses untuk mengubah password
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];

  // Query untuk mengambil password yang terenkripsi dari database
  $get_password_query = "SELECT Password FROM user WHERE UserID = $UserID";
  $result_password = mysqli_query($koneksi, $get_password_query);

  if ($result_password && mysqli_num_rows($result_password) > 0) {
      $row_password = mysqli_fetch_assoc($result_password);
      $hashed_password = $row_password['Password'];

      // Verifikasi password lama
      if (password_verify($old_password, $hashed_password)) {
          // Password lama cocok, maka lanjutkan proses pembaruan password

          // Enkripsi password baru
          $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

          // Query untuk memperbarui password pengguna
          $update_password_query = "UPDATE user SET Password = '$new_hashed_password' WHERE UserID = $UserID";

          if (mysqli_query($koneksi, $update_password_query)) {
              echo "<script>alert('Password berhasil diperbarui.'); window.location.assign('user.php');</script>";
              exit();
          } else {
              echo "<script>alert('Gagal memperbarui password. Silakan coba lagi.'); window.location.assign('user.php');</script>";
          }
      } else {
          echo "<script>alert('Password lama salah. Silakan coba lagi.'); window.location.assign('user.php');</script>";
          exit();
      }
  } else {
      echo "<script>alert('Gagal memperbarui password. Silakan coba lagi.'); window.location.assign('user.php');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Horizontal Tabs</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    body {
  font-family: Arial, sans-serif;
   background: linear-gradient(to right, #da4453, #89216b);
}

.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  display: flex;
  justify-content: space-between;
  border-radius: 10px 10px 0px 0px;
  background-color: #ddd;
  align-items: center;
}
.tab i{
  color: #5a6268;
  margin: 0px 4px;
}
.header1{
  background-color: #f1f1f1;
}
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}

.header1 button:hover {
  background-color: #ddd;
}

.header1 button.active {
  background-color: #ccc;
}

.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
  border-radius: 0px 0px 10px 10px;
  background-color:white;
}

.tabcontent h3 {
  margin-top: 0;
}
.header2 a{
    text-decoration: none;
    color: white;
}
.header2 a:hover{
    text-decoration: none;
    color: black;
}
.header2 .home-button {
    background-color: blue;
}

.header2 .home-button:hover{
    background-color: lightblue;
}
.header2 .logout-button{
    background-color: red;
}
.header2 .logout-button:hover{
    background-color: pink;
}
.masonry-grid {
  column-count: 3; /* Mengatur jumlah kolom menjadi 3 */
  column-gap: 10px; /* Mengatur jarak antar kolom */
}
#viewAlbumModal .masonry-grid {
  column-count: 3; /* Mengatur jumlah kolom menjadi 3 */
  column-gap: 10px; /* Mengatur jarak antar kolom */
}

#viewAlbumModal img {
  width: 100%; /* Gambar akan mengisi lebar dari kolom */
  max-width: 100%; /* Maksimum lebar gambar adalah 100% dari lebar kolom */
  height: auto; /* Gambar akan menyesuaikan tingginya */
  border-radius: 5px; /* Mengatur sudut gambar */
  margin-bottom: 10px; /* Mengatur jarak antara gambar */
}

.grid-item {
  display: inline-block;
  margin-bottom: 20px; /* Atur jarak antara item */
  width: 100%; /* Memastikan item memenuhi lebar kolom */
  position: relative;
}

.grid-item img {
  width: 100%;
  display: block;
  border-radius: 8px;
}

.overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.8); /* Atur transparansi latar belakang */
  padding: 10px;
  box-sizing: border-box;
  transition: 0.3s ease;
  opacity: 0;
}

.grid-item:hover .overlay {
  opacity: 1;
}

.modal {
  display: none;
  position: fixed; /* Letakkan modals di atas konten */
  z-index: 1; /* Menempatkan modals di depan konten */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto; /* Aktifkan scroll jika konten lebih panjang dari modals */
  background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* Tempatkan modals di tengah layar */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Sesuaikan lebar modals jika perlu */
  border-radius: 10px;
}

/* Tutup modals dengan style yang menarik */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

  /* Tambahkan gaya untuk ikon folder */
  .folder-icon {
    margin-right: 10px; /* Atur margin kanan untuk jarak antara ikon dan teks */
  }

  /* Mengatur tata letak menggunakan display grid */
  .card-menu {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Menentukan jumlah kolom dan lebar minimum maksimum */
    gap: 20px; /* Atur jarak antara card */
  }

  /* Mengatur tata letak card */
  .card {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }

  .card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: 0.3s;
  }
  /* Gaya untuk ikon folder */
.folder-icon {
    color: #5a6268; /* Warna ikon */
    font-size: 240px; /* Ukuran ikon */
    text-align: center;
}
  /* Style untuk form input */
  input[type=text], input[type=email], input[type=password], textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
  }

  /* Style untuk tombol submit */
  input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  input[type=submit]:hover {
    background-color: #45a049;
  }

  /* Style untuk form container */
  .form-container {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 10px;
  }
  @media only screen and (max-width: 600px) {
    .tab button {
        padding: 10px;
    }

    .tab button span {
        display: none;
    }

    .tab button i {
        display: block;
    }

    .header1 button{
        padding: 10px;
        font-size: 14px;
    }

    .header2 button{
        padding: 20px 10px;
    }

    .header1 button i, .header2 button i {
        margin-right: 5px;
        font-size: 18px;
    }

    .header1 button.active {
        background-color: #ccc;
    }

    .tabcontent {
        padding: 10px;
    }

    .masonry-grid {
        column-count: 1; /* Mengubah jumlah kolom menjadi 1 untuk tampilan mobile */
    }

    .grid-item {
        margin-bottom: 10px; /* Mengatur jarak antara item di tampilan mobile */
    }

    .modal-content {
        width: 90%; /* Mengurangi lebar modals untuk tampilan mobile */
        margin: 10% auto; /* Mengatur margin untuk modals di tengah layar */
    }

    .form-container {
        width: 100%; /* Mengurangi lebar form container untuk tampilan mobile */
    }

    .card-menu {
        grid-template-columns: 1fr; /* Mengubah tata letak kolom menjadi satu kolom untuk tampilan mobile */
    }

    .card {
        width: 90%; /* Memastikan card memenuhi lebar pada tampilan mobile */
    }

    .folder-icon {
        font-size: 100px; /* Mengurangi ukuran ikon folder untuk tampilan mobile */
    }

    .overlay {
        padding: 5px; /* Mengurangi padding overlay untuk tampilan mobile */
    }

    input[type=text], input[type=email], input[type=password], textarea {
        width: calc(100% - 24px); /* Mengurangi lebar input pada tampilan mobile */
    }

    input[type=submit] {
        padding: 10px 16px; /* Mengatur padding tombol submit untuk tampilan mobile */
    }

    .close {
        font-size: 24px; /* Mengurangi ukuran ikon close untuk tampilan mobile */
    }
}

/* Style untuk ikon di dalam tab */
.tab button i {
    margin-right: 5px;
}
</style>
<body>


<div class="tab">
    <div class="header1">
  <button class="tablinks" onclick="openTab(event, 'Users')"><i class="fas fa-user user-icon"></i>Profil</button>
  <button class="tablinks" onclick="openTab(event, 'Photos')"><i class="fas fa-camera photos-icon"></i>Foto</button>
  <button class="tablinks" onclick="openTab(event, 'Albums')"><i class="fas fa-book album-icon"></i>Album</button>
  </div>
  <div class="header2">
  <button class="home-button">
    <a href="index.php">Beranda</a>
    </button>
  <button class="logout-button">
    <a href="logout.php">Logout</a>
  </button>
</div>
</div>

<div id="Users" class="tabcontent">
  <h3>Profil User</h3>
  <p>Username: <?php echo $Username; ?></p>
  <p>Nama Lengkap: <?php echo $NamaLengkap; ?></p>
  <br />
  <form method="post" id="editUserForm">
    <h2>Edit Profil</h2>
    <label for="new_username">New Username:</label><br>
    <input type="text" id="new_username" name="new_username" value="<?php echo $Username; ?>"><br>
    <label for="new_fullname">New Full Name:</label><br>
    <input type="text" id="new_fullname" name="new_fullname" value="<?php echo $NamaLengkap; ?>"><br>
    <label for="new_email">New Email:</label><br>
    <input type="email" id="new_email" name="new_email" value="<?php echo $user['Email']; ?>"><br>
    <label for="new_address">New Address:</label><br>
    <textarea id="new_address" name="new_address"><?php echo $user['Alamat']; ?></textarea><br>
    <input type="submit" name="edit_user" value="Update User Details">
</form>

<!-- Form untuk mengubah password -->
<form method="post" id="editPasswordForm">
    <h2>Ganti Password</h2>
    <label for="new_password">New Password:</label><br>
    <input type="password" id="new_password" name="new_password"><br>
    <label for="old_password">Old Password:</label><br>
    <input type="password" id="old_password" name="old_password" required><br>
    <input type="submit" name="edit_password" value="Update Password">
</form>
</div>

<div id="Photos" class="tabcontent">
  <h3>Photos</h3>
  <div class="masonry-grid">
    <?php
    // Loop untuk menampilkan foto-foto yang diunggah oleh pengguna
    while ($row_foto = mysqli_fetch_assoc($result_foto)) {
      echo "<div class='grid-item'>";
      echo "<img src='uploads/" . $row_foto['LokasiFile'] . "' alt='" . $row_foto['JudulFoto'] . "'>";
      echo "<div class='overlay'>";
      echo "<h4><b>" . $row_foto['JudulFoto'] . "</b></h4>";
      echo "<p>" . $row_foto['DeskripsiFoto'] . "</p>";
      echo "<button onclick='editPhoto(" . $row_foto['FotoID'] . ", \"" . $row_foto['JudulFoto'] . "\", \"" . $row_foto['DeskripsiFoto'] . "\")'>Edit</button>";
      echo "<button onclick='deletePhoto(" . $row_foto['FotoID'] . ")'>Delete</button>";
      echo "</div>";
      echo "</div>";
    }
    ?>
  </div>
</div>


<div id="Albums" class="tabcontent">
  <h3>Albums</h3>
  <div class="card-menu">
    <?php
    // Loop untuk menampilkan album-album yang dibuat oleh pengguna
    while ($row_album = mysqli_fetch_assoc($result_album)) {
      echo "<div class='card'>";
      echo "<div class='container'>";
      // Tambahkan ikon folder di sini
      echo "<i class='fas fa-folder folder-icon'></i>"; // Tambahkan kelas 'folder-icon'
      echo "<h4><b>" . $row_album['NamaAlbum'] . "</b></h4>";
      echo "<p>" . $row_album['Deskripsi'] . "</p>";
      echo "<p>Tanggal Dibuat: " . $row_album['TanggalDibuat'] . "</p>";
      echo "<button onclick='viewAlbum(" . $row_album['AlbumID'] . ")'>View Album</button>";
      echo "</div>";
      echo "</div>";
    } 
    ?>
  </div>
</div>



<!-- Modal untuk melihat foto dalam sebuah album -->
<div id="viewAlbumModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Photos in Album</h2>
    <div class="masonry-grid" id="albumPhotos">
      <!-- Placeholder for album photos -->
    </div>
  </div>
</div>

<!-- Modal untuk mengedit foto -->
<div id="editPhotoModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal2()">&times;</span>
    <h2>Edit Photo</h2>
    <form method="post">
      <input type="hidden" id="photo_id" name="photo_id">
      <label for="new_title">New Title:</label><br>
      <input type="text" id="new_title" name="new_title"><br>
      <label for="new_description">New Description:</label><br>
      <textarea id="new_description" name="new_description"></textarea><br>
      <input type="submit" name="edit_photo" value="Update">
    </form>
  </div>
</div>

<script>
// Fungsi untuk membuka tab konten
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Fungsi untuk menutup modal untuk melihat foto dalam album
function closeModal() {
  document.getElementById('viewAlbumModal').style.display = 'none';
}

// Fungsi untuk menutup modal untuk mengedit foto
function closeModal2() {
  document.getElementById('editPhotoModal').style.display = 'none';
}

// Fungsi untuk menampilkan modal untuk melihat foto dalam album
function viewAlbum(albumID) {
  var modal = document.getElementById("viewAlbumModal");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("albumPhotos").innerHTML = this.responseText;
      modal.style.display = "block";
    }
  };
  xhttp.open("GET", "get_album_photos.php?albumID=" + albumID, true);
  xhttp.send();
}

// Fungsi untuk menampilkan modal untuk mengedit foto
function editPhoto(photoID, currentTitle, currentDescription) {
  document.getElementById('photo_id').value = photoID;
  document.getElementById('new_title').value = currentTitle;
  document.getElementById('new_description').value = currentDescription;
  document.getElementById('editPhotoModal').style.display = 'block';
}

// Fungsi untuk menghapus foto
function deletePhoto(photoID) {
  if (confirm("Apakah Anda yakin ingin menghapus foto ini?")) {
    window.location.href = "hapus_foto.php?photoID=" + photoID;
  }
}

// Default tab yang terbuka saat halaman dimuat
document.getElementsByClassName("tablinks")[0].click();

function deletePhoto(photoID) {
    if (confirm("Apakah Anda yakin ingin menghapus foto ini?")) {
        window.location.href = "hapus_foto.php?photoID=" + photoID;
    }
}

</script>

</body>
</html>


