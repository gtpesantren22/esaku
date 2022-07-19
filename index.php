<?php
include 'head.php';
include 'koneksi.php';

$all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) as tot FROM kiriman"));
$ambil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) as tot FROM ambilan"));
$sisa = $all['tot'] - $ambil['tot'];
?>

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      Dashboard
    </h3>
  </div>
  <div class="row grid-margin">

    <div class="col-12">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="statistics-item">
              <p>
                <i class="icon-sm fa fa-credit-card mr-2"></i>
                Semua Kiriman
              </p>
              <h2><?= rupiah($all['tot']); ?></h2>
              <label class="badge badge-outline-success badge-pill">Jumlah total semua kiriman santri</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                Kiriman Sudah diambil
              </p>
              <h2><?= rupiah($ambil['tot']); ?></h2>
              <label class="badge badge-outline-danger badge-pill"><?= round(($ambil['tot'] / $all['tot']) * 100, 1); ?>% sudah diambil</label>
            </div>
            <div class="statistics-item">
              <p>
                <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                Sisa Saldo Kiriman
              </p>
              <h2><?= rupiah($sisa); ?></h2>
              <label class="badge badge-outline-success badge-pill"><?= round(($sisa / $all['tot']) * 100, 1); ?>% belum diambil</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            <i class="fas fa-gift"></i>
            Orders
          </h4>
          <canvas id="orders-chart"></canvas>
          <div id="orders-chart-legend" class="orders-chart-legend"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">
            <i class="fas fa-chart-line"></i>
            Sales
          </h4>
          <h2 class="mb-5">56000 <span class="text-muted h4 font-weight-normal">Sales</span></h2>
          <!-- <canvas id="sales-chart"></canvas> -->
        </div>
      </div>
    </div>
  </div>

</div>
<!-- content-wrapper ends -->

<?php include 'foot.php'; ?>