<?php
session_start();
if ($_SESSION['login'] != 'login') header('Location: login.php');
include 'koneksi.php';

$id = $_GET['id'];

$query = "SELECT * FROM `lokasi` WHERE `id_lokasi` = '$id'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
}

?>

<?php include 'lib/navbar.php'; ?>
<style>
	.form-spacing {
		margin-bottom: 1.0rem;
		/* Adjust this value as needed for more/less spacing */
	}

	#map {
		height: 70vh;
		width: 100%;
		/* Adjust width to fit your needs */
		margin-left: 0%;
		margin-right: auto;
	}

	.flex-container {
		display: flex;
		justify-content: center;
	}
</style>

<script src="path/to/leaflet.js"></script> <!-- Ensure you have the Leaflet JS -->

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					<?php if ($_SESSION['level'] == 'admin') { ?>
						<li><a href="user.php">User <span class="sr-only">(current)</span></a></li>
					<?php } ?>
					<li><a href="peta.php">Peta</a></li>
					<li><a href="diagram.php">Diagram</a></li>
					<li class="active"><a href=#>Lokasi</a></li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
				<h2 class="page-header">Form Update Lokasi</h2>
				<div class="col-lg-7 flex-container"> <!-- col-lg-12 for proper width -->
					<div id="map"></div>
				</div>
				<div class="col-lg-5" style="padding: left 0;">
					<div class="card">
						<div class="card-body">
							<form class="form-horizontal" action="proses_update_lokasi.php?id=<?php echo $id; ?>" method="POST">
								<div class="form-group"><label for="Alamat" class="col-sm-2 control-label">Latitude, Longitude</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="lat_lng" id="lat_lng" value="<?php echo $row['lat_lng'] ?>" placeholder="Masukkan Latitude" required />
									</div>
								</div>
								<div class="form-group">
									<label for="nama" class="col-sm-2 control-label">Nama Lokasi</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="nama_lokasi" id="nama_lokasi" value="<?php echo $row['nama_lokasi'] ?>" placeholder="Masukkan Nama Lokasi" required />
									</div>
								</div>
								<div class="form-group">
									<label for="kategori" class="col-sm-2 control-label">Kategori</label>
									<div class="col-sm-10">
										<input type="hidden" name="kat" id="kat" value="<?php echo $row['kategori'] ?>">
										<select name="kategori" id="kategori" class="form-control">
											<option selected disabled>Pilih Kategori</option>
											<option value="Kampus">Kampus</option>
											<option value="SMA">SMA</option>
											<option value="SMP">SMP</option>
											<option value="SD">SD</option>
											<option value="TK">TK</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo $row['keterangan'] ?>" placeholder="Masukkan Keterangan" required />
									</div>
								</div>
								<div class="form-group">
									<label for="gambar" class="col-sm-2 control-label">Gambar</label>
									<div class="col-sm-10">
										<input type="file" class="form-control" id="gambar" name="gambar">

									</div>
								</div>



								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="reset" class="btn btn-danger">Reset</button>
										<a type="cancel" class="btn btn-warning" href="lokasi.php">Cancel</a>
										<button type="submit" class="btn btn-primary">Update Data Baru</button>
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-8 flex-container" style="padding-right:0">
					<div id="map"></div>
				</div>

			</div>
		</div>
	</div>
</body>

<script>
	var map = L.map('map').setView([-3.998019418824216, 122.51193301744776], 13);
	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

	$(document).ready(function() {
		console.log("ready!");
		let kat = $('#kat').val();
		$('#kategori').val(kat).change();

	});
	// Add a marker to the map

	var marker = L.marker([<?php echo $row['lat_lng']; ?>]).addTo(map);

	marker.bindPopup("<b><?php echo $row['nama_lokasi']; ?></b><br /><?php echo $row['lat_lng']; ?> <br />Kategori : <?php echo $row['kategori']; ?><br />Keterangan : <?php echo $row['keterangan']; ?><br /><img src='assets/img/<?php echo $row['gambar'] ?>' alt='' width='150px'>  ");
</script>