<?php

session_start();

include 'koneksi.php';

$id = $_GET['id'];

$latlng = $_POST['lat_lng'];
$nama = $_POST['nama_lokasi'];
$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

$gambar = $_FILES['gambar']['name'];

if (!empty($gambar)) {
    // hapus gambar yang sudah ada
    $query = "SELECT `gambar` FROM `lokasi` WHERE `id_lokasi` = '$id'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // hapus gambar yang sudah ada
        unlink("assets/img/" . $row['gambar']);
    }
    // upload gambar baru
    $dir = "assets/img/";
    $dirFile = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($dirFile, $dir . $gambar);
}


$query = "UPDATE `lokasi` SET `lat_lng` = '$latlng', `nama_lokasi` = '$nama', `kategori` = '$kategori', `keterangan` = '$keterangan', `gambar` = '$gambar' WHERE `id_lokasi` = '$id'";

$result = $mysqli->query($query);

if (!$result) {
    echo $mysqli->connect_errno . " - " . $mysqli->connect_error;
    exit();
} else {
    echo "<script>
    alert('Edit data berhasil');
    window.location.href='lokasi.php';
    </script>";
}
