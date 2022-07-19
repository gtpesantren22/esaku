<?php
include 'head.php';
include 'koneksi.php';

$id = $_GET['id'];
$dt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT a.*, b.nama FROM kiriman a JOIN tb_santri b ON a.nis = b.nis WHERE id_kiriman = $id "));

$tgl = explode('-', $dt['tanggal']);
// 2022-04-09
$tglOk = $tgl[1] . '/' . $tgl[2] . '/' . $tgl[0];
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <h4 class="card-title">Input Kiriman Baru</h4>
                        <div class="form-group">
                            <label>Nama Santri</label>
                            <input type="text" name="" class="form-control form-control-sm" value="<?= $dt['nama']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tanggal dikirim</label>
                            <div id="datepicker-popup" class="input-group date datepicker">
                                <input type="text" name="tgl" class="form-control form-control-sm" value="<?= $tglOk; ?>" required>
                                <span class="input-group-addon input-group-append border-left">
                                    <span class="far fa-calendar input-group-text"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nominal</label>
                            <input type="text" name="nominal" id="uang" class="form-control form-control-sm" value="<?= $dt['nominal']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Pengiriman Via</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="via" value="Cash" <?= $dt['via'] == 'Cash' ? 'checked' : '' ?>>
                                    Cash
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="via" value="Transfer" <?= $dt['via'] == 'Transfer' ? 'checked' : '' ?>>
                                    Transfer
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Upload Bukti Transfer (boleh dikosongi)</label><br>
                            <img src="images/bukti/<?= $dt['bukti']; ?>" alt="" height="100">
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

    // $nis = $_POST['nis'];
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
        $nama_bukti = $dt['bukti'];
    }

    $sql = mysqli_query($conn, "UPDATE kiriman SET tanggal = '$tglOk', nominal = '$nominal', via = '$via', bukti = '$nama_bukti' WHERE id_kiriman = $id ");
    if ($sql) {
        echo "
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Edit data berhasil'
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