<?php
// Mulai sesi
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Alihkan ke halaman login atau halaman lain yang sesuai
header("Location: login.php");
exit();
?>
