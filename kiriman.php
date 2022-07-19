<?php
include 'head.php';
include 'koneksi.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Data Kiriman santri
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Kiriman</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data pengiriman santri</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Nominal</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sql = mysqli_query($conn, "SELECT a.*, b.nama FROM kiriman a JOIN tb_santri b ON a.nis=b.nis WHERE b.aktif = 'Y' ");
                                        while ($dt = mysqli_fetch_assoc($sql)) {
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $dt['nama']; ?></td>
                                                <td><?= $dt['tanggal']; ?></td>
                                                <td><?= rupiah($dt['nominal']); ?></td>
                                                <td>
                                                    <a href="edt_kr.php?id=<?= $dt['id_kiriman']; ?>">
                                                        <button class="btn btn-outline-warning"><i class="fas fa-pencil-alt"></i></button>
                                                    </a>
                                                    <a href="hapus.php?kode=krm&id=<?= $dt['id_kiriman']; ?>" onclick="return confirm('Yakin akan dihapus ?')">
                                                        <button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                                    </a>
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

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h4 class="card-title">Input Kiriman Baru</h4>
                        <div class="form-group">
                            <label>Pilih Santri</label>
                            <select class="js-example-basic-single w-100 form-control-sm" name="nis" required>
                                <option value=""> -- pilih nama --</option>
                                <?php
                                $sql = mysqli_query($conn, "SELECT * FROM tb_santri WHERE aktif = 'Y' ");
                                while ($dv = mysqli_fetch_assoc($sql)) { ?>
                                    <option value="<?= $dv['nis']; ?>"><?= $dv['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal dikirim</label>
                            <div id="datepicker-popup" class="input-group date datepicker">
                                <input type="text" name="tgl" class="form-control form-control-sm" required>
                                <span class="input-group-addon input-group-append border-left">
                                    <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" name="nominal" id="uang" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Pengiriman Via</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="via" value="Cash">
                                    Cash
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="via" value="Transfer">
                                    Transfer
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Upload Bukti Transfer (boleh dikosongi)</label>
                            <input type="file" name="bukti" id="" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="save" class="btn btn-primary btn-icon-text">
                                <i class="far fa-check-square btn-icon-prepend"></i>
                                Tambahkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'foot.php';

if (isset($_POST['save'])) {

    $nis = $_POST['nis'];
    $tgl = explode('/', $_POST['tgl']);
    $tglOk = $tgl[2] . '-' . $tgl[0] . '-' . $tgl[1];
    $nominal = preg_replace("/[^0-9]/", "", $_POST['nominal']);
    $via = $_POST['via'];

    $bukti = $_FILES['bukti']['name'];

    if (!empty($bukti)) {

        $nm = explode('.', $bukti);
        $nama_baru = end($nm);
        $nama_bukti = uniqid() . '.' . $nama_baru;
        move_uploaded_file($_FILES['bukti']['tmp_name'], 'images/bukti/' . $nama_bukti);
    } else {
        $nama_bukti = '-';
    }

    $sql = mysqli_query($conn, "INSERT INTO kiriman VALUES ('', '$nis','$tglOk','$nominal','$via','$nama_bukti','-', NOW()) ");
    if ($sql) {
        echo "
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Input data berhasil'
                    })
                    var millisecondsToWait = 1500;
                    setTimeout(function() {
                        document.location.href = 'kiriman.php'
                    }, millisecondsToWait);

                });
            </script>
        ";
    }
}
?>