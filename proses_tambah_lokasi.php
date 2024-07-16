<?php

session_start();

include 'koneksi.php';

$latlng = $_POST['latlng'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

$gambar = $_FILES['gambar']['name'];
$dir = "assets/img/";
$dirFile = $_FILES['gambar']['tmp_name'];
move_uploaded_file($dirFile, $dir . $gambar);


$result = $mysqli->query("INSERT INTO lokasi (lat_lng, nama_lokasi, kategori, keterangan, gambar) VALUES ('" . $latlng . "', '" . $nama . "', '" . $kategori . "', '" . $keterangan . "', '" . $gambar . "')");
if (!$result) {
    echo $mysqli->connect_errno . " - " . $mysqli->connect_error;
    exit();
} else {
    echo "<script>
    alert('Tambah Data Berhasil');
    window.location.href='lokasi.php';
    </script>";
}
