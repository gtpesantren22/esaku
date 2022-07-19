<?php
include 'head.php';
include 'koneksi.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Data Pengambilan
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Pengambilan Individu</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h4 class="card-title">Input Pengambilan Baru</h4>
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
                        <br>
                        <div class="alert alert-success">
                            <b>
                                <center>Sisa Uang : <?= rupiah($sisu); ?></center>
                            </b>
                        </div>
                        <!-- <small style="color: red;"><i>Pengambilan Max. 20.000 sehari. Boleh lebih asal dengan keterangan jelas</i></small> -->
                        <hr>
                        <form action="" method="post">
                            <input type="hidden" name="nis" value="<?= $nis; ?>">
                            <input type="hidden" name="sisu" value="<?= $sisu; ?>">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nominal</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nominal" id="uang" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea name="ket" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="save" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Simpan data</button>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pengambilan hari ini
                        <span class="badge badge-pill badge-primary "><?= date('d-M-Y'); ?></span>
                        <button class="btn btn-warning btn-sm btn-rounded"><i class="fa fa-list"></i> Lihat Semua Data</button>
                    </h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jam</th>
                                            <th>Nominal</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $now = date('Y-m-d');
                                        $sql = mysqli_query($conn, "SELECT a.*, b.nama FROM ambilan a JOIN tb_santri b ON a.nis=b.nis WHERE b.aktif = 'Y' AND a.tanggal = '$now' ");
                                        while ($dt = mysqli_fetch_assoc($sql)) {
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $dt['nama']; ?></td>
                                                <td><?= $dt['waktu']; ?></td>
                                                <td><?= rupiah($dt['nominal']); ?></td>
                                                <td>
                                                    <i class="fas fa-pencil-alt" data-toggle="modal" data-target="#ex<?= $dt['id_ambilan']; ?>"></i>
                                                    <a href=" hapus.php?kode=amb&id=<?= $dt['id_ambilan']; ?>" onclick="return confirm('Yakin akan dihapus ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                                <div class="modal fade" id="ex<?= $dt['id_ambilan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel-2">Edit Data Pengambilan</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="" method="post">
                                                                    <div class="form-group row">
                                                                        <div class="col-3">
                                                                            <label for="">Nama</label>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <input type="text" name="nama" class="form-control form-control-sm" value="<?= $dt['nama']; ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-3">
                                                                            <label for="">Nominal</label>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <input type="text" name="nominal" id="uang" class="form-control form-control-sm" value="<?= $dt['nominal']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-success">Submit</button>
                                                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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

if (isset($_POST['save'])) {

    $nis = $_POST['nis'];
    $nominal = preg_replace("/[^0-9]/", "", $_POST['nominal']);
    $tgl = date('Y-m-d');
    $waktu = date('H:s');
    $ket = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['ket']));
    $sisu = $_POST['sisu'];
    $kode = rand();

    if ($nominal > $sisu) {
        echo "
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: 'Pengambilan melebihi sisa uang'
                    })
                    var millisecondsToWait = 1500;
                    setTimeout(function() {
                        document.location.href = 'ambil.php';
                    }, millisecondsToWait);

                });
            </script>
        ";
    } else {
        $sql = mysqli_query($conn, "INSERT INTO ambilan VALUES ('', '$nis', '$tgl', '$waktu', '$nominal', '$ket', '-', '$kode', NOW()) ");
        if ($sql) {
            echo "
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Pengambilan uang berhasil'
                    })
                    var millisecondsToWait = 2000;
                    setTimeout(function() {
                        document.location.href = 'ambil.php'
                    }, millisecondsToWait);

                });
            </script>
        ";
        }
    }
}
?>