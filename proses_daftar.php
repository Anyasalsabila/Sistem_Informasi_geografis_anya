<?php
session_start();
include 'koneksi.php'; // Sertakan file koneksi

$user   = $_POST['username']; // Tangkap input username
$pass   = $_POST['password']; // Tangkap input password

// Query untuk menambahkan pengguna baru ke database
$result = $mysqli->query("INSERT INTO user (user, pass, level) VALUES ('$user', '$pass', 'user')");

// Cek jika query berhasil dieksekusi
if ($result) {
    $_SESSION['msg'] = "Akun berhasil dibuat. Silakan login."; // Set pesan untuk notifikasi berhasil
    $_SESSION['msg_type'] = "success"; // Set tipe pesan sebagai 'success'
    header('Location: daftar.php'); // Alihkan pengguna ke halaman daftar
} else {
    $_SESSION['msg'] = "Gagal membuat akun. Silakan coba lagi."; // Set pesan untuk notifikasi gagal
    $_SESSION['msg_type'] = "danger"; // Set tipe pesan sebagai 'danger'
    header('Location: daftar.php'); // Alihkan pengguna kembali ke halaman daftar
}
