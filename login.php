<?php
session_start();

// Periksa apakah pesan alert harus ditampilkan
if (isset($_SESSION['registrationSuccessful']) && $_SESSION['registrationSuccessful']) {
    echo "<script>alert('Registrasi berhasil! Silakan login.')</script>";
    // Hapus variabel sesi setelah pesan ditampilkan
    unset($_SESSION['registrationSuccessful']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

:root {
    --mainColor: #89216b;
    --whiteColor: #ffffff;
    --titleColor: #555555;
    --labelColor: #333333;
}

html {
    font-size: 62.5%;
    scroll-behavior: smooth;
}

body {
    font-weight: 600;
    font-size: 1.5rem;
    display: grid;
    place-content: center;
    margin: 0 auto;
}

.wrapper {
    position: relative;
    margin: 0 auto;
}

@media(min-width: 540px) {
    .wrapper {
        width: 40rem;
    }
}

.wrapper .form-container {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 600px;
    background-color: var(--whiteColor);
    border-radius: .5rem;
    box-shadow: 0 0 1rem 0 rgba(0 0 0 / .2);
}

.wrapper .form-container form h2 {
    font-size: 2.5rem;
    text-align: center;
    text-transform: capitalize;
    color: var(--titleColor);
    margin-top: 2em;
}

.wrapper .form-container form .form-group {
    position: relative;
    width: 32rem;
    margin: 3rem 0;
}

.wrapper .form-container form .form-group label {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.6rem;
    text-transform: capitalize;
    color: var(--labelColor);
    padding: 0.5rem;
    pointer-events: none;
    transition: all .5s ease;
}


.wrapper .form-container form .form-group label {
    left: 2.5rem;
}

.wrapper .form-container form .form-group input {
    width: 100%;
    height: 4rem;
    padding: 0 1rem;
    border-radius: .5rem;
    border: none;
    outline: none;
    border: .1rem solid var(--labelColor);
    font-size: 1.6rem;
    color: var(--labelColor);
    background: transparent;
}

form .form-group input:focus~label,
form .form-group input:valid~label,
form .form-group input:focus~i,
form .form-group input:valid~i {
    top: 0 !important;
    font-size: 1.2rem !important;
    background-color: var(--whiteColor);
}

.wrapper .form-container form .forgot-pass {
    margin: -1.5rem 0 1.5rem;
}

.wrapper .form-container form .forgot-pass a {
    color: var(--labelColor);
    text-decoration: none;
    font-size: 1.4rem;
    text-transform: capitalize;
    transform: all .5s ease;
}

.wrapper .form-container form .forgot-pass a:hover {
    color: var(--mainColor);
}

.wrapper .form-container form .btn {
    background: linear-gradient(to right, #da4453, var(--mainColor));
    color: var(--whiteColor);
    text-transform: capitalize;
    width: 100%;
    height: 4rem;
    font-size: 1.6rem;
    font-weight: 500;
    outline: none;
    border: none;
    border-radius: .5rem;
    cursor: pointer;
    box-shadow: 0 .2rem 1rem rgba(0 0 0 / .4);
}

.wrapper .form-container form .link {
    text-align: center;
    font-size: 1.4rem;
    color: var(--labelColor);
    margin: 2.5rem 0;
}

.wrapper .form-container form .link a {
    text-transform: capitalize;
    color: var(--mainColor);
    text-decoration: none;
    font-weight: 600;
    transition: all .5s ease;
}

.wrapper .form-container form .link a:hover {
    color: #da4453;
}

.wrapper .sign-up {
    transform: rotate(7deg);
}

.wrapper.animated-signin .form-container.sign-in {
    animation: signin-flip 1s ease-in-out forwards;
}

@keyframes signin-flip {
    0% {
        transform: translateX(0);
    }

    50% {
        transform: translateX(-50rem) scale(1.1);
    }

    100% {
        transform: translateX(0) rotate(7deg) scale(1);
    }
}

.wrapper.animated-signin .form-container.sign-up {
    animation: rotatecard .7s ease-in-out forwards;
}

@keyframes rotatecard {
    0% {
        transform: rotate(7deg);
    }

    100% {
        transform: rotate(0);
        z-index: 1;
    }
}

.wrapper.animated-signup .form-container.sign-up {
    animation: signup-flip 1s ease-in-out forwards;
}

@keyframes signup-flip {
    0% {
        transform: translateX(0);
        z-index: 1;
    }

    50% {
        transform: translateX(50rem) scale(1.1);
    }

    100% {
        transform: translateX(0) rotate(7deg) scale(1);
    }
}

.wrapper.wrapper.animated-signup .form-container.sign-in {
    transform: rotate(7deg);
    animation: rotatecard .7s ease-in-out forwards;
    animation-delay: .3s;
}

@keyframes rotatecard {
    0% {
        transform: rotate(7deg);
    }

    100% {
        transform: rotate(0);
        z-index: 1;
    }
}
/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    max-width: 2600px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Navbar */
header {
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    z-index: 1000;
}

.logo{
    width: 50px;
    height: auto;
    color: #E60023;
}
.navbar {
    align-items: center;
    padding: 20px 0;
}

.navbar .container {
    display: flex;
    justify-content: space-between;
}

.nav-links {
    list-style-type: none;
    display: flex;
}

.nav-links li {
    margin-right: 20px;
    margin-top: 8px;
}

.nav-links li a {
    text-decoration: none;
    color: #333;
    transition: color 0.3s ease;
}

.nav-links li a:hover {
    color: #89216b;
}


/* Jumbotron */
.jumbotron {
    margin-top: 20px;
    background: linear-gradient(to right, #da4453, var(--mainColor));
    color: #fff;
    text-align: center;
    padding: 100px;
    display: flex;
}

.jumbotron h1 {
    font-size: 3rem;
    margin-top: 120px;
    margin-bottom: 20px;
}

.jumbotron p {
    font-size: 1.2rem;
    margin-bottom: 40px;
}

.btn {
    display: inline-block;
    background-color: #89216b;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #6c1851;
}

/* About Us */
.about-us {
    padding: 100px 0;
    background-color: #fff;
}

.about-us h2 {
    font-size: 2.5rem;
    margin-bottom: 40px;
    text-align: center;
}

.about-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.about-content img {
    max-width: 50%;
    margin-right: 20px;
}

.about-content p {
    flex: 1;
    text-align: justify;
    font-size: 18px;
}

/* Footer */
footer {
    background-color: #333;
    color: #fff;
    padding-top: 50px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    gap: 25px;
}

.footer-section {
    flex: 1;
}

.footer-section h2 {
    margin-bottom: 20px;
}

.footer-section p {
    text-align: justify;
}

.footer-section ul li{
    list-style-type: none;
    margin: 10px 0;
}

.footer-section a {
    padding: 10px;
    color: lightblue;
    text-decoration: none;
}
.footer-section a:hover{
    text-shadow: 1px 1px 5px #ddd;
}

.contact span {
    display: block;
    margin: 10px 0;
}

.social-links a {
    color: #fff;
    font-size: 3.5rem;
    margin-right: 15px;
}

.footer-bottom {
    position: sticky;
    width: 100%;
    background-color: #222;
    padding: 10px 0;
    text-align: center;
    bottom: 0;
}

.footer-bottom p {
    margin: 0;
}

/* Wrapper */
.wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 560px;
}

.form-container {
    max-width: 400px;
    width: 100%;
    padding: 40px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.form-container h2 {
    font-size: 2rem;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

.btn {
    display: block;
    width: 100%;
    background-color: #89216b;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
}

.btn:hover {
    background-color: #6c1851;
}
.toggle-button{
    display: none;
}
        /* Add responsive styles */
        @media only screen and (max-width: 600px) {
            .nav-links {
                margin-top: 20px;
                display: none;
            }

            .nav-links li {
                margin: 10px 0;
            }

            /* Jumbotron */
            .jumbotron {
                padding: 120px 50px;
                display: inline;
            }

            .jumbotron h1 {
                font-size: 2.5rem;
                margin-top: 10px;
            }

            .jumbotron p {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            /* Form */
            .form-container {
                max-width: 100%;
            }

            .form-container form h2 {
                font-size: 1.5rem;
                margin-top: 1em;
            }

            .form-container form .form-group {
                width: 100%;
                margin: 1.5rem 0;
            }

            .wrapper {
                margin-top: 50px;
                height: auto;
                min-height: 100vh;
            }

            /* About Us */
            .about-content {
                flex-direction: column;
            }

            .about-content img {
                max-width: 100%;
                margin-right: 0;
                margin-bottom: 20px;
            }

            /* Footer */
            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-section {
                margin-bottom: 40px;
            }

            .social-links a {
                font-size: 2rem;
            }
            .wrapper {
        display: flex;
        flex-direction: column; /* Ubah tata letak menjadi kolom */
        align-items: center;
        height: auto; /* Hilangkan tinggi tetap */
        padding: 20px; /* Tambahkan padding */
    }

    .wrapper .form-container {
        width: 100%; /* Buat lebar form-container 100% */
        max-width: 400px; /* Tetapkan maksimum lebar */
        margin-bottom: 20px; /* Tambahkan margin bawah */
    }

    .form-container form .form-group {
        width: 100%; /* Buat input mengisi lebar */
    }

    .wrapper .form-container form .form-group label {
        left: 2rem; /* Sesuaikan posisi label */
        
    }

    .wrapper .form-container form .form-group input {
        font-size: 1.5rem; /* Ubah ukuran font input */
        width: 90%;
    }

    .wrapper .form-container form .btn {
        font-size: 1.2rem; /* Ubah ukuran font tombol */
        width: 80%;
        margin: 0px 2.5rem;
    }

    .wrapper .form-container form .link {
        margin-top: 0.5rem; /* Sesuaikan margin atas */
    }
    /* Tambahkan aturan CSS untuk tombol hamburger */
.toggle-button {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 10px;
    display: block;
}

.toggle-button i {
    font-size: 1.5rem;
    color: #333;
}

.nav-links {
    list-style-type: none;
    display: none; /* Sembunyikan menu navigasi secara default */
}

.nav-links.active {
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 70px; /* Sesuaikan posisi menu dropdown */
    right: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    z-index: 1000;
}

.nav-links li {
    margin-right: 20px;
    margin-top: 8px;
}

.nav-links li a {
    text-decoration: none;
    color: #333;
    transition: color 0.3s ease;
}

.nav-links li a:hover {
    color: #89216b;
}

        }

    </style>
    <title>Signin & Sign up</title>
</head>

<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar">
            <div class="container">
                <img src="waltpaper.jpeg" alt="Walt-paper Logo" class="logo"/>
            <button class="toggle-button">
                <i class="fas fa-bars"></i>
            </button>
            <!-- /Tambahkan tombol hamburger -->
            <ul class="nav-links">
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
            </div>
        </nav>
    </header>

    <!-- Jumbotron -->
    <section class="jumbotron">
        <div class="container">
            <h1>Selamat datang di Walt-paper</h1>
            <p>Temukan dan nikmati beragam koleksi foto yang memukau.</p>
            <a href="#" class="btn">Mulai</a>
        </div>
        <!-- Form Sign up & Sign in -->
        <div class="wrapper">
            <div class="form-container sign-up">
                <form action="proses-register.php" method="POST">
                    <h2>Bergabunglah Bersama Kami</h2>
                    <div class="form-group">
                        <input type="text" name="Username" required>
                        <label for="">Username</label>
                    </div>
                    <div class="form-group">
                        <input type="email" name="Email" required>
                        <label for="">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" name="Password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="NamaLengkap" required>
                        <label for="">Nama Lengkap</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="Alamat" required>
                        <label for="">Alamat</label>
                    </div>
                    <button type="submit" name="signup" class="btn">Daftar</button>
                    <div class="link">
                        <p>Sudah memiliki akun? <a href="javascript:void(0)" class="signin-link">Masuk</a></p>
                    </div>
                </form>
            </div>
            <div class="form-container sign-in">
                <form action="proses-login.php" method="POST">
                    <h2>Masuk ke Akun Anda</h2>
                    <div class="form-group">
                        <input type="text" name="Username" required>
                        <label for="">Username</label>
                    </div>
                    <div class="form-group">
                        <input type="password" name="Password" required>
                        <label for="">Password</label>
                    </div>
                    <div class="forgot-pass">
                        <a href="#">Lupa password?</a>
                    </div>
                    <button type="submit" name="login" class="btn">Masuk</button>
                    <div class="link">
                        <p>Belum memiliki akun? <a href="javascript:void(0)" class="signup-link">Daftar</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="about-us">
        <div class="container">
            <h2>Tentang Kami</h2>
            <div class="about-content">
                <img src="foto.jpeg" alt="Gambar Tentang Kami">
                <p>Walt-paper adalah destinasi utama bagi para pecinta fotografi yang ingin menjelajahi berbagai macam karya seni visual. Kami berkomitmen untuk menyajikan koleksi foto yang menginspirasi dan memukau dari berbagai sudut pandang. Dari alam hingga arsitektur, dari potret hingga lanskap, kami menyediakan pengalaman yang tak terlupakan untuk para pengguna kami.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2>Tentang Kami</h2>
                    <p>Walt-paper adalah destinasi utama bagi para pecinta fotografi yang ingin menjelajahi berbagai macam karya seni visual. Kami berkomitmen untuk menyajikan koleksi foto yang menginspirasi dan memukau dari berbagai sudut pandang. Dari alam hingga arsitektur, dari potret hingga lanskap, kami menyediakan pengalaman yang tak terlupakan untuk para pengguna kami.</p>
                    <div class="contact">
                        <span><i class="fas fa-envelope"></i> Email: waltpaper@gmail.com</span>
                        <span><i class="fas fa-phone"></i> Phone: +62 896-2631-0140</span>
                    </div>
                </div>
                <div class="footer-section links">
                    <h2>Tautan Cepat</h2>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Galeri</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-section social">
                    <h2>Ikuti Kami</h2>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 Walt-paper. Hak cipta dilindungi.
        </div>
    </footer>
    <script>
        let wrapper = document.querySelector('.wrapper'),
    signUpLink = document.querySelector('.link .signup-link'),
    signInLink = document.querySelector('.link .signin-link');

signUpLink.addEventListener('click', () => {
    wrapper.classList.add('animated-signin');
    wrapper.classList.remove('animated-signup');
});

signInLink.addEventListener('click', () => {
    wrapper.classList.add('animated-signup');
    wrapper.classList.remove('animated-signin');
});
// Tambahkan event listener untuk tombol hamburger
document.querySelector('.toggle-button').addEventListener('click', () => {
    document.querySelector('.nav-links').classList.toggle('active');
});

    </script>
</body>

</html>
