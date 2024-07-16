<?php

session_start();

include 'koneksi.php';

$id = $_GET['id'];

$query = "SELECT `gambar` FROM `lokasi` WHERE `id_lokasi` = '$id'";

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // hapus gambar yang sudah ada
    unlink("assets/img/" . $row['gambar']);
}

$query = "DELETE FROM `lokasi` WHERE `id_lokasi` = '$id'";

$result = $mysqli->query($query);

if (!$result) {
    echo $mysqli->connect_errno . " - " . $mysqli->connect_error;
    exit();
} else {
    header('Location: lokasi.php');
}
