<?php
include 'head.php';
include 'koneksi.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Cek Pengambilan Santri
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Pengambilan</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h4 class="card-title">Cek Pengambilan Santri</h4>
                        <div class="form-group">
                            <label>Pilih Santri</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <select class="js-example-basic-single w-100 form-control-sm" name="nis" required>
                                        <option value=""> -- pilih nama --</option>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM tb_santri WHERE aktif = 'Y' ");
                                        while ($dv = mysqli_fetch_assoc($sql)) { ?>
                                            <option value="<?= $dv['nis']; ?>"><?= $dv['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success btn-sm" type="submit" name="cek"><i class="fa fa-search"></i> Cek</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['cek'])) {
                        $nis = $_POST['nis'];
                        $hsl = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_santri WHERE nis = '$nis' "));
                        $krm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS nom FROM kiriman WHERE nis = '$nis' "));
                        $amb = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS nom FROM ambilan WHERE nis = '$nis' "));
                        $sisu = $krm['nom'] - $amb['nom'];
                    ?>
                        <div class="row">
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <th>Nama</th>
                                        <th> : <?= $hsl['nama']; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th> : <?= $hsl['desa'] . ' - ' . $hsl['kec'] . ' - ' . $hsl['kab']; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <th> : <?= $hsl['k_formal'] . ' ' . $hsl['t_formal']; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Kamar</th>
                                        <th> : <?= $hsl['kamar'] . ' / ' . $hsl['komplek']; ?></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <div class="alert alert-success">
                                    <b>
                                        <h4>
                                            <center>Sisa Uang : <?= rupiah($sisu); ?></center>
                                            </h3>
                                    </b>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-6">
                                <div class="card-body">
                                    <h4 class="card-title">Riwayat Kiriman
                                    </h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="" class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Via</th>
                                                            <th>Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $sql = mysqli_query($conn, "SELECT a.*, b.nama FROM kiriman a JOIN tb_santri b ON a.nis=b.nis WHERE a.nis = '$nis' ");
                                                        while ($dt = mysqli_fetch_assoc($sql)) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= $dt['tanggal']; ?></td>
                                                                <td><?= $dt['via']; ?></td>
                                                                <td><?= rupiah($dt['nominal']); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-body">
                                    <h4 class="card-title">Riwayat Pengambilan
                                    </h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="" class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jam</th>
                                                            <th>Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $now = date('Y-m-d');
                                                        $sql = mysqli_query($conn, "SELECT a.*, b.nama FROM ambilan a JOIN tb_santri b ON a.nis=b.nis WHERE a.nis = '$nis' ");
                                                        while ($dt = mysqli_fetch_assoc($sql)) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= $dt['tanggal']; ?></td>
                                                                <td><?= $dt['waktu']; ?></td>
                                                                <td><?= rupiah($dt['nominal']); ?></td>

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

                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
include 'foot.php';

?>