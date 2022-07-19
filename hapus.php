<?php
include 'koneksi.php';

$kode = $_GET['kode'];

$id = $_GET['id'];

if ($kode == 'krm') {
    $sql = mysqli_query($conn, "DELETE FROM kiriman WHERE id_kiriman =  $id ");

    if ($sql) {
        echo "
        <script>
            alert('Data kiriman sudah dihapus');
            window.location = 'kiriman.php';
        </script>
        ";
    }
}
if ($kode == 'amb') {
    $sql = mysqli_query($conn, "DELETE FROM ambilan WHERE id_ambilan =  $id ");

    if ($sql) {
        echo "
        <script>
            alert('Data pengambilan sudah dihapus');
            window.location = 'ambil.php';
        </script>
        ";
    }
}

if ($kode == 'ambdt') {
    $dt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ambilan WHERE id_ambilan = '$id' "));
    $sql = mysqli_query($conn, "DELETE FROM ambilan WHERE id_ambilan =  $id ");
    $link = 'ambil_detail.php?kd=' . $dt['kode'];

    if ($sql) {
        echo "
        <script>
            window.location = '" . $link . "';
        </script>
        ";
    }
}

if ($kode == 'kole') {
    $sql = mysqli_query($conn, "DELETE FROM kolek WHERE kode =  '$id' ");
    $sql2 = mysqli_query($conn, "DELETE FROM ambilan WHERE kode =  '$id' ");

    if ($sql) {
        echo "
        <script>
            alert('Data pengambilan sudah dihapus');
            window.location = 'ambil_kl.php';
        </script>
        ";
    }
}
