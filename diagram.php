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
          <li class="active"><a href="diagram.php">Diagram</a></li>
          <li><a href="lokasi.php">Lokasi</a></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-9 col-sm-offset-2">
      <main id="main" class="main">
        <div class="page-title mb-3">
          <h2>Diagram</h2>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bar CHart</h5>

              <?php
              $query = "SELECT * FROM lokasi WHERE kategori = 'BRI'";
              $result = $mysqli->query($query);
              $jmlbri = $result->num_rows;

              $query = "SELECT * FROM lokasi WHERE kategori = 'BNI'";
              $result = $mysqli->query($query);
              $jmlbni = $result->num_rows;

              $query = "SELECT * FROM lokasi WHERE kategori = 'Mandiri'";
              $result = $mysqli->query($query);
              $jmlmandiri = $result->num_rows;

              $query = "SELECT * FROM lokasi WHERE kategori = 'BPD'";
              $result = $mysqli->query($query);
              $jmlbpd = $result->num_rows;

              $query = "SELECT * FROM lokasi WHERE kategori = 'BSI'";
              $result = $mysqli->query($query);
              $jmlbsi = $result->num_rows;


              ?>
              <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px;"></canvas>
              <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  const ctx = document.getElementById('barChart').getContext('2d');
                  new Chart(ctx, {
                    type: 'bar',
                    data: {
                      labels: ['BRI', 'BNI', 'MANDIRI', 'BPD', 'BSI'],
                      datasets: [{
                        label: 'Bar Chart',
                        data: [<?php echo $jmlbri; ?>, <?php echo $jmlbni; ?>, <?php echo $jmlmandiri; ?>, <?php echo $jmlbpd; ?>, <?php echo $jmlbsi; ?>],
                        backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(54, 162, 235, 0.2)',

                        ],
                        borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(54, 162, 235)',

                        ],
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Bar CHart -->

            </div>
          </div>
        </div>
    </div>
  </div>
</body>