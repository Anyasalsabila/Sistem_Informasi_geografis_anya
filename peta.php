<?php
session_start();
if ($_SESSION['login'] != 'login') {
  header('Location: login.php');
  exit();
}
include 'koneksi.php';   // include = menambahkan/mengikutkan file, setting koneksi ke database

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Map Page</title>
  <link rel="stylesheet" href="path/to/leaflet.css"> <!-- Ensure you have the Leaflet CSS -->
  <style>
    #map {
      height: 80vh;
      width: 80%;
      /* Adjust width to fit your needs */
      margin-left: 17%;
      margin-right: 25;
      margin-top: 20px;
    }

    .flex-container {
      display: flex;
      justify-content: center;
    }
  </style>
  <script src="path/to/leaflet.js"></script> <!-- Ensure you have the Leaflet JS -->
</head>

<body>
  <?php include 'lib/navbar.php'; ?>

  <main id="main" class="main">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        <?php if ($_SESSION['level'] == 'admin') : ?>
          <li><a href="user.php">User <span class="sr-only">(current)</span></a></li>
        <?php endif; ?>
        <li class="active"><a href="peta.php">Peta</a></li>
        <li><a href="diagram.php">Diagram</a></li>
        <li><a href="lokasi.php">Lokasi</a></li>
      </ul>
    </div>
    <h1 class="text-center" style="margin-left: 80px;">Peta Lokasi Bank di Kota Kendari</h1>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <div class="search-bar mb-3">
        <form class="search-form d-flex align-items-center" method="post" action="#">
          <input type="text" name="keyword" class="form-control" placeholder="Masukkan kata kunci...">
          <button type="submit" class="btn btn-primary" title="Search" name="cari"><i class="bi bi-search"></i>Search</button>
          <button type="reset" class="btn btn-secondary"><i class="bi bi-x"></i>Reset</button>
          <a href="peta.php" type="submit" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
        </form>
      </div>
    </div>


    <section class="section">
      <div class="row">
        <div class="col-lg-12 flex-container">
          <div id="map"></div>
        </div>
      </div>
    </section>
    </div>
  </main>



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
    }

    map.on('click', onMapClick);

    // Add a marker to the map
    <?php
    if (isset($_POST['cari'])) {
      $keyword = $_POST['keyword'];
      $result = $mysqli->query("SELECT * FROM lokasi WHERE nama_lokasi LIKE '%" . $keyword . "%' OR kategori LIKE '%" . $keyword . "%' OR keterangan LIKE '%" . $keyword . "%'");
    } else {
      $result = $mysqli->query("SELECT * FROM lokasi");
    }

    while ($row = $result->fetch_assoc()) {
    ?>
      var marker = L.marker([<?php echo $row['lat_lng']; ?>], {
        icon: L.icon({
          iconUrl: 'assets/img/Money Bill Alt_8.png',
          iconSize: [40, 40]
        })
      }).addTo(map);

      marker.bindPopup("<b><?php echo $row['nama_lokasi']; ?></b><br /><?php echo $row['lat_lng']; ?> <br />Kategori : <?php echo $row['kategori']; ?><br />Keterangan : <?php echo $row['keterangan']; ?><br />");
    <?php
    }

    ?>
  </script>
</body>

</html>