<?php
include 'head.php';
include 'koneksi.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Data Jatah
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Jatah</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data jatah harian santri
                <button type="button" data-toggle="modal" data-target="#genu" class="btn btn-danger btn-sm float-right"><i class="fa fa-retweet"></i> Generate Ulang</button>

                <button class="btn btn-success btn-sm float-right" type="button" data-toggle="modal" data-target="#add"><i class="fa fa-plus-circle"></i> Tambah</button>
            </h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kelas</th>
                                    <th>Nominal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = mysqli_query($conn, "SELECT a.*, b.* FROM jatah a JOIN tb_santri b ON a.nis=b.nis WHERE b.aktif = 'Y' ");
                                while ($dt = mysqli_fetch_assoc($sql)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dt['nama']; ?></td>
                                        <td><?= $dt['desa'] . ' - ' . $dt['kec'] . ' - ' . $dt['kab']; ?></td>
                                        <td><?= $dt['k_formal'] . ' ' . $dt['t_formal']; ?></td>
                                        <td><?= rupiah($dt['nominal']) ?></td>
                                        <td>
                                            <button class="btn btn-outline-warning" type="button" data-toggle="modal" data-target="#genu<?= $dt['id_jatah']; ?>">Edit</button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="genu<?= $dt['id_jatah']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel-3">
                                                        Edit Nominal Maks
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="" method="post">
                                                    <input type="hidden" name="nis" value="<?= $dt['nis']; ?>">
                                                    <div class="modal-body">
                                                        <input type="text" name="nominal" id="uang" class="form-control" placeholder="Masukan nominal maksimal" required value="<?= $dt['nominal']; ?>"> <br>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="submit" name="edit" class="btn btn-success">
                                                            Submit
                                                        </button>
                                                        <button type="button" class="btn btn-light" data-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Ends -->
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="genu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel-3">
                    Generate Ulang
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="text" name="nominal" id="uang" class="form-control" placeholder="Masukan nominal maksimal" required> <br>
                    <p>Fitur ini akan men-generate ulang semua jatah harian santri</p>
                    <p>Yakin akan dilanjutkan ?</p>
                </div>
                <div class="modal-footer">

                    <button type="submit" name="gene" class="btn btn-success">
                        Submit
                    </button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Ends -->

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Tambah Data Santri
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="data" class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kelas</th>
                                <th>Nominal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = mysqli_query($conn, "SELECT * FROM tb_santri WHERE aktif = 'Y' AND NOT EXISTS (SELECT nis FROM jatah WHERE tb_santri.nis=jatah.nis) ");
                            while ($dt = mysqli_fetch_assoc($sql)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $dt['nama']; ?></td>
                                    <td><?= $dt['desa'] . ' - ' . $dt['kec'] . ' - ' . $dt['kab']; ?></td>
                                    <td><?= $dt['k_formal'] . ' ' . $dt['t_formal']; ?></td>
                                    <td><?= rupiah(10000); ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="nis" value="<?= $dt['nis']; ?>">
                                            <button type="submit" name="add" class="btn btn-outline-success">Pilih</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">
                    Submit
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ends -->

<?php
include 'foot.php';

if (isset($_POST['gene'])) {
    mysqli_query($conn, "TRUNCATE TABLE jatah");
    $nominal = preg_replace("/[^0-9]/", "", $_POST['nominal']);
    $sql = mysqli_query($conn, "INSERT INTO jatah (nis, nominal) SELECT nis, '$nominal' FROM tb_santri WHERE aktif = 'Y' ");
    if ($sql) {
        echo "
            <script>
                window.location = 'jatah.php';
            </script>
        ";
    }
}

if (isset($_POST['add'])) {
    $nis =  $_POST['nis'];
    $sql = mysqli_query($conn, "INSERT INTO jatah VALUES ('', '$nis', 10000) ");
    if ($sql) {
        echo "
            <script>
                window.location = 'jatah.php';
            </script>
        ";
    }
}

if (isset($_POST['edit'])) {
    $nis =  $_POST['nis'];
    $nominal = preg_replace("/[^0-9]/", "", $_POST['nominal']);

    $sql = mysqli_query($conn, "UPDATE jatah SET nominal = '$nominal' WHERE nis = '$nis' ");
    if ($sql) {
        echo "
            <script>
                window.location = 'jatah.php';
            </script>
        ";
    }
}
?>