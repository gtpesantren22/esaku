<?php
include 'head.php';
include 'koneksi.php';

$kode = $_GET['kd'];
$dt_am = mysqli_query($conn, "SELECT a.*, b.nama, b.k_formal, b.t_formal FROM ambilan a JOIN tb_santri b ON a.nis=b.nis WHERE a.kode = '$kode' ORDER BY b.nama ");
$hrmdt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kolek WHERE kode = '$kode' "));
$hrmdt2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS jm_amb, COUNT(*) AS jm_ss FROM ambilan WHERE kode = '$kode' "));

?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Data Pengambilan
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Pengambilan Kolektif</li>
            </ol>
        </nav>
    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <form action="" method="post">
                            <input type="hidden" name="kode" value="<?= $kode; ?>">
                            <input type="hidden" name="nominal" value="<?= $hrmdt2['jm_amb'] ?>">
                            <input type="hidden" name="jml_santri" value="<?= $hrmdt2['jm_ss'] ?>">
                            <span class="badge badge-pill badge-primary ">Pengambilan Tanggal : <?= $hrmdt['tgl']; ?></span>
                            <span class="badge badge-pill badge-warning ">Komplek : <?= $hrmdt['komplek']; ?></span>
                            <span class="badge badge-pill badge-danger ">Total : <?= rupiah($hrmdt2['jm_amb']); ?></span>
                            <button type="submit" name="updd" class="btn btn-success btn-sm btn-rounded float-right"><i class="fa fa-check-circle"></i> Simpan Perubahan</button>
                            <a href="cetak.php" class="btn btn-info btn-sm btn-rounded float-right" type="submit" name="updd"><i class="fa fa-print"></i> Catak</a>
                        </form>
                    </h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Pengambilan</th>
                                            <th>Sisa Uang</th>
                                            <th>Ket</th>
                                            <th>#</th>
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
                                            $amb = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS nom FROM ambilan WHERE nis = '$nis' AND tanggal != '$tgl' "));
                                            $sisu = $krm['nom'] - $amb['nom'];
                                            if ($sisu >= $nomab) {
                                                $kt = "<td style='color: green; font-weight: bold;'><i class='fa fa-check'></i> Uang cukup</td>";
                                            } else {
                                                $kt = "<td style='color: red; font-weight: bold;'><i class='fa fa-times'></i> Uang kurang</td>";
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $dt['nama']; ?></td>
                                                <td><?= $dt['k_formal'] . ' - ' . $dt['t_formal']; ?></td>
                                                <td><?= rupiah($dt['nominal']); ?></td>
                                                <td><?= rupiah($sisu); ?></td>
                                                <?= $kt; ?>
                                                <td>
                                                    <a href="hapus.php?kode=ambdt&id=<?= $dt['id_ambilan']; ?>" onclick="return confirm('Yakin akan dihapus ?')" class="btn btn-danger btn-sm">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'foot.php';

if (isset($_POST['updd'])) {
    $kode = $_POST['kode'];
    $nominal = $_POST['nominal'];
    $jml_santri = $_POST['jml_santri'];

    $sql = mysqli_query($conn, "UPDATE kolek SET nominal = '$nominal', jml_santri = '$jml_santri' WHERE kode = '$kode' ");
    $link = 'ambil_detail.php?kd=' . $kode;
    echo "
    <script>
        window.location = 'ambil_kl.php';
    </script>
    ";
}

?>