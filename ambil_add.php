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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h4 class="card-title">Input Pengambilan Baru</h4>
                        <div class="form-group">
                            <label>Pilih Komplek</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <select class="js-example-basic-single w-100 form-control-sm" name="komplek" required>
                                        <option value=""> -- pilih komplek --</option>
                                        <?php
                                        $sql = mysqli_query($conn2, "SELECT * FROM komplek ");
                                        while ($dv = mysqli_fetch_assoc($sql)) { ?>
                                            <option value="<?= $dv['nama']; ?>"><?= $dv['nama']; ?></option>
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
                        $komplek = $_POST['komplek'];

                        $krm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(a.nominal) AS nom, COUNT(*) AS jml FROM jatah a JOIN tb_santri b ON a.nis=b.nis WHERE b.komplek = '$komplek' "));

                        // $amb = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(nominal) AS nom FROM ambilan WHERE nis = '$nis' "));
                    ?>

                        <br>

                        <hr>
                        <form action="" method="post">
                            <input type="hidden" name="komplek" value="<?= $komplek; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="tgl" id="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Waktu</label>
                                        <div class="col-sm-9">
                                            <input type="time" name="jam" id="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pj/Penerima</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="pj" id="" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Total Nominal</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nominal" readonly class="form-control form-control-sm" value="<?= rupiah($krm['nom']); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jumlah Santri</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="jml_santri" readonly class="form-control form-control-sm" value="<?= $krm['jml']; ?>">
                                        </div>
                                    </div>
                                    <div class="alert alert-primary">
                                        <b>
                                            <center>Harap cek kembali setelah membuat pencairan ini !</center>
                                        </b>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="save" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Simpan data</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'foot.php';

if (isset($_POST['save'])) {

    $tgl = $_POST['tgl'];
    $waktu = $_POST['jam'];
    $pj = $_POST['pj'];
    $nominal = preg_replace("/[^0-9]/", "", $_POST['nominal']);
    $jml = $_POST['jml_santri'];
    $komplek = mysqli_real_escape_string($conn, $_POST['komplek']);
    $kode = rand();
    $ket = 'Jatah harian';

    $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kolek WHERE komplek = '$komplek' AND tgl = '$tgl' "));
    if ($cek > 0) {
        echo "
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Komlek ini sudah melakukan pengambilan pada tanggal ini'
                    })
                    var millisecondsToWait = 2000;
                    setTimeout(function() {
                        document.location.href = 'ambil_kl.php'
                    }, millisecondsToWait);

                });
            </script> ";
    } else {
        $sql = mysqli_query($conn, "INSERT INTO kolek VALUES ('', '$komplek', '$tgl', '$waktu', '$nominal', '$pj', '$jml', '$kode', NOW()) ");
        $dts = mysqli_query($conn, "SELECT * FROM jatah a JOIN tb_santri b ON a.nis=b.nis WHERE b.komplek = '$komplek' ");

        while ($ar = mysqli_fetch_assoc($dts)) {
            $nisbead = $ar['nis'];
            $nmnm = $ar['nominal'];

            $sql2 = mysqli_query($conn, "INSERT INTO ambilan VALUES ('', '$nisbead', '$tgl', '$waktu', '$nmnm', '$ket', '-', '$kode', NOW()) ");
        }

        if ($sql && $sql2) {
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
                        document.location.href = 'ambil_kl.php'
                    }, millisecondsToWait);

                });
            </script>
        ";
        }
    }
}

?>