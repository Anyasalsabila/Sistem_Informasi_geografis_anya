<?php
session_start();
if ($_SESSION['login'] != 'login') {
    header('Location: login.php');
    exit();
}
?>
<?php include 'lib/navbar.php';
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi</title>
    <link rel="stylesheet" href="path/to/leaflet.css"> <!-- Ensure you have the Leaflet CSS -->
    <style>
        .form-spacing {
            margin-bottom: 1.0rem;
            /* Adjust this value as needed for more/less spacing */
        }

        #map {
            height: 70vh;
            width: 80%;
            /* Adjust width to fit your needs */
            margin-left: 25%;
            margin-right: auto;
        }

        .flex-container {
            display: flex;
            justify-content: center;
        }
    </style>
    <script src="path/to/leaflet.js"></script> <!-- Ensure you have the Leaflet JS -->
</head>

<body>
    <div class="container-fluid">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <?php if ($_SESSION['level'] == 'admin') { ?>
                    <li><a href="user.php">User <span class="sr-only">(current)</span></a></li>
                <?php } ?>
                <li><a href="peta.php">Peta</a></li>
                <li><a href="diagram.php">Diagram</a></li>
                <li class="active"><a href="lokasi.php">Lokasi</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                <h2>Tambah Lokasi</h2>
            </div>
        </div>

        <div class="col-lg-8 flex-container"> <!-- col-lg-12 for proper width -->
            <div id="map"></div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3 mt" action="proses_tambah_lokasi.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3 form-spacing">
                            <label for="latlng" class="form-label">Latitude, Longitude</label>
                            <input type="text" class="form-control" id="latlng" name="latlng" placeholder="Klik Lokasi Pada Peta Untuk Mengisi Latitude, Longitude" required>
                        </div>
                        <div class="mb-3 form-spacing">
                            <label for="nama" class="form-label">Nama Lokasi</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lokasi">
                        </div>
                        <div class="mb-3 form-spacing">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" name="kategori" id="kategori">
                                <option selected disabled>Pilih Kategori</option>
                                <option value="BRI">Bank Rakyat Indonesia (BRI)</option>
                                <option value="BNI">Bank Negara Indonesia (BNI)</option>
                                <option value="mandiri">Bank Mandiri</option>
                                <option value="BPD">Bank Pembangunan Daerah (BPD)</option>
                                <option value="BSI">Bank Syariah Indonesia (BSI)</option>
                            </select>
                        </div>
                        <div class="mb-3 form-spacing">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
                        </div>
                        <div class="mb-3 form-spacing">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <div class="mb-3">
                            <a href="lokasi.php" type="reset" class="btn btn-warning">Cancel</a>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
    </main>
    </div>


    <?php include 'lib/footer.php'; ?>

    <script>
        var map = L.map('map').setView([-3.998019418824216, 122.51193301744776], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(map);

            var latlng = e.latlng;
            var lat = latlng.lat.toFixed(6);
            var lng = latlng.lng.toFixed(6);
            var latlng_format = lat + ',' + lng;

            document.getElementById('latlng').value = latlng_format
        }

        map.on('click', onMapClick);

        // Add a marker to the map
        <?php
        $result = $mysqli->query("SELECT * FROM lokasi");

        while ($row = $result->fetch_assoc()) {
        ?>
            var marker = L.marker([<?php echo $row['lat_lng']; ?>]).addTo(map);

            marker.bindPopup("<b><?php echo $row['nama_lokasi']; ?></b><br /><?php echo $row['lat_lng']; ?> <br />Kategori : <?php echo $row['kategori']; ?><br />Keterangan : <?php echo $row['keterangan']; ?><br /><img src='assets/img/<?php echo $row['gambar'] ?>' alt='' width='150px'>  ");
        <?php
        }

        ?>
    </script>
</body>

</html>