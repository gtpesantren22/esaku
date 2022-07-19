<?php
include 'head.php';
include 'koneksi.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Data santri
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Santri</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data santri putri</h4>
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
                                    <th>Kamar</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = mysqli_query($conn, "SELECT * FROM tb_santri WHERE jkl = 'Perempuan' AND aktif = 'Y' ");
                                while ($dt = mysqli_fetch_assoc($sql)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dt['nama']; ?></td>
                                        <td><?= $dt['desa'] . ' - ' . $dt['kec'] . ' - ' . $dt['kab']; ?></td>
                                        <td><?= $dt['k_formal'] . ' ' . $dt['t_formal']; ?></td>
                                        <td><?= $dt['kamar'] . ' - ' . $dt['komplek']; ?></td>
                                        <td>
                                            <button class="btn btn-outline-primary">Detail</button>
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
<?php include 'foot.php'; ?>