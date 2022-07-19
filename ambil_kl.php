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
                <li class="breadcrumb-item active" aria-current="page">Data Pengambilan Kolektif</li>
            </ol>
        </nav>
    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pengambilan hari ini
                        <span class="badge badge-pill badge-primary "><?= date('d-M-Y'); ?></span>
                        <button class="btn btn-warning btn-sm btn-rounded"><i class="fa fa-list"></i> Lihat Semua Data</button>
                        <a href="ambil_add.php" class="btn btn-success btn-sm btn-rounded float-right"><i class="fa fa-plus-circle"></i> Buat Baru</a>
                    </h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Komplek</th>
                                            <th>Nominal</th>
                                            <th>Pengambil</th>
                                            <th>Tanggal</th>
                                            <th>Jml Santri</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $now = date('Y-m-d');
                                        $sql = mysqli_query($conn, "SELECT * FROM kolek WHERE tgl = '$now' ");
                                        while ($dt = mysqli_fetch_assoc($sql)) {
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $dt['komplek']; ?></td>
                                                <td><?= rupiah($dt['nominal']); ?></td>
                                                <td><?= $dt['pj']; ?></td>
                                                <td><?= $dt['tgl'] . ' ' . $dt['jam']; ?></td>
                                                <td><?= $dt['jml_santri']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Act
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                                                            <a class="dropdown-item" href="ambil_detail.php?kd=<?= $dt['kode']; ?>">Details</a>
                                                            <a class="dropdown-item" href="hapus.php?kode=kole&id=<?= $dt['kode']; ?>" onclick="return confirm('Yakin akan dihapus ? ini kan menghapus data pengambilan santri juga')">Delete</a>
                                                        </div>
                                                    </div>
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


?>