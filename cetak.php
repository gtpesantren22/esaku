<?php
include 'koneksi.php';

$kode = $_GET['kode'];
$dt_am = mysqli_query($conn, "SELECT a.*, b.nama, b.k_formal, b.t_formal, b.kamar FROM ambilan a JOIN tb_santri b ON a.nis=b.nis WHERE a.kode = '$kode' ORDER BY b.nama ");
$hrmdt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kolek WHERE kode = '$kode' "));
$hrmdt2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS jm_amb, COUNT(*) AS jm_ss FROM ambilan WHERE kode = '$kode' "));

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cetak Data</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>

    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <h4 class="text-center">List Pengambilan Uang Saku Santri</h4>
                    <h4 class="text-center">Pondok Pesantran Darul Lughah Wal Karomah</h4>
                    <hr>
                    <table>
                        <tr>
                            <th>Tanggal</th>
                            <th> : <?= $hrmdt['tgl']; ?></th>
                        </tr>
                        <tr>
                            <th>Komplek</th>
                            <th> : <?= $hrmdt['komplek']; ?></th>
                        </tr>
                        <tr>
                            <th> Jml Santri Mengambil</th>
                            <th> : <?= $hrmdt2['jm_ss']; ?> santri</th>
                        </tr>
                        <tr>
                            <th> Total Uang</th>
                            <th> : <?= rupiah($hrmdt2['jm_amb']); ?></th>
                        </tr>
                    </table>
                    <hr>
                    <div class="table-responsive">
                        <table id="" class="table table-sm table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kamar</th>
                                    <th>Kelas</th>
                                    <th>Diambil</th>
                                    <th>Sisa Uang</th>
                                    <th>Ket</th>
                                    <th>TTD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;

                                while ($dt = mysqli_fetch_assoc($dt_am)) {
                                    $nis = $dt['nis'];
                                    $nomab = $dt['nominal'];
                                    $tgl = $dt['tanggal'];

                                    $krm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS nom FROM kiriman WHERE nis = '$nis' "));
                                    $amb = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS nom FROM ambilan WHERE nis = '$nis'  "));
                                    $sisu = $krm['nom'] - $amb['nom'];
                                    if ($sisu >= $nomab) {
                                        $kt = "<td style='color: green; '><i class='fa fa-check'></i> </td>";
                                    } else {
                                        $kt = "<td style='color: red; '><i class='fa fa-times'></i> </td>";
                                    }
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dt['nama']; ?></td>
                                        <td><?= $dt['kamar']; ?></td>
                                        <td><?= $dt['k_formal'] . ' - ' . $dt['t_formal']; ?></td>
                                        <td><?= rupiah($dt['nominal']); ?></td>
                                        <td><?= rupiah($sisu); ?></td>
                                        <?= $kt; ?>
                                        <td>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" style="font-weight: bold; font-size: 17px;">Penerima</th>
                                <th class="text-center" style="font-weight: bold; font-size: 17px;">Petugas Bendahara</th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="font-weight: bold; font-size: 17px; text-decoration: underline;"><?= $hrmdt['pj']; ?></th>
                                <th class="text-center" style="font-weight: bold; font-size: 17px; text-decoration: underline;"><?= $hrmdt['pj']; ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script>
        window.print();
    </script>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- <script src="vendors/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script> -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
</body>


</html>