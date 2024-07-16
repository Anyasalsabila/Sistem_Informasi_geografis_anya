<?php
session_start();
if ($_SESSION['login'] != 'login') header('Location: login.php');
include 'koneksi.php';   // include = menambahkan/mengikutkan file, setting koneksi ke database
?>
<?php
include 'lib/navbar.php';
?>

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
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div>
          <a type="button" class="btn btn-primary" href="tambah_lokasi.php">Tambah Data</a>
        </div>
        <br>
        <div>
          <table id="example1" class="table table-bordered table-striped dataTable" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Latitude, Longitude</th>
                <th>Nama Lokasi</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tfoot>
              <tr role="row">
                <th>No</th>
                <th>Latitude, Longitude</th>
                <th>Nama Lokasi</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
              <?php
              $result = $mysqli->query("SELECT * FROM lokasi");
              if ($result->num_rows > 0) {
                // echo "User ada";
                $no = 1;
                while ($row = $result->fetch_assoc()) {
              ?>
                  <tr class="odd">
                    <td class=" "><?php echo $no++; ?></td>
                    <td class=" "><?php echo $row['lat_lng']; ?></td>
                    <td class=" "><?php echo $row['nama_lokasi']; ?></td>
                    <td class=" "><?php echo ucfirst($row['kategori']); ?></td>
                    <td class=" "><?php echo ucfirst($row['keterangan']); ?></td>
                    <td class=" "><img src="assets/img/<?php echo $row['gambar']; ?>" width="100px"></td>
                    <td class=" ">
                      <a type="button" class="btn btn-warning btn-xs" href="update_lokasi.php?id=<?php echo $row['id_lokasi']; ?>">Update</a>
                      <a type="button" class="btn btn-danger btn-xs" href="delete_lokasi.php?id=<?php echo $row['id_lokasi']; ?>" onClick="return confirm('Menghapus data lokasi <?php echo $row['nama_lokasi']; ?> ?');">Delete</a>
                    </td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- DATA TABES SCRIPT -->
  <script src="js/jquery.dataTables.js" type="text/javascript"></script>
  <script src="js/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src="js/dataTables.tableTools.min.js" type="text/javascript"></script>
  <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
  <script src="js/holder.min.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  <!-- page script -->
  <script type="text/javascript">
    $(function() {
      $("#example1").dataTable();
      $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
      });
    });
  </script>
</body>

</html>